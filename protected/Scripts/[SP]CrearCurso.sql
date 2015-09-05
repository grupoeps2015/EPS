---------------------------------------------------------------------------
-- Function: spagregarcurso(text, text, boolean, integer, integer)
---------------------------------------------------------------------------
-- DROP FUNCTION spagregarcurso(text, text, boolean, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcurso(
    _codigo text,
    _nombre text,
    _traslape boolean,
    _estado integer,
    _tipocurso integer,
	_centro integer,
	_unidadacademica integer)
  RETURNS integer AS
$BODY$
DECLARE idCurso integer;
BEGIN
	INSERT INTO cur_curso (codigo, nombre, traslape, estado, tipocurso, centro, unidadacademica) 
	VALUES (_codigo, _nombre, _traslape, _estado, _tipocurso, _centro, _unidadacademica) RETURNING Curso into idCurso;
	RETURN idCurso;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcurso(text, text, boolean, integer, integer, integer, integer)
  OWNER TO postgres;

---------------------------------------------------------------------------
-- Function: spinformacioncurso()
---------------------------------------------------------------------------
-- DROP FUNCTION spinformacioncurso();

CREATE OR REPLACE FUNCTION spinformacioncurso(
    OUT id integer,
    OUT codigo text,
    OUT nombre text,
    OUT tipocurso text,
    OUT estado text,
    OUT traslape text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    c.curso,
    c.codigo,
    c.nombre,
    t.nombre as "tipocurso",
    case 
	when c.estado=0 then 'Validación Pendiente'
	when c.estado=1 then 'Activo'
	when c.estado=-1 then 'Desactivado'
    end as "Estado",
    case 
	when c.traslape=true then 'Sí'
	when c.traslape=false then 'No'
    end as "Traslape"
  from 
    CUR_Curso c join CUR_Tipo t on c.tipocurso = t.tipocurso;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncurso()
  OWNER TO postgres;

---------------------------------------------------------------------------
-- Function: spactivardesactivarcurso(integer, integer)
---------------------------------------------------------------------------
-- DROP FUNCTION spactivardesactivarcurso(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarcurso(
    _idcurso integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_curso SET estado = %L WHERE curso = %L',_estadoNuevo,_idCurso);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarcurso(integer, integer)
  OWNER TO postgres;
  
---------------------------------------------------------------------------
-- Function: spdatoscurso(integer)
---------------------------------------------------------------------------
-- DROP FUNCTION spdatoscurso(integer);

CREATE OR REPLACE FUNCTION spdatoscurso(
    IN id integer,
    OUT codigo text,
    OUT nombre text,
    OUT traslape boolean,
    OUT estado integer,
    OUT tipocurso integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT c.codigo, c.nombre, c.traslape, c.estado, c.tipocurso FROM CUR_Curso c where c.curso = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscurso(integer)
  OWNER TO postgres;

---------------------------------------------------------------------------  
-- Function: spactualizarcurso(text, text, boolean, integer, integer)
---------------------------------------------------------------------------
-- DROP FUNCTION spactualizarcurso(text, text, boolean, integer, integer);

CREATE OR REPLACE FUNCTION spactualizarcurso(
    _codigo text,
    _nombre text,
    _traslape boolean,
    _id integer,
    _tipocurso integer)
  RETURNS integer AS
$BODY$
DECLARE idCurso integer;
BEGIN
	UPDATE CUR_Curso SET codigo = _codigo, nombre = _nombre, traslape = _traslape, tipocurso = _tipocurso
	WHERE curso = _id RETURNING Curso into idCurso;
	RETURN idCurso;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarcurso(text, text, boolean, integer, integer)
  OWNER TO postgres;