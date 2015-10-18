-- Function: spPeriodoActivo(integer,integer,integer,integer)

-- DROP FUNCTION spPeriodoActivo(integer,integer,integer,integer);

CREATE OR REPLACE FUNCTION spPeriodoActivo(
    _ciclo integer,
	_tipoperiodo integer,
	_tipoasignacion integer,
	_centrounidad integer)
  RETURNS INTEGER AS
$BODY$
begin
IF _tipoasignacion <> 1 THEN
 Return (select per.periodo
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.centro_unidadacademica = _centrounidad and current_date between per.fechainicial and per.fechafinal and per.estado = 1) ::INTEGER;
ELSE
 Return (select per.periodo
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.tipoasignacion = _tipoasignacion and per.centro_unidadacademica = _centrounidad and per.estado = 1) ::INTEGER;
END IF;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spPeriodoActivo(integer,integer,integer,integer)
  OWNER TO postgres;
  
  
-- Function: spcursosdisponiblesasignacion(integer, integer, integer)

-- DROP FUNCTION spcursosdisponiblesasignacion(integer, integer, integer);

CREATE OR REPLACE FUNCTION spcursosdisponiblesasignacion(
    IN _ciclo integer,
    IN _carrera integer,
	IN _estudiante integer,
    OUT curso integer,
    OUT codigo text,
    OUT nombre text,
    OUT traslape boolean)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select distinct cur.curso, cur.codigo, cur.nombre, cur.traslape
	      from 
	        cur_curso cur
	      join
	        cur_pensum_area curpen on curpen.curso = cur.curso
	      join
	        adm_pensum pen on curpen.pensum = pen.pensum
	      join
	        cur_seccion sec on curpen.curso = sec.curso
	      join
	        cur_trama tra on tra.seccion = sec.seccion
	      join
	        cur_horario hor on hor.trama = tra.trama
		  join
			est_estudiante_carrera ec on ec.estudiante = _estudiante and ec.carrera = _carrera
	      where hor.ciclo = _ciclo and hor.estado = 1 and pen.carrera = _carrera and ec.fechaingreso between pen.iniciovigencia and coalesce(pen.finvigencia,current_date);
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spcursosdisponiblesasignacion(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spagregarasignacion(integer, integer, integer)

-- DROP FUNCTION spagregarasignacion(integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarasignacion(
    _estudiante integer,
	_carrera integer,
    _periodo integer)
  RETURNS integer AS
$BODY$
DECLARE fechaactual DATE;
DECLARE horaactual TIME;
DECLARE idAs INTEGER;
begin
 SELECT current_date into fechaactual;
 SELECT current_time into horaactual;
 INSERT INTO EST_Ciclo_Asignacion (Estudiante, Carrera, Periodo, Fecha, Hora) values (_estudiante, _carrera, _periodo, fechaactual, horaactual) RETURNING Ciclo_Asignacion INTO idAs;
 RETURN idAs;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarasignacion(integer, integer, integer)
  OWNER TO postgres;
  
  
  
-- Function: spagregarcursoasignacion(integer, integer, integer, text)

-- DROP FUNCTION spagregarcursoasignacion(integer, integer, integer, text);

CREATE OR REPLACE FUNCTION spagregarcursoasignacion(
    _estudiante integer,
    _cicloasignacion integer,
    _seccion integer,
    _adjuntos text)
  RETURNS integer AS
$BODY$
DECLARE oportunidad INTEGER;
DECLARE idAs INTEGER;
DECLARE idCurso INTEGER;
begin
 SELECT c.curso INTO idCurso from CUR_CURSO c join CUR_Seccion s on s.curso = c.curso and s.seccion = _seccion;   
  
 SELECT COALESCE(MAX(a.OportunidadActual),0) INTO oportunidad
 FROM EST_CUR_Asignacion a 
 JOIN EST_Ciclo_Asignacion ca on ca.Ciclo_Asignacion = a.Ciclo_Asignacion and ca.Estudiante = _estudiante 
 JOIN CUR_Seccion s on s.seccion = a.seccion
 WHERE s.curso = idCurso;
  
 INSERT INTO EST_CUR_Asignacion (OportunidadActual, Estado, Seccion, Ciclo_Asignacion, Adjuntos) values (oportunidad + 1, 1, _seccion, _cicloasignacion, _adjuntos) RETURNING Asignacion INTO idAs;
 RETURN idAs;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcursoasignacion(integer, integer, integer, text)
  OWNER TO postgres;

  
-- Function: spdatoscursopensum(integer, integer, integer)

-- DROP FUNCTION spdatoscursopensum(integer, integer, integer);

CREATE OR REPLACE FUNCTION spdatoscursopensum(
    IN _curso integer,
    IN _carrera integer,
	IN _estudiante integer,
    OUT cursopensumarea integer,
    OUT curso integer,
    OUT pensum integer,
    OUT numerociclo integer,
    OUT tipociclo integer,
    OUT creditos integer,
    OUT prerrequisitos text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select distinct curpen.cursopensumarea, curpen.curso, curpen.pensum, curpen.numerociclo, curpen.tipociclo, curpen.creditos, curpen.prerrequisitos
	      from 
	        cur_curso cur
	      join
	        cur_pensum_area curpen on curpen.curso = cur.curso
	      join
	        adm_pensum pen on curpen.pensum = pen.pensum
		  join
			est_estudiante_carrera ec on ec.estudiante = _estudiante and ec.carrera = _carrera
	      where curpen.curso = _curso and curpen.estado = 1 and pen.carrera = _carrera and ec.fechaingreso between pen.iniciovigencia and coalesce(pen.finvigencia,current_date);
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscursopensum(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spdatoscursoaprobado(integer, integer, integer)

-- DROP FUNCTION spdatoscursoaprobado(integer, integer, integer);

CREATE OR REPLACE FUNCTION spdatoscursoaprobado(
    IN _curso integer,
    IN _estudiante integer,
	IN _carrera integer,
    OUT cursoaprobado integer,
    OUT asignacion integer,
    OUT asignacionretrasada integer,
    OUT tipoaprobacion integer,
    OUT fechaaprobacion date)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select cur.cursoaprobado, cur.asignacion, cur.asignacionretrasada, cur.tipoaprobacion, cur.fechaaprobacion
	      from 
	        est_cursoaprobado cur
	      join
	        est_cur_nota nota on nota.asignacion = cur.asignacion
	      join
	        est_cur_asignacion asign on asign.asignacion = nota.asignacion
	      join 
		cur_seccion sec on sec.seccion = asign.seccion 
	      join 
	        est_ciclo_asignacion ca on ca.ciclo_asignacion = asign.ciclo_asignacion
	      where sec.curso = _curso and ca.estudiante = _estudiante and ca.carrera = _carrera;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscursoaprobado(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spobtenercursostraslapados(integer, text)

-- DROP FUNCTION spobtenercursostraslapados(integer, text);

CREATE OR REPLACE FUNCTION spobtenercursostraslapados(
    _ciclo integer,
    _secciones text)
  RETURNS integer AS
$BODY$
begin
RETURN (
         Select count(distinct v1.seccion) from (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v1 
         join (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v2 
         on v1.trama != v2.trama and v1.dia = v2.dia 
         where v1.inicio < v2.fin and v1.fin > v2.inicio
       ) ::integer;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spobtenercursostraslapados(integer, text)
  OWNER TO postgres;

  
-- Function: spobtenertiempotraslapeentrecursosdia(integer, text, integer)

-- DROP FUNCTION spobtenertiempotraslapeentrecursosdia(integer, text, integer);

CREATE OR REPLACE FUNCTION spobtenertiempotraslapeentrecursosdia(
    IN _ciclo integer,
    IN _secciones text,
    IN _maxminutos integer,
    OUT traslape bigint,
    OUT dia integer,
    OUT seccion1 integer,
    OUT seccion2 integer)
  RETURNS SETOF record AS
$BODY$
begin
RETURN query
Select sum(case when v1.fin - v2.inicio > v2.fin - v1.inicio then cast(EXTRACT(EPOCH FROM v2.fin - v1.inicio)/60 as integer) else cast(EXTRACT(EPOCH FROM v1.fin - v2.inicio)/60 as integer) end) as what, v1.dia, v1.seccion, v2.seccion
	from (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v1 
        join (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v2 
        on v1.trama != v2.trama and v1.dia = v2.dia 
        where v1.inicio < v2.fin and v1.fin > v2.inicio
        group by v1.dia, v1.seccion, v2.seccion having sum(case when v1.fin - v2.inicio > v2.fin - v1.inicio then cast(EXTRACT(EPOCH FROM v2.fin - v1.inicio)/60 as integer) else cast(EXTRACT(EPOCH FROM v1.fin - v2.inicio)/60 as integer) end) > _maxminutos;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spobtenertiempotraslapeentrecursosdia(integer, text, integer)
  OWNER TO postgres;

  
-- Function: spobtenertiempotraslapeentrecursossemana(integer, text, integer)

-- DROP FUNCTION spobtenertiempotraslapeentrecursossemana(integer, text, integer);

CREATE OR REPLACE FUNCTION spobtenertiempotraslapeentrecursossemana(
    IN _ciclo integer,
    IN _secciones text,
    IN _maxminutos integer,
    OUT traslape bigint,
    OUT seccion1 integer,
    OUT seccion2 integer)
  RETURNS SETOF record AS
$BODY$
begin
RETURN query
Select sum(case when v1.fin - v2.inicio > v2.fin - v1.inicio then cast(EXTRACT(EPOCH FROM v2.fin - v1.inicio)/60 as integer) else cast(EXTRACT(EPOCH FROM v1.fin - v2.inicio)/60 as integer) end) as what, v1.seccion, v2.seccion
	from (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v1 
        join (select t.trama, t.dia, t.inicio, t.fin, t.seccion from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo where seccion in (select cast(sec.seccion as integer) from (select * from regexp_split_to_table(_secciones, ';') as seccion where seccion <> '') sec)) v2 
        on v1.trama != v2.trama and v1.dia = v2.dia 
        where v1.inicio < v2.fin and v1.fin > v2.inicio
        group by v1.seccion, v2.seccion having sum(case when v1.fin - v2.inicio > v2.fin - v1.inicio then cast(EXTRACT(EPOCH FROM v2.fin - v1.inicio)/60 as integer) else cast(EXTRACT(EPOCH FROM v1.fin - v2.inicio)/60 as integer) end) > _maxminutos;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spobtenertiempotraslapeentrecursossemana(integer, text, integer)
  OWNER TO postgres;

  
Select 'Script de Asignaciones Instalado' as "Asignacion";