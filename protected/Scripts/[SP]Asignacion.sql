-- Function: spPeriodoActivo(integer,integer,integer,integer)

-- DROP FUNCTION spPeriodoActivo(integer,integer,integer,integer);

CREATE OR REPLACE FUNCTION spPeriodoActivo(
    _ciclo integer,
	_tipoperiodo integer,
	_tipoasignacion integer,
	_centrounidad integer,
	out periodo integer,
	out tipoasign integer)
  RETURNS SETOF record AS
$BODY$
begin
IF _tipoasignacion <> 1 THEN
 Return query select per.periodo, per.tipoasignacion
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.centro_unidadacademica = _centrounidad and current_date between per.fechainicial and per.fechafinal and per.estado = 1;
ELSE
 Return query select per.periodo, per.tipoasignacion
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.tipoasignacion = _tipoasignacion and per.centro_unidadacademica = _centrounidad and per.estado = 1;
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
 WHERE s.curso = idCurso and a.estado = 1;
  
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
    _secciones text,
    OUT seccionTraslapada integer,
    OUT traslapeCurso boolean)
  RETURNS setof RECORD AS
$BODY$
begin
RETURN query
         Select distinct v1.seccion, v1.traslape from (select t.trama, t.dia, t.inicio, t.fin, t.seccion, cu.traslape from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo join cur_seccion se on se.seccion = t.seccion join cur_curso cu on cu.curso = se.curso where t.seccion in (select cast(sec.regexp_split_to_table as integer) from (select * from regexp_split_to_table(_secciones, ';') where regexp_split_to_table <> '') sec)) v1 
         join (select t.trama, t.dia, t.inicio, t.fin, t.seccion, cu.traslape from cur_trama t join cur_horario h on t.trama = h.trama and h.ciclo = _ciclo join cur_seccion se on se.seccion = t.seccion join cur_curso cu on cu.curso = se.curso where t.seccion in (select cast(sec.regexp_split_to_table as integer) from (select * from regexp_split_to_table(_secciones, ';') where regexp_split_to_table <> '') sec)) v2 
         on v1.trama != v2.trama and v1.dia = v2.dia 
         where v1.inicio < v2.fin and v1.fin > v2.inicio;
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

  
-- Function: spoportunidadactualcursoestudiante(integer, integer)

-- DROP FUNCTION spoportunidadactualcursoestudiante(integer, integer);

CREATE OR REPLACE FUNCTION spoportunidadactualcursoestudiante(
    _estudiante integer,
    _curso integer)
  RETURNS integer AS
$BODY$
DECLARE oportunidad INTEGER;
begin
  
 SELECT COALESCE(MAX(a.OportunidadActual),0) INTO oportunidad
 FROM EST_CUR_Asignacion a 
 JOIN EST_Ciclo_Asignacion ca on ca.Ciclo_Asignacion = a.Ciclo_Asignacion and ca.Estudiante = _estudiante 
 JOIN CUR_Seccion s on s.seccion = a.seccion
 WHERE s.curso = _curso and a.estado = 1;

 RETURN oportunidad;
 
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spoportunidadactualcursoestudiante(integer, integer)
  OWNER TO postgres;
  
  
-- Function: spobtenercuposeccion(integer, integer)

-- DROP FUNCTION spobtenercuposeccion(integer, integer);

CREATE OR REPLACE FUNCTION spobtenercuposeccion(
    _ciclo integer,
    _seccion integer)
  RETURNS integer AS
$BODY$
DECLARE cupo INTEGER;
begin
  
 SELECT count(a.Asignacion) INTO cupo
 FROM EST_CUR_Asignacion a 
 JOIN EST_Ciclo_Asignacion ca on ca.Ciclo_Asignacion = a.Ciclo_Asignacion
 JOIN CUR_Seccion s on s.seccion = a.seccion and a.seccion = _seccion
 JOIN ADM_Periodo p on p.periodo = ca.periodo
 WHERE p.ciclo = _ciclo and a.estado = 1;
 RETURN cupo;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spobtenercuposeccion(integer, integer)
  OWNER TO postgres;

  

-- Function: spobtenerboletaasignacion(integer, integer, integer, integer)

-- DROP FUNCTION spobtenerboletaasignacion(integer, integer, integer, integer);

