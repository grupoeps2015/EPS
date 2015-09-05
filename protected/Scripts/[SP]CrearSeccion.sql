-- Function: spagregarseccion(text, text, integer, integer, integer)

-- DROP FUNCTION spagregarseccion(text, text, integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarseccion(
    _nombre text,
    _descripcion text,
    _curso integer,
    _estado integer,
    _tiposeccion integer)
  RETURNS integer AS
$BODY$
DECLARE idSeccion integer;
BEGIN
	INSERT INTO cur_seccion (nombre, descripcion, curso, estado, tiposeccion) 
	VALUES (_nombre, _descripcion, _curso, _estado, _tiposeccion) RETURNING Seccion into idSeccion;
	RETURN idSeccion;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarseccion(text, text, integer, integer, integer)
  OWNER TO postgres;

-- Function: spinformacionseccion(integer)

-- DROP FUNCTION spinformacionseccion(integer);

CREATE OR REPLACE FUNCTION spinformacionseccion(
    IN _centrounidadacademica integer,
	OUT id integer,
    OUT nombre text,
    OUT curso text,
    OUT tiposeccion text,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    s.seccion,
    s.nombre,
    (c.codigo || ' - ' || c.nombre) as curso,
    t.nombre as "tiposeccion",
    case 
	when s.estado=0 then 'Validación Pendiente'
	when s.estado=1 then 'Activo'
	when s.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CUR_Seccion s join CUR_TipoSeccion t on s.tiposeccion = t.tiposeccion join CUR_Curso c on s.curso = c.curso 
  where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacionseccion(integer)
  OWNER TO postgres;


-- Function: spactivardesactivarseccion(integer, integer)

-- DROP FUNCTION spactivardesactivarseccion(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarseccion(
    _idseccion integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_seccion SET estado = %L WHERE seccion = %L',_estadoNuevo,_idseccion);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarseccion(integer, integer)
  OWNER TO postgres;

  
-- Function: spdatosseccion(integer)

-- DROP FUNCTION spdatosseccion(integer);

CREATE OR REPLACE FUNCTION spdatosseccion(
    IN id integer,
    OUT nombre text,
    OUT descripcion text,
    OUT curso integer,
    OUT estado integer,
    OUT tiposeccion integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT s.nombre, s.descripcion, s.curso, s.estado, s.tiposeccion FROM CUR_Seccion s where s.seccion = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatosseccion(integer)
  OWNER TO postgres;


-- Function: spactualizarseccion(text, text, integer, integer, integer)

-- DROP FUNCTION spactualizarseccion(text, text, integer, integer, integer);

CREATE OR REPLACE FUNCTION spactualizarseccion(
    _nombre text,
    _descripcion text,
    _curso integer,
    _id integer,
    _tiposeccion integer)
  RETURNS integer AS
$BODY$
DECLARE idSeccion integer;
BEGIN
	UPDATE CUR_Seccion SET nombre = _nombre, descripcion = _descripcion, curso = _curso, tiposeccion = _tiposeccion
	WHERE seccion = _id RETURNING Seccion into idSeccion;
	RETURN idSeccion;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarseccion(text, text, integer, integer, integer)
  OWNER TO postgres;
