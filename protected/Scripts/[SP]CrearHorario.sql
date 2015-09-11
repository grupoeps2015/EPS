﻿-- Function: spagregarcursocatedratico(integer, integer)

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
BEGIN
	INSERT INTO cur_horario_salon (horario, salon) 
	VALUES (_horario, _salon) RETURNING horario into idHorario;
	RETURN idHorario;
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
--------------------------------------------------------------------------------------------------------------------------------------------------

-- Function: spagregarcarrera(text, integer, integer)

-- DROP FUNCTION spagregarcarrera(text, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcarrera(
    _nombre text,
    _estado integer,
    _centrounidadacademica integer)
  RETURNS integer AS
$BODY$
DECLARE idCarrera integer;
BEGIN
	INSERT INTO cur_carrera (nombre, estado, centro_unidadacademica) 
	VALUES (_nombre, _estado, _centrounidadacademica) RETURNING Carrera into idCarrera;
	RETURN idCarrera;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcarrera(text, integer, integer)
  OWNER TO postgres;


-- Function: spinformacioncarrera(integer)

-- DROP FUNCTION spinformacioncarrera(integer);

CREATE OR REPLACE FUNCTION spinformacioncarrera(
    IN _centrounidadacademica integer,
    OUT id integer,
    OUT nombre text,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    c.carrera,
    c.nombre,
    case 
	when c.estado=0 then 'Validación Pendiente'
	when c.estado=1 then 'Activo'
	when c.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CUR_Carrera c where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncarrera(integer)
  OWNER TO postgres;

  
-- Function: spactivardesactivarcarrera(integer, integer)

-- DROP FUNCTION spactivardesactivarcarrera(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarcarrera(
    _idcarrera integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_carrera SET estado = %L WHERE carrera = %L',_estadoNuevo,_idCarrera);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarcarrera(integer, integer)
  OWNER TO postgres;


  
-- Function: spdatoscarrera(integer)

-- DROP FUNCTION spdatoscarrera(integer);

CREATE OR REPLACE FUNCTION spdatoscarrera(
    IN id integer,
    OUT nombre text,
    OUT estado integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT c.nombre, c.estado FROM CUR_Carrera c where c.carrera = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscarrera(integer)
  OWNER TO postgres;


-- Function: spactualizarcarrera(text, integer)

-- DROP FUNCTION spactualizarcarrera(text, integer);

CREATE OR REPLACE FUNCTION spactualizarcarrera(
    _nombre text,
    _id integer)
  RETURNS integer AS
$BODY$
DECLARE idCarrera integer;
BEGIN
	UPDATE CUR_Carrera SET nombre = _nombre
	WHERE carrera = _id RETURNING Carrera into idCarrera;
	RETURN idCarrera;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarcarrera(text, integer)
  OWNER TO postgres;