CREATE OR REPLACE FUNCTION spobtenerboletaasignacion(
    _ciclo integer,
    _estudiante integer,
    _carrera integer,
    _id integer,
    out Asignacion integer,
    out Fecha text,
    out Hora text,
    out CodigoCurso text,
    out NombreCurso text,
    out NombreSeccion text,
    out NombreDia text,
    out Inicio text,
    out Fin text,
    out tipoasign text,
    out estado text,
    out anio integer,
    out ciclo integer,
    out estudiante integer,
    out carnetNombre text,
    out carrera integer,
    out NombreCarrera text)
  RETURNS setof record AS
$BODY$
begin
if _id <> -1 then
--si es búsqueda por ID
  Return query
  SELECT ca.Ciclo_Asignacion, to_char(ca.fecha, 'DD/MM/YYYY'), to_char(ca.hora, 'HH24:MI'), cu.codigo, cu.nombre, sec.nombre, dia.nombre, to_char(tra.inicio, 'HH24:MI'), to_char(tra.fin, 'HH24:MI'), tasi.nombre,
  case when cura.estado = 1 then 'Activo' else 'Inactivo' end,
  cic.anio, cic.ciclo, estu.estudiante,
  '[' || estu.carnet || '] ' || estu.primerapellido || ' ' || estu.segundoapellido || ', ' || estu.primernombre || ' ' || estu.segundonombre,
  car.carrera, car.nombre
  FROM EST_CICLO_ASIGNACION ca
  JOIN ADM_PERIODO p ON ca.periodo = p.periodo
  JOIN EST_CUR_ASIGNACION cura on cura.Ciclo_Asignacion = ca.Ciclo_Asignacion and cura.Ciclo_Asignacion = _id
  JOIN CUR_SECCION sec on cura.seccion = sec.seccion
  JOIN CUR_CURSO cu on cu.curso = sec.curso
  JOIN CUR_TRAMA tra on tra.seccion = cura.seccion
  JOIN CUR_HORARIO hor on hor.trama = tra.trama
  JOIN CUR_DIA dia on dia.codigo = tra.dia
  JOIN ADM_TIPOASIGNACION tasi on tasi.tipoasignacion = p.tipoasignacion 
  JOIN CUR_CICLO cic on p.ciclo = cic.ciclo
  JOIN EST_ESTUDIANTE estu on ca.estudiante = estu.estudiante
  JOIN CUR_CARRERA car on car.carrera = ca.carrera
  order by ca.Ciclo_Asignacion, cu.codigo, dia.codigo, tra.inicio;

else
--si es por ciclo, estudiante y carrera
  Return query
  SELECT ca.Ciclo_Asignacion, to_char(ca.fecha, 'DD/MM/YYYY'), to_char(ca.hora, 'HH24:MI'), cu.codigo, cu.nombre, sec.nombre, dia.nombre, to_char(tra.inicio, 'HH24:MI'), to_char(tra.fin, 'HH24:MI'), tasi.nombre,
  case when cura.estado = 1 then 'Activo' else 'Inactivo' end,
  cic.anio, cic.ciclo, estu.estudiante,
  '[' || estu.carnet || '] ' || estu.primerapellido || ' ' || estu.segundoapellido || ', ' || estu.primernombre || ' ' || estu.segundonombre,
  car.carrera, car.nombre
  FROM EST_CICLO_ASIGNACION ca
  JOIN ADM_PERIODO p ON ca.periodo = p.periodo AND p.ciclo = _ciclo
  JOIN EST_CUR_ASIGNACION cura on cura.Ciclo_Asignacion = ca.Ciclo_Asignacion and cura.estado = 1
  JOIN CUR_SECCION sec on cura.seccion = sec.seccion
  JOIN CUR_CURSO cu on cu.curso = sec.curso
  JOIN CUR_TRAMA tra on tra.seccion = cura.seccion
  JOIN CUR_HORARIO hor on hor.trama = tra.trama and hor.ciclo = _ciclo
  JOIN CUR_DIA dia on dia.codigo = tra.dia
  JOIN ADM_TIPOASIGNACION tasi on tasi.tipoasignacion = p.tipoasignacion
  JOIN CUR_CICLO cic on p.ciclo = cic.ciclo
  JOIN EST_ESTUDIANTE estu on ca.estudiante = estu.estudiante
  JOIN CUR_CARRERA car on car.carrera = ca.carrera
  WHERE ca.estudiante = _estudiante AND ca.carrera = _carrera order by ca.Ciclo_Asignacion, cu.codigo, dia.codigo, tra.inicio;
