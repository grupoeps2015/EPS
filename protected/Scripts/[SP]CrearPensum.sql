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
  

  
-- Function: spagregarpensum(integer, integer, text, text, text, text)

-- drop function spagregarpensum(integer, integer, text, text, text, text)

CREATE OR REPLACE FUNCTION spagregarpensum(
    _carrera integer,
    _tipo integer,
    _inicioVigencia text,
    _duracionAnios text,
    _finVigencia text,
    _descripcion text)
  RETURNS integer AS
$BODY$
DECLARE idPensum integer;
BEGIN
	INSERT INTO adm_pensum (carrera, tipo, inicioVigencia, duracionAnios, finVigencia, descripcion) 
	VALUES (_carrera, _tipo, cast(_inicioVigencia as date), cast(_duracionAnios as real), cast(_finVigencia as date), _descripcion) RETURNING Pensum into idPensum;
	RETURN idPensum;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarpensum(integer, integer, text, text, text, text)
  OWNER TO postgres;

  
-- Function: spallpensum()

-- DROP FUNCTION spallpensum();

CREATE OR REPLACE FUNCTION spallpensum(
    OUT carrera text,
    OUT tipo text,
	OUT inicioVigencia text,
	OUT duracionAnios text,
	OUT finVigencia text,
	OUT descripcion text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
    SELECT c.nombre, 
	 case 
	   when p.tipo=1 then 'Cerrado'
           when p.tipo=2 then 'Abierto'
	end as "Tipo",
	cast(p.inicioVigencia as text), cast(p.duracionAnios as text), cast(p.finVigencia as text), p.descripcion FROM adm_pensum p 
	join cur_carrera c ON p.carrera = c.carrera;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spallpensum()
  OWNER TO postgres;
  