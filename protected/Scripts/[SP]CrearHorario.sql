-- Function: spagregarcursocatedratico(integer, integer)

-- DROP FUNCTION spagregarcursocatedratico(integer, integer);

CREATE OR REPLACE FUNCTION spagregarcursocatedratico(
    _catedratico integer,
    _curso integer)
  RETURNS integer AS
$BODY$
DECLARE idCursoCatedratico integer;
DECLARE dtfecha date;
BEGIN
SELECT curso_catedratico into idCursoCatedratico FROM cur_curso_catedratico WHERE catedratico = _catedratico AND curso = _curso;
IF idCursoCatedratico IS NOT NULL THEN
	RETURN idCursoCatedratico;
ELSE
	SELECT current_date into dtfecha;
	INSERT INTO cur_curso_catedratico (catedratico, curso, fecha, estado) 
	VALUES (_catedratico, _curso, dtfecha, 1) RETURNING curso_catedratico into idCursoCatedratico;
	RETURN idCursoCatedratico;
END IF;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcursocatedratico(integer, integer)
  OWNER TO postgres;

  
-- Function: spagregartrama(integer, integer, integer, text, text, integer)

-- DROP FUNCTION spagregartrama(integer, integer, integer, text, text, integer);

CREATE OR REPLACE FUNCTION spagregartrama(
    _cursocatedratico integer,
    _dia integer,
    _periodo integer,
    _inicio text,
    _fin text,
    _seccion integer)
  RETURNS integer AS
$BODY$
DECLARE idTrama integer;
BEGIN
	INSERT INTO cur_trama (curso_catedratico, dia, periodo, inicio, fin, seccion) 
	VALUES (_cursocatedratico, _dia, _periodo, cast(_inicio as time), cast(_fin as time), _seccion) RETURNING trama into idTrama;
	RETURN idTrama;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregartrama(integer, integer, integer, text, text, integer)
  OWNER TO postgres;
  
  
-- Function: spagregarhorario(integer, integer, integer, integer)

