-- Function: spinformacionedificio(integer)

-- DROP FUNCTION spinformacionedificio(integer);

CREATE OR REPLACE FUNCTION spinformacionedificio(
    IN _centrounidadacademica integer,
    OUT id integer,
    OUT nombre text,
    OUT descripcion text,
	OUT jornada integer,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    e.edificio,
    e.nombre,
    e.descripcion,
	c.jornada,
    case 
	when e.estado=0 then 'Validación Pendiente'
	when e.estado=1 then 'Activo'
	when e.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CUR_Edificio e join ADM_CentroUnidad_Edificio c on c.edificio = e.edificio where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacionedificio(integer)
  OWNER TO postgres;
  
  -- Function: spmostraredificios()

-- DROP FUNCTION spmostraredificios();

CREATE OR REPLACE FUNCTION spmostraredificios(
    OUT _id integer,
    OUT _nombre text,
    OUT _descripcion text,
    OUT _estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    edificio,
    nombre,
    descripcion,
	case 
	when e.estado=-1 then 'Inactivo'
	when e.estado=1 then 'Activo'
	end as "Estado"
  from 
    CUR_Edificio e
	order by e.nombre;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spmostraredificios()
  OWNER TO postgres;
