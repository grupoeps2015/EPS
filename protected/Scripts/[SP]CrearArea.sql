------------------------------------------------------------------------------------------------------------------------------------
  -- Function: spmostrarareas()
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spmostrarareas();
------------------------------------------------------------------------------------------------------------------------------------
CREATE OR REPLACE FUNCTION spmostrarareas(
    OUT _id integer,
    OUT _nombre text,
    OUT _descripcion text,
    OUT _estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    area,
    nombre,
    descripcion,
	case 
	when estado=-1 then 'Inactivo'
	when estado=1 then 'Activo'
	end as "Estado"
  from 
    adm_area order by nombre;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spmostrarareas()
  OWNER TO postgres;


------------------------------------------------------------------------------------------------------------------------------------
-- Function: spagregararea()
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spagregararea(text, text, integer)
CREATE OR REPLACE FUNCTION spagregararea(
    _nombre text,
    _descripcion text,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idArea integer;
BEGIN
	INSERT INTO adm_area (nombre, descripcion, estado) 
	VALUES (_nombre, _descripcion, _estado) RETURNING Area into idArea;
	RETURN idArea;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregararea(text, text, integer)
  OWNER TO postgres;

------------------------------------------------------------------------------------------------------------------------------------
-- Function: spdatosarea()
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spdatosarea(integer)
CREATE OR REPLACE FUNCTION spdatosarea(
    IN idArea integer,
    OUT _idArea integer,
    OUT _nombre text,
    OUT _descripcion text,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
	select nombre, descripcion,
        case 
            when estado=-1 then 'Inactivo'
            when estado=1 then 'Activo'
	end as "Estado"
       from adm_Area where area = idArea;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatosarea(integer)
  OWNER TO postgres;

------------------------------------------------------------------------------------------------------------------------------------
-- Function: spactivardesactivararea()
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spactivardesactivararea(integer, integer);
CREATE OR REPLACE FUNCTION spactivardesactivararea(
    _idArea integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_area SET estado = %L WHERE area = %L',_estadoNuevo,_idArea);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivararea(integer, integer)
  OWNER TO postgres;
  

-- -----------------------------------------------------
-- Function: spmodificararea()
-- -----------------------------------------------------
-- DROP FUNCTION spmodificararea(integer, text, text); 
CREATE OR REPLACE FUNCTION spmodificararea(_area integer, _nombre text, _descripcion text)
RETURNS BOOLEAN LANGUAGE plpgsql SECURITY DEFINER AS $$

BEGIN
    UPDATE adm_area
       SET nombre = _nombre,
           descripcion = _descripcion
     WHERE area = _area;       
    RETURN FOUND;
END;
$$;


------------------------------------------------------------------------------------------------------------------------------------
-- Function: spconsultaarea()
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spconsultaarea(integer)
CREATE OR REPLACE FUNCTION spconsultaarea(
    IN idArea integer,
    OUT _nombre text,
    OUT _descripcion text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
	SELECT nombre, descripcion
	FROM adm_area
	WHERE area = idArea;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spconsultaarea(integer)
  OWNER TO postgres;

 Select 'Script para Gestion de Area Instalado' as "Gestion Area";