-- DROP FUNCTION spagregarhorario(integer, integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarhorario(
    _jornada integer,
    _trama integer,
    _ciclo integer,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idHorario integer;
BEGIN
	INSERT INTO cur_horario (jornada, trama, ciclo, estado) 
	VALUES (_jornada, _trama, _ciclo, _estado) RETURNING horario into idHorario;
	RETURN idHorario;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarhorario(integer, integer, integer, integer)
  OWNER TO postgres;
  

-- Function: spagregarhorariosalon(integer, integer)

-- DROP FUNCTION spagregarhorariosalon(integer, integer);

CREATE OR REPLACE FUNCTION spagregarhorariosalon(
    _horario integer,
    _salon integer)
  RETURNS integer AS
$BODY$
DECLARE idHorario integer;
DECLARE idSalon integer;
BEGIN
	SELECT horario into idHorario FROM cur_horario_salon WHERE horario = _horario;
	SELECT salon into idSalon FROM cur_horario_salon WHERE horario = _horario;
IF idHorario IS NOT NULL THEN
	IF idSalon <> _salon THEN
		UPDATE CUR_Horario_Salon SET salon = _salon
		WHERE horario = _horario;
	END IF;
	RETURN idHorario;
ELSE
	INSERT INTO cur_horario_salon (horario, salon) 
	VALUES (_horario, _salon) RETURNING horario into idHorario;
	RETURN idHorario;
END IF;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarhorariosalon(integer, integer)
  OWNER TO postgres;
  
  
-- Function: spinformacionhorario(integer, integer)

-- DROP FUNCTION spinformacionhorario(integer, integer);

CREATE OR REPLACE FUNCTION spinformacionhorario(
    IN _ciclo integer,
    IN _seccion integer,
    OUT idhorario integer,
    OUT jornada text,
    OUT duracion integer,
    OUT dia text,
    OUT inicio text,
    OUT fin text,
    OUT edificio text,
    OUT salon text,
    OUT primernombre text,
    OUT segundonombre text,
    OUT primerapellido text,
    OUT segundoapellido text,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    h.horario,
    j.nombre,
    p.duracionminutos,
    d.nombre,
    to_char(t.inicio, 'HH24:MI'),
    to_char(t.fin, 'HH24:MI'),
    e.nombre,
    s.nombre,
    c.primernombre,
    c.segundonombre,
    c.primerapellido,
    c.segundoapellido,
    case 
	when h.estado=0 then 'Validación Pendiente'
	when h.estado=1 then 'Activo'
	when h.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CUR_Horario h 
    join CUR_Trama t on h.trama = t.trama and t.seccion = _seccion 
    join CUR_Jornada j on j.jornada = h.jornada 
    join CUR_Dia d on d.codigo = t.dia 
    join CUR_Horario_Salon hs on h.horario = hs.horario 
    join CUR_Salon s on s.salon = hs.salon 
    join CUR_Periodo p on p.periodo = t.periodo 
    join CUR_Edificio e on e.edificio = s.edificio 
    join CUR_Curso_Catedratico cc on cc.curso_catedratico = t.curso_catedratico
    join CAT_Catedratico c on c.catedratico = cc.catedratico
  where h.ciclo = _ciclo;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacionhorario(integer, integer)
  OWNER TO postgres;
  
  
-- Function: spactivardesactivarhorario(integer, integer)

-- DROP FUNCTION spactivardesactivarhorario(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarhorario(
    _idhorario integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_horario SET estado = %L WHERE horario = %L',_estadoNuevo,_idhorario);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarhorario(integer, integer)
  OWNER TO postgres;
  

-- Function: spdatoshorario(integer)

-- DROP FUNCTION spdatoshorario(integer);

CREATE OR REPLACE FUNCTION spdatoshorario(
    IN id integer,
    OUT jornada integer,
    OUT trama integer,
    OUT ciclo integer,
    OUT cursocatedratico integer,
    OUT dia integer,
    OUT periodo integer,
    OUT tipoperiodo integer,
    OUT inicio text,
    OUT fin text,
    OUT seccion integer,
    OUT catedratico integer,
    OUT salon integer,
    OUT edificio integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT h.jornada, h.trama, h.ciclo, t.curso_catedratico, t.dia, t.periodo, p.tipoperiodo, to_char(t.inicio, 'HH24:MI') as inicio, to_char(t.fin, 'HH24:MI') as fin, t.seccion, cc.catedratico, hs.salon, s.edificio FROM CUR_Horario h join CUR_Trama t on t.trama = h.trama join CUR_Horario_Salon hs on hs.horario = h.horario join CUR_Salon s on s.salon = hs.salon join CUR_Periodo p on p.periodo = t.periodo join CUR_Curso_Catedratico cc on cc.curso_catedratico = t.curso_catedratico where h.horario = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoshorario(integer)
  OWNER TO postgres;

  
-- Function: spactualizarhorario(integer, integer)

-- DROP FUNCTION spactualizarhorario(integer, integer);

CREATE OR REPLACE FUNCTION spactualizarhorario(
    _jornada integer,
    _idhorario integer)
  RETURNS integer AS
$BODY$
DECLARE idHorario integer;
BEGIN
	UPDATE CUR_Horario SET jornada = _jornada
	WHERE Horario = _idHorario RETURNING Horario into idHorario;
	RETURN idHorario;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarhorario(integer, integer)
  OWNER TO postgres;
  

-- Function: spactualizartrama(integer, integer, integer, text, text, integer)

-- DROP FUNCTION spactualizartrama(integer, integer, integer, text, text, integer);

CREATE OR REPLACE FUNCTION spactualizartrama(
    _cursocatedratico integer,
    _dia integer,
    _periodo integer,
    _inicio text,
    _fin text,
    _idtrama integer)
  RETURNS integer AS
$BODY$
DECLARE idTrama integer;
BEGIN
	UPDATE cur_trama SET curso_catedratico = _cursocatedratico, dia = _dia, periodo = _periodo, inicio = cast(_inicio as time), fin = cast(_fin as time) 
	WHERE trama = _idTrama RETURNING trama into idTrama;
	RETURN idTrama;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizartrama(integer, integer, integer, text, text, integer)
  OWNER TO postgres;

  
-- Function: spdisponibilidadsalon(integer, integer, integer, text, text)

-- DROP FUNCTION spdisponibilidadsalon(integer, integer, integer, text, text);

CREATE OR REPLACE FUNCTION spdisponibilidadsalon(
    _ciclo integer,
    _salon integer,
    _dia integer,
    _inicio text,
    _fin text)
  RETURNS SETOF integer AS
$BODY$
BEGIN
  RETURN query Select 
    h.horario
  from 
    CUR_Horario h 
    join CUR_Trama t on h.trama = t.trama
    join CUR_Dia d on d.codigo = t.dia 
    join CUR_Horario_Salon hs on h.horario = hs.horario 
    join CUR_Salon s on s.salon = hs.salon
  where h.ciclo = _ciclo and hs.salon = _salon and t.dia = _dia and cast(_inicio as time) < t.fin and cast(_fin as time) > t.inicio and h.estado = 1;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdisponibilidadsalon(integer, integer, integer, text, text)
  OWNER TO postgres;
  

-- Function: spdisponibilidadcatedratico(integer, integer, integer, text, text)

-- DROP FUNCTION spdisponibilidadcatedratico(integer, integer, integer, text, text);

CREATE OR REPLACE FUNCTION spdisponibilidadcatedratico(
    _ciclo integer,
    _catedratico integer,
    _dia integer,
    _inicio text,
    _fin text)
  RETURNS SETOF integer AS
$BODY$
BEGIN
  RETURN query Select 
    h.horario
  from 
    CUR_Horario h 
    join CUR_Trama t on h.trama = t.trama
    join CUR_Dia d on d.codigo = t.dia 
    join CUR_Horario_Salon hs on h.horario = hs.horario 
    join CUR_Curso_Catedratico cc on cc.curso_catedratico = t.curso_catedratico
    join CAT_Catedratico c on c.catedratico = cc.catedratico
  where h.ciclo = _ciclo and cc.catedratico = _catedratico and t.dia = _dia and cast(_inicio as time) < t.fin and cast(_fin as time) > t.inicio and h.estado = 1;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdisponibilidadcatedratico(integer, integer, integer, text, text)
  OWNER TO postgres;  



 
-- Function: spsiguienteciclo(integer)

-- DROP FUNCTION spsiguienteciclo(integer);

CREATE OR REPLACE FUNCTION spsiguienteciclo(
    IN _tipo integer,
    OUT anio integer,
    OUT ciclo integer)
  RETURNS SETOF record AS
$BODY$
DECLARE _anio INTEGER;
DECLARE _numciclo INTEGER;
DECLARE _duracion INTEGER;
begin
 Select max(c.anio) from cur_ciclo c where c.tipociclo = _tipo into _anio;
 Select max(c.numerociclo) from cur_ciclo c where c.tipociclo = _tipo and c.anio = _anio into _numciclo;
 Select tc.duracionmeses from cur_tipociclo tc where tc.tipociclo = _tipo into _duracion;
 IF _anio IS NULL THEN
 	 Return query Select CAST(extract(year from current_date) AS INTEGER) as anio, 1 as ciclo;
 ELSE
	 IF (12 / _duracion) > _numciclo THEN
		Return query select _anio as anio, _numciclo + 1 as ciclo;
	 ELSE
		Return query select _anio + 1 as anio, 1 as ciclo;
	 END IF;
  END IF;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spsiguienteciclo(integer)
  OWNER TO postgres;

  
-- Function: spagregarciclo(integer, integer, integer)

-- DROP FUNCTION spagregarciclo(integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarciclo(
    _tipo integer,
    _anio integer,
    _numero integer)
  RETURNS integer AS
$BODY$
DECLARE idCiclo integer;
DECLARE _duracion INTEGER;
BEGIN
SELECT ciclo FROM cur_ciclo where numerociclo = _numero and anio = _anio and tipociclo = _tipo into idCiclo;
IF idCiclo IS NULL THEN
	Select tc.duracionmeses from cur_tipociclo tc where tc.tipociclo = _tipo into _duracion;
	IF (12 / _duracion) >= _numero THEN
		INSERT INTO cur_ciclo (numerociclo, anio, tipociclo, estado) 
		VALUES (_numero, _anio, _tipo, 1) RETURNING ciclo into idCiclo;
		RETURN idCiclo;
	ELSE
		RETURN -1;
	END IF;
ELSE 
	RETURN -1;
END IF;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarciclo(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spcopiarhorariodecicloaciclo(integer, integer, integer)

-- DROP FUNCTION spcopiarhorariodecicloaciclo(integer, integer, integer);

CREATE OR REPLACE FUNCTION spcopiarhorariodecicloaciclo(
    _cicloorigen integer,
    _ciclodestino integer,
    _centrounidad integer)
  RETURNS integer AS
$BODY$
DECLARE idTrama INTEGER;
DECLARE idHorario INTEGER;
DECLARE rec record;
begin
         for rec in SELECT * FROM cur_trama t join cur_horario h on t.trama = h.trama join cur_horario_salon hs on h.horario = hs.horario join cur_seccion sec on sec.seccion = t.seccion join cur_curso cur on cur.curso = sec.curso and cur.centro_unidadacademica = _centrounidad where h.ciclo = _cicloOrigen loop
		insert into cur_trama (curso_catedratico,dia,periodo,inicio,fin,seccion) values (rec.curso_catedratico,rec.dia,rec.periodo,rec.inicio,rec.fin,rec.seccion) returning trama into idTrama;
		insert into cur_horario (jornada,trama,ciclo,estado) values (rec.jornada,idTrama,_cicloDestino,rec.estado) returning horario into idHorario;
		insert into cur_horario_salon (horario, salon) values (idHorario,rec.salon);
         end loop;
 RETURN 1;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcopiarhorariodecicloaciclo(integer, integer, integer)
  OWNER TO postgres;

  
-- Function: spinformacionhorarioconsolidado(integer, integer)

-- DROP FUNCTION spinformacionhorarioconsolidado(integer, integer);

CREATE OR REPLACE FUNCTION spinformacionhorarioconsolidado(
    IN _ciclo integer,
    IN _centrounidad integer,    
    OUT idhorario integer,
    OUT codigo text,
    OUT nombre text,
    OUT seccion text,
    OUT edificio text,
    OUT salon text,
    OUT inicio text,
    OUT fin text,
    OUT dia text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    h.horario, cu.codigo, cu.nombre, se.nombre, e.nombre, s.nombre, to_char(t.inicio, 'HH24:MI'), to_char(t.fin, 'HH24:MI'), d.nombre
  from 
    CUR_Horario h 
    join CUR_Trama t on h.trama = t.trama
    join CUR_Seccion se on t.seccion = se.seccion
    join CUR_Curso cu on se.curso = cu.curso
    join CUR_Jornada j on j.jornada = h.jornada 
    join CUR_Dia d on d.codigo = t.dia 
    join CUR_Horario_Salon hs on h.horario = hs.horario 
    join CUR_Salon s on s.salon = hs.salon 
    join CUR_Periodo p on p.periodo = t.periodo 
    join CUR_Edificio e on e.edificio = s.edificio 
    join CUR_Curso_Catedratico cc on cc.curso_catedratico = t.curso_catedratico
    join CAT_Catedratico c on c.catedratico = cc.catedratico
  where h.ciclo = _ciclo and h.estado = 1 and cu.centro_unidadacademica = _centrounidad
  order by cu.codigo, cu.nombre, se.nombre, e.nombre, s.nombre, to_char(t.inicio, 'HH24:MI'), to_char(t.fin, 'HH24:MI');
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacionhorarioconsolidado(integer, integer)
  OWNER TO postgres;  
  
  Select 'Script para Gestion de Horarios Instalado' as "Gestion Horario";