end if;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spobtenerboletaasignacion(integer, integer, integer, integer)
  OWNER TO postgres;
  
  
-- Function: spobtenernotaasignacion(integer, integer, integer)

-- DROP FUNCTION spobtenernotaasignacion(integer, integer, integer);

CREATE OR REPLACE FUNCTION spobtenernotaasignacion(
    _ciclo integer,
    _estudiante integer,
    _carrera integer,
    out Asignacion integer,
    out Fecha text,
    out Hora text,
    out CodigoCurso text,
    out NombreCurso text,
    out NombreSeccion text,
    out Zona float,
    out Final float,
    out Total text,
    out EstadoNota text,
    out tipoasign text,
	out estado text,
    out anio integer,
    out ciclo integer,
    out estudiante integer,
    out carnetNombre text,
    out carrera integer,
    out NombreCarrera text)
  RETURNS setof record AS
$BODY$
begin
  Return query
  SELECT ca.Ciclo_Asignacion, to_char(ca.fecha, 'DD/MM/YYYY'), to_char(ca.hora, 'HH24:MI'), cu.codigo, cu.nombre, sec.nombre, nota.zona, nota.final, 
  CASE WHEN nota.total = 0 and nota.aprobacion = 2 THEN 'APROBADO' WHEN nota.total = 0 and nota.aprobacion = -2 THEN 'REPROBADO' ELSE cast(nota.total as text) END as total, 
  estnota.nombre, tasi.nombre,
  case when cura.estado = 1 then 'Activo' else 'Inactivo' end,
  cic.anio, cic.ciclo, estu.estudiante,
  '[' || estu.carnet || '] ' || estu.primerapellido || ' ' || estu.segundoapellido || ', ' || estu.primernombre || ' ' || estu.segundonombre,
  car.carrera, car.nombre
  FROM EST_CICLO_ASIGNACION ca
  JOIN ADM_PERIODO p ON ca.periodo = p.periodo AND p.ciclo = _ciclo
  JOIN EST_CUR_ASIGNACION cura on cura.Ciclo_Asignacion = ca.Ciclo_Asignacion and cura.estado = 1
  JOIN CUR_SECCION sec on cura.seccion = sec.seccion
  JOIN CUR_CURSO cu on cu.curso = sec.curso
  JOIN EST_CUR_NOTA nota on cura.asignacion = nota.asignacion
  JOIN CUR_ESTADONOTA estnota on nota.estadonota = estnota.estadonota
  JOIN ADM_TIPOASIGNACION tasi on tasi.tipoasignacion = p.tipoasignacion
  JOIN CUR_CICLO cic on p.ciclo = cic.ciclo
  JOIN EST_ESTUDIANTE estu on ca.estudiante = estu.estudiante
  JOIN CUR_CARRERA car on car.carrera = ca.carrera
  WHERE ca.estudiante = _estudiante AND ca.carrera = _carrera order by ca.Ciclo_Asignacion, cu.codigo;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spobtenernotaasignacion(integer, integer, integer)
  OWNER TO postgres;
  
  
-- Function: spobtenerintentoasignacion(integer, integer, integer, integer, integer)

-- DROP FUNCTION spobtenerintentoasignacion(integer, integer, integer, integer, integer);

CREATE OR REPLACE FUNCTION spobtenerintentoasignacion(
    _ciclo integer,
    _estudiante integer,
    _carrera integer,
    _tipoperiodo integer,
	_tipoasignacion integer)
  RETURNS INTEGER AS
$BODY$
begin
  Return (
  SELECT count(distinct(ca.Ciclo_asignacion))
  FROM EST_CICLO_ASIGNACION ca
  JOIN ADM_PERIODO p ON ca.periodo = p.periodo AND p.ciclo = _ciclo
  JOIN EST_CUR_ASIGNACION cura on cura.Ciclo_Asignacion = ca.Ciclo_Asignacion
  WHERE ca.estudiante = _estudiante AND ca.carrera = _carrera AND p.tipoasignacion = _tipoasignacion AND p.tipoperiodo = _tipoperiodo
  ) ::INTEGER;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spobtenerintentoasignacion(integer, integer, integer, integer, integer)
  OWNER TO postgres; 
  
  
-- Function: spcreditoscursosaprobados(integer, integer, integer)

