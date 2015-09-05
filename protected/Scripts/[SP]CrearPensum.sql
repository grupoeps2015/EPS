-- Function: spagregarcarrera(text, integer, integer, integer)

-- DROP FUNCTION spagregarcarrera(text, integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcarrera(
    _nombre text,
    _estado integer,
    _centro integer,
    _unidadacademica integer)
  RETURNS integer AS
$BODY$
DECLARE idCarrera integer;
BEGIN
	INSERT INTO cur_carrera (nombre, estado, centro, unidadacademica) 
	VALUES (_nombre, _estado, _centro, _unidadacademica) RETURNING Carrera into idCarrera;
	RETURN idCarrera;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcarrera(text, integer, integer, integer)
  OWNER TO postgres;


-- Function: spinformacioncarrera(integer, integer)

-- DROP FUNCTION spinformacioncarrera(integer, integer);

CREATE OR REPLACE FUNCTION spinformacioncarrera(
    IN _centro integer,
    IN _unidadacademica integer,
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
    CUR_Carrera c where c.centro = _centro and c.unidadacademica = _unidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncarrera(integer, integer)
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