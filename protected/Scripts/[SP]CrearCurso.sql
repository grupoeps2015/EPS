-- Function: spagregarcurso(text, text, boolean, integer, integer, integer)

-- DROP FUNCTION spagregarcurso(text, text, boolean, integer, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcurso(
    _codigo text,
    _nombre text,
    _traslape boolean,
    _estado integer,
    _tipocurso integer,
    _centrounidadacademica integer)
  RETURNS integer AS
$BODY$
DECLARE idCurso integer;
BEGIN
	INSERT INTO cur_curso (codigo, nombre, traslape, estado, tipocurso, centro_unidadacademica) 
	VALUES (_codigo, _nombre, _traslape, _estado, _tipocurso, _centrounidadacademica) RETURNING Curso into idCurso;
	RETURN idCurso;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcurso(text, text, boolean, integer, integer, integer)
  OWNER TO postgres;


-- Function: spinformacioncurso(integer, integer)

-- DROP FUNCTION spinformacioncurso(integer, integer);

CREATE OR REPLACE FUNCTION spinformacioncurso(
    IN _centrounidadacademica integer,
    IN _estado integer default null,
    OUT id integer,
    OUT codigo text,
    OUT nombre text,
    OUT tipocurso text,
    OUT estado text,
    OUT traslape text)
  RETURNS SETOF record AS
$BODY$
BEGIN
	IF _estado IS NOT NULL THEN
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
	    CUR_Curso c join CUR_Tipo t on c.tipocurso = t.tipocurso where c.centro_unidadacademica = _centrounidadacademica and c.estado = _estado;
	ELSE
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
	    CUR_Curso c join CUR_Tipo t on c.tipocurso = t.tipocurso where c.centro_unidadacademica = _centrounidadacademica;
	END IF;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncurso(integer, integer)
  OWNER TO postgres;

  

-- Function: spinformacioncursocarreraactivo(integer, integer)

-- DROP FUNCTION spinformacioncursocarreraactivo(integer, integer);

CREATE OR REPLACE FUNCTION spinformacioncursocarreraactivo(
    IN _centrounidadacademica integer,
	IN _carrera integer,
    OUT id integer,
    OUT codigo text,
    OUT nombre text,
    OUT tipocurso text,
    OUT estado integer,
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
    c.estado,
	case
	when c.traslape=true then 'Sí'
	when c.traslape=false then 'No'
    end as "Traslape"
  from 
    CUR_Curso c join CUR_Tipo t on c.tipocurso = t.tipocurso
    join CUR_Pensum_Area cpa on c.curso = cpa.curso
    join ADM_Pensum p on p.pensum = cpa.pensum
    where c.centro_unidadacademica = _centrounidadacademica and c.estado = 1 and p.carrera = _carrera and cpa.estado = 1 and p.estado = 1;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncursocarreraactivo(integer, integer)
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
    OUT tipocurso integer,
    OUT centrounidad integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT c.codigo, c.nombre, c.traslape, c.estado, c.tipocurso, c.centro_unidadacademica FROM CUR_Curso c where c.curso = id;
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

  
-- Function: spinformacioncurso(integer)

-- DROP FUNCTION spinformacioncurso(integer);

CREATE OR REPLACE FUNCTION spinformacioncurso(
    IN _centrounidadacademica integer,
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
    CUR_Curso c join CUR_Tipo t on c.tipocurso = t.tipocurso where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncurso(integer)
  OWNER TO postgres;
  
  
 Select 'Script para Gestion de Cursos Instalado' as "Gestion Cursos";
 