-- Function: spagregaredificio(text, integer, integer)

-- DROP FUNCTION spagregaredificio(text, text, integer);

CREATE OR REPLACE FUNCTION spagregaredificio(
    _nombre text,
    _descripcion text,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idEdificio integer;
BEGIN
	INSERT INTO cur_edificio (nombre, descripcion, estado) 
	VALUES (_nombre, _descripcion, _estado) RETURNING Edificio into idEdificio;
	RETURN idEdificio;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregaredificio(text, text, integer)
  OWNER TO postgres;

-- Function: spasignaredificioacentrounidadacademica(integer, integer, integer, integer)

-- DROP FUNCTION spasignaredificioacentrounidadacademica(integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spasignaredificioacentrounidadacademica(
    _Centro_UnidadAcademica integer,
    _edificio integer,
    _jornada integer,
    _estado integer)
  RETURNS integer AS
$BODY$
declare idAsignacion INTEGER;
BEGIN
	INSERT INTO ADM_CentroUnidad_edificio(Centro_UnidadAcademica,edificio,jornada, estado) 
	VALUES (_Centro_UnidadAcademica,_edificio, _jornada, _estado) RETURNING Asignacion into idAsignacion;
	RETURN idAsignacion;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spasignaredificioacentrounidadacademica(integer, integer, integer, integer)
  OWNER TO postgres;

  -- Function: speliminarAsignacionEdificio(integer, integer, integer)

-- DROP FUNCTION speliminarAsignacionEdificio(integer, integer);

CREATE OR REPLACE FUNCTION speliminarAsignacionEdificio(
    _idAsignacion integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_centrounidad_edificio SET estado = %L WHERE centrounidad_edificio = %L',_estadoNuevo,_idAsignacion);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION speliminarAsignacionEdificio(integer, integer)
  OWNER TO postgres;


  
-- Function: spInformacionEdificio(integer)

-- DROP FUNCTION spInformacionEdificio(integer);

CREATE OR REPLACE FUNCTION spInformacionEdificio(
    IN _idEdificio integer,
    OUT _nombreUnidadAcademica text,
    OUT _nombreCentro text,
	OUT _jornada text,
    OUT _estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
	select u.nombre, c.nombre, j.nombre, query1.estado from ADM_UnidadAcademica u JOIN (
	select acu.unidadAcademica unidad, acu.centro centro, ace.edificio edificio, ace.jornada jornada, ace.estado estado 
	from ADM_CentroUnidad_Edificio ace join ADM_Centro_UnidadAcademica acu ON ace.centro_unidadAcademica = acu.centro_unidadAcademica) query1 ON
	u.unidadacademica = query1.unidad JOIN ADM_Centro c ON c.centro = query1.centro JOIN cur_jornada j ON j.jornada = query1.jornada where query1.edificio = _idEdificio;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spInformacionEdificio(integer)
  OWNER TO postgres;

  
--*********************************************************************************************************************************************************
  
  
  
﻿-- Function: spagregarsalon(text, integer, integer, integer, integer)

-- DROP FUNCTION spagregarsalon(text, integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spagregarsalon(
    _nombre text,
    _edificio integer,
    _nivel integer,
    _capacidad integer,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idSalon INTEGER
BEGIN
	INSERT INTO CUR_Salon(nombre, edificio, nivel, capacidad, estado) 
	VALUES (_nombre, _edificio, _nivel, _capacidad, _estado) RETURNING Salon into idSalon;
	RETURN idSalon;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarsalon(text, integer, integer, integer, integer)
  OWNER TO postgres;

﻿-- Function: spcrearjornada(text, integer)

-- DROP FUNCTION spcrearjornada(text, integer)
CREATE OR REPLACE FUNCTION spcrearjornada(
    _nombre text,
    _estado integer)
  RETURNS integer AS
$BODY$
 DECLARE idJornada INTEGER
BEGIN
	INSERT INTO cur_jornada(nombre, estado) 
	VALUES (_nombre, _estado) RETURNING Jornada into idJornada;
	RETURN idJornada;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcrearjornada(text, integer)
  OWNER TO postgres;

﻿-- Function: spcrearhorario(integer, integer, integer, integer)

-- DROP FUNCTION spcrearhorario(integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spcrearhorario(
    _jornada integer,
    _trama integer,
    _ciclo integer,
    _estado integer)
  RETURNS integer AS
$BODY$
 DECLARE idHorario INTEGER
BEGIN
	INSERT INTO cur_horario(jornada, trama, ciclo, estado) 
	VALUES (_jornada, _trama, _ciclo, _estado) RETURNING Horario into idHorario;
	RETURN idHorario;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcrearhorario(integer, integer, integer, integer)
  OWNER TO postgres;

﻿-- Function: spagregarciclo(integer, integer, integer, integer)

-- DROP FUNCTION spagregarciclo(integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spagregarciclo(
    _numeroCiclo integer,
    _anio integer,
    _tipoCiclo integer,
    _estado integer)
  RETURNS integer AS
$BODY$
	DECLARE idCiclo INTEGER
BEGIN
	INSERT INTO cur_ciclo(numeroCiclo, anio, tipoCiclo, estado) 
	VALUES (_numeroCiclo, _anio, _tipoCiclo, _estado) RETURNING Ciclo into idCiclo;
	RETURN idCiclo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarciclo(integer, integer, integer, integer)
  OWNER TO postgres;

﻿-- Function: spagregartipociclo(text, text, integer)

-- DROP FUNCTION spagregartipociclo(text, text, integer);
CREATE OR REPLACE FUNCTION spagregartipociclo(
    _nombre text,
    _descripcion text,
    _estado integer)
  RETURNS integer AS
$BODY$
	DECLARE idTipoCiclo INTEGER
BEGIN
	INSERT INTO cur_TipoCiclo(nombre, descripcion, estado) 
	VALUES (_nombre, _descripcion, _estado) RETURNING TipoCiclo into idTipoCiclo;
	RETURN idTipoCiclo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregartipociclo(text, text, integer)
  OWNER TO postgres;

/*cur_trama cur_periodo cur_tipoPeriodo*/

﻿-- Function: spagregartrama(integer,integer,integer,integer,time,time,integer)

-- DROP FUNCTION spagregartrama(integer,integer,integer,integer,time,time,integer);
CREATE OR REPLACE FUNCTION spagregartrama(
    _curso integer,
    _catedratico integer,
    _dia integer,
    _periodo integer,
    _inicio time,
    _fin time,
    _seccion integer)
  RETURNS integer AS
$BODY$
	DECLARE idTrama INTEGER
BEGIN
	INSERT INTO cur_Trama(curso, catedratico, dia, periodo, inicio, fin, seccion) 
	VALUES (_curso, _catedratico, _dia, _periodo, _inicio, _fin, _seccion) RETURNING Trama into idTrama;
	RETURN idTrama;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregartrama(integer,integer,integer,integer,time,time,integer)
  OWNER TO postgres;

﻿-- Function: spagregarperiodo(integer, integer)

-- DROP FUNCTION spagregarperiodo(integer, integer);
CREATE OR REPLACE FUNCTION spagregarperiodo(
    _duracionMinutos integer,
    _tipoPeriodo integer)
  RETURNS integer AS
$BODY$
	DECLARE idPeriodo INTEGER
BEGIN
	INSERT INTO cur_Periodo(duracionMinutos,tipoPeriodo) 
	VALUES (_duracionMinutos, _tipoPeriodo) RETURNING Periodo into idPeriodo;
	RETURN idPeriodo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarperiodo(integer, integer)
  OWNER TO postgres;

﻿-- Function: spagregartipoperiodo(text, text, integer)

-- DROP FUNCTION spagregartipoperiodo(text, text, integer);
CREATE OR REPLACE FUNCTION spagregartipoperiodo(
    _nombre text,
    _descripcion text,
    _estado integer)
  RETURNS integer AS
$BODY$
	DECLARE idTipoPeriodo INTEGER
BEGIN
	INSERT INTO cur_TipoPeriodo(nombre, descripcion, estado) 
	VALUES (_nombre, _descripcion, _estado) RETURNING TipoPeriodo into idTipoPeriodo;
	RETURN idTipoPeriodo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregartipoperiodo(text, text, integer)
  OWNER TO postgres;