-- DROP FUNCTION spcreditoscursosaprobados(integer, integer, integer);

CREATE OR REPLACE FUNCTION spcreditoscursosaprobados(
    IN _estudiante integer,
	IN _carrera integer)
  RETURNS INTEGER AS
$BODY$
begin
 Return (
 select coalesce(sum(coalesce(curpen.creditos, 0)),0)
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
	      join
		cur_pensum_area curpen on curpen.curso = sec.curso
	      where ca.estudiante = _estudiante and ca.carrera = _carrera

	 ) ::INTEGER;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcreditoscursosaprobados(integer, integer)
  OWNER TO postgres;
 
  

-- Function: spdesactivarasignacionanterior(integer, integer, integer, integer)

-- DROP FUNCTION spdesactivarasignacionanterior(integer, integer, integer, integer);

CREATE OR REPLACE FUNCTION spdesactivarasignacionanterior(
    _nuevaAsign integer,
    _estudiante integer,
    _carrera integer,
    _periodo integer)
  RETURNS integer AS
$BODY$
begin
 UPDATE EST_CUR_Asignacion set Estado = -1 WHERE asignacion in(
	select cura.asignacion from EST_CUR_Asignacion cura 
	join EST_Ciclo_Asignacion cicla on cura.Ciclo_Asignacion = cicla.Ciclo_Asignacion 
		and cicla.Estudiante = _estudiante and cicla.carrera = _carrera and cicla.periodo = _periodo and cicla.Ciclo_Asignacion <> _nuevaAsign);
 RETURN 1;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spdesactivarasignacionanterior(integer, integer, integer, integer)
  OWNER TO postgres;
  
-- Function: splistadocursosaprobados(integer, integer)

-- DROP FUNCTION splistadocursosaprobados(integer, integer);

CREATE OR REPLACE FUNCTION splistadocursosaprobados(
    _estudiante integer,
    _carrera integer,
    out cursoaprobado integer,
    out estudiante integer, 
	out nombreestudiante text, 
	out carnet integer,
	out carrera integer,
	out nombrecarrera text,
	out asignacion integer,
	out numero integer,
	out codigo text, 
	out asignatura text,
	out tipoaprobacion integer,
	out nombretipoaprobacion text,
	out calificacionnumeros text,
	out fechaaprobacion date,
	out estadoasignacion integer)
  RETURNS setof record AS
$BODY$
begin
  Return query
	SELECT notas.cursoaprobado, notas.estudiante, notas.nombreestudiante, notas.carnet, notas.carrera, notas.nombrecarrera, notas.asignacion, notas.numero, notas.codigo, notas.asignatura, notas.tipoaprobacion, notas.nombretipoaprobacion, notas.calificacionennumeros, notas.fechaaprobacion, notas.estadoasignacion
