-- Function: spagregarcurso(text, text, boolean, integer, integer)

-- DROP FUNCTION spagregarcurso(text, text, boolean, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcurso(
    _codigo text,
    _nombre text,
    _traslape boolean,
    _estado integer,
    _tipocurso integer)
  RETURNS integer AS
$BODY$
BEGIN
	INSERT INTO cur_curso (codigo, nombre, traslape, estado, tipocurso) 
	VALUES (_codigo, _nombre, _traslape, _estado, _tipocurso) RETURNING Curso;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcurso(text, text, boolean, integer, integer)
  OWNER TO postgres;


-- Function: spinformacioncurso()

-- DROP FUNCTION spinformacioncurso();

CREATE OR REPLACE FUNCTION spinformacioncurso(
    OUT id integer,
    OUT codigo integer,
    OUT nombre text,
    OUT tipocurso text,
    OUT estado text)
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


-- Function: spactivardesactivarcurso(integer, integer)

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