FROM (
	select ca.cursoaprobado, ciclo.estudiante, concat(est.primernombre || ' ' || est.segundonombre || ' ' || est.primerapellido || ' ' || est.segundoapellido) as nombreestudiante, est.carnet, estcar.carrera, car.nombre as nombrecarrera, asig.asignacion, curso.curso as numero, curso.codigo as codigo, curso.nombre as asignatura, tipo.tipoaprobacion, tipo.nombre as nombretipoaprobacion, CASE WHEN nota.total = 0 and nota.aprobacion = 2 THEN 'APROBADO' WHEN nota.total = 0 and nota.aprobacion = -2 THEN 'REPROBADO' ELSE cast(nota.total as text) END as calificacionennumeros, ca.fechaaprobacion, asig.estado as estadoasignacion
	from est_cursoaprobado ca
	join est_cur_asignacion asig on asig.asignacion = ca.asignacion
	join est_ciclo_asignacion ciclo on ciclo.ciclo_asignacion = asig.ciclo_asignacion
	join est_estudiante_carrera estcar on estcar.estudiante = ciclo.estudiante
	join est_estudiante est on est.estudiante = ciclo.estudiante
	join cur_carrera car on car.carrera = estcar.carrera
	join est_cur_nota nota on nota.asignacion = asig.asignacion
	join cur_seccion sec on sec.seccion = asig.seccion
	join cur_pensum_area curpen on curpen.cursopensumarea = sec.curso
	join cur_curso curso on curso.curso = curpen.curso
	join cur_tipoaprobacion tipo on tipo.tipoaprobacion = ca.tipoaprobacion
	where asig.estado IN (1,-3)

	UNION

	select ca.cursoaprobado, ciclo.estudiante, concat(est.primernombre || ' ' || est.segundonombre || ' ' || est.primerapellido || ' ' || est.segundoapellido) as nombreestudiante, est.carnet, estcar.carrera, car.nombre as nombrecarrera, asigretra.asignacionretrasada, curso.curso as numero, curso.codigo as codigo, curso.nombre as asignatura, tipo.tipoaprobacion as nombretipoaprobacion, tipo.nombre, cast(coalesce(asigretra.notaretrasada,0) as text) as calificacionennumeros, ca.fechaaprobacion, asig.estado as estadoasignacion
	from est_cursoaprobado ca
	join est_asignacionretrasada asigretra on asigretra.asignacionretrasada = ca.asignacionretrasada
	join est_cur_asignacion asig on asigretra.asignacion = asig.asignacion
	join est_ciclo_asignacion ciclo on ciclo.ciclo_asignacion = asig.ciclo_asignacion
	join est_estudiante_carrera estcar on estcar.estudiante = ciclo.estudiante
	join est_estudiante est on est.estudiante = ciclo.estudiante
	join cur_carrera car on car.carrera = estcar.carrera
	join cur_seccion sec on sec.seccion = asig.seccion
	join cur_pensum_area curpen on curpen.cursopensumarea = sec.curso
	join cur_curso curso on curso.curso = curpen.curso
	join cur_tipoaprobacion tipo on tipo.tipoaprobacion = ca.tipoaprobacion
	where asig.estado IN (1,-3)
) as notas
WHERE notas.estudiante = _estudiante
AND notas.carrera = _carrera
ORDER BY notas.codigo, notas.fechaaprobacion;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION splistadocursosaprobados(integer, integer)
  OWNER TO postgres;
  
  
  -- Function: spcursosdisponiblesasignacionretrasada(integer, integer, integer)

-- DROP FUNCTION spcursosdisponiblesasignacionretrasada(integer, integer, integer);

CREATE OR REPLACE FUNCTION spcursosdisponiblesasignacionretrasada(
    IN _ciclo integer,
    IN _carrera integer,
    IN _estudiante integer,
    OUT curso integer,
    OUT codigo text,
    OUT nombre text,
    OUT traslape boolean,
	OUT seccion integer,
	OUT nombreSeccion text,
	OUT carnet integer,
	OUT nombreEstudiante text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select distinct cc.curso, cc.codigo, cc.nombre, cc.traslape, cs.seccion, cs.nombre, ee.carnet, (ee.primerNombre || ' ' || ee.segundoNombre || ' ' || ee.primerApellido || '' || ee.segundoApellido)
	     from est_cur_asignacion eca
	join est_ciclo_asignacion ecla on eca.ciclo_asignacion = ecla.ciclo_asignacion and eca.estado = 1
	join cur_seccion cs on eca.seccion = cs.seccion
	join cur_curso cc on cs.curso = cc.curso and cc.estado = 1
	join adm_periodo ap on ecla.periodo = ap.periodo and ap.ciclo = _ciclo and ap.estado = 1
	join est_estudiante_carrera ec on ec.estudiante = _estudiante and ec.carrera = _carrera
	join est_estudiante ee on ee.estudiante = ec.estudiante;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spcursosdisponiblesasignacionretrasada(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spdatosextraboletaretrasada(integer, integer)

-- DROP FUNCTION spdatosextraboletaretrasada(integer, integer);

CREATE OR REPLACE FUNCTION spdatosextraboletaretrasada(
    IN _ciclo integer,
    IN _retrasada integer,
    OUT numerociclo integer,
    OUT anio integer,
    OUT tipociclo integer,
    OUT rubro integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select c.numerociclo, c.anio, c.tipociclo, 
 case 
 when c.numerociclo = 1 and _retrasada = 4 then 4 
 when c.numerociclo = 1 and _retrasada = 5 then 5
 when c.numerociclo = 2 and _retrasada = 4 then 6
 when c.numerociclo = 2 and _retrasada = 5 then 7
 end
	from cur_ciclo c where c.ciclo = _ciclo;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatosextraboletaretrasada(integer, integer)
  OWNER TO postgres;
  
Select 'Script de Asignaciones Instalado' as "Asignacion";