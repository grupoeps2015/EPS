----------------------------------------------------------------------------------------
-- Function: spinformacionedificio(integer)
----------------------------------------------------------------------------------------
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

----------------------------------------------------------------------------------------
-- Function: spmostraredificios()
----------------------------------------------------------------------------------------
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

----------------------------------------------------------------------------------------
-- Function: spactualizarAsignacion()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spactualizarAsignacion(integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spactualizarAsignacion(
    _centroUnidad integer,
    _edificio integer,
	_jornada integer,
	_asignacion integer)
  RETURNS integer AS
$BODY$
DECLARE idAsignacion integer;
BEGIN
	UPDATE ADM_CentroUnidad_Edificio SET centro_unidadAcademica= _centroUnidad,
	edificio = _edificio, jornada = _jornada
	WHERE centrounidad_edificio = _asignacion RETURNING centrounidad_edificio into idAsignacion;
	RETURN idAsignacion;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarAsignacion(integer, integer,integer, integer)
  OWNER TO postgres;
  
----------------------------------------------------------------------------------------
-- Function: spdatoscentrounidad()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spdatoscentrounidad();
CREATE OR REPLACE FUNCTION spdatoscentrounidad(
    OUT _id integer,
    OUT _centro text,
	out _unidadAcademica text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    cua.centro_unidadAcademica,
    c.nombre,
    ua.nombre
  from 
    ADM_Centro_UnidadAcademica cua
	join ADM_Centro c ON c.centro = cua.centro
	join ADM_UnidadAcademica ua ON ua.unidadAcademica = cua.unidadAcademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscentrounidad()
  OWNER TO postgres;
  
----------------------------------------------------------------------------------------
-- Function: spinformacionasignacionedificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spinformacionasignacionedificio(integer);
CREATE OR REPLACE FUNCTION spinformacionasignacionedificio(_centrounidad_edificio integer,
    OUT centro_unidadacademica integer,
    OUT edificio integer,
	OUT nombreedificio text,
	OUT jornada integer,
	OUT nombrejornada text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT cu.centro_unidadacademica,e.edificio,e.nombre AS nombreedificio,j.jornada,j.nombre AS nombrejornada
	FROM ADM_Centrounidad_Edificio ce 
	JOIN ADM_Centro_Unidadacademica cu ON cu.centro_unidadacademica = ce.centro_unidadacademica
	JOIN CUR_Edificio e ON ce.edificio = e.edificio
	JOIN CUR_Jornada j ON j.jornada = ce.jornada
	WHERE ce.centrounidad_edificio = _centrounidad_edificio;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscentrounidad()
  OWNER TO postgres;
  
----------------------------------------------------------------------------------------
-- Function: spagregaredificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spagregaredificio(text, text, integer)
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

----------------------------------------------------------------------------------------
-- Function: spasignaredificioacentrounidadacademica()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spasignaredificioacentrounidadacademica(integer, integer, integer, integer);
CREATE OR REPLACE FUNCTION spasignaredificioacentrounidadacademica(
    _centroUnidadAcademica integer,
    _edificio integer,
    _jornada integer,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idAsignacion INTEGER;
BEGIN
	INSERT INTO ADM_CentroUnidad_edificio(Centro_UnidadAcademica,edificio,jornada, estado) 
	VALUES (_centroUnidadAcademica,_edificio, _jornada, _estado) RETURNING centrounidad_edificio into idAsignacion;
	RETURN idAsignacion;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spasignaredificioacentrounidadacademica(integer, integer, integer, integer)
  OWNER TO postgres;

----------------------------------------------------------------------------------------
-- Function: speliminarAsignacionEdificio()
----------------------------------------------------------------------------------------
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

----------------------------------------------------------------------------------------
-- Function: spDatosEdificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spDatosEdificio(integer)
CREATE OR REPLACE FUNCTION spDatosEdificio(
    IN idEdificio integer,
    OUT nombreUnidadAcademica text,
    OUT nombreCentro text,
    OUT jornada text,
    OUT estado text, OUT edificio integer,
	OUT centrounidad_edificio integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
	select u.nombre nombreUnidad, c.nombre nombreCentro, j.nombre jornada, case 
	when query1.estado=-1 then 'Inactivo'
	when query1.estado=1 then 'Activo'
	end as "Estado", query1.edificio AS edificio, query1.centrounidad_edificio 
	 from ADM_UnidadAcademica u JOIN (
	select acu.unidadAcademica unidad, acu.centro centro, ace.edificio edificio, ace.jornada jornada, ace.estado estado, ace.centrounidad_edificio
	from ADM_CentroUnidad_Edificio ace join ADM_Centro_UnidadAcademica acu ON ace.centro_unidadAcademica = acu.centro_unidadAcademica) query1 ON
	u.unidadacademica = query1.unidad JOIN ADM_Centro c ON c.centro = query1.centro JOIN cur_jornada j ON j.jornada = query1.jornada where query1.edificio = idEdificio;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spDatosEdificio(integer)
  OWNER TO postgres;

----------------------------------------------------------------------------------------
-- Function: spactivardesactivaredificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spactivardesactivaredificio(integer, integer);
CREATE OR REPLACE FUNCTION spactivardesactivaredificio(
    _idEdificio integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_edificio SET estado = %L WHERE edificio = %L',_estadoNuevo,_idEdificio);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivaredificio(integer, integer)
  OWNER TO postgres;
  

----------------------------------------------------------------------------------------
-- Function: spModificarEdificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spmodificaredificio(integer, text, text); 
CREATE OR REPLACE FUNCTION spModificarEdificio(_edificio integer, 
						_nombre text, 
					        _descripcion text
							)RETURNS BOOLEAN LANGUAGE plpgsql SECURITY DEFINER AS $$

BEGIN
    UPDATE CUR_Edificio
       SET nombre = COALESCE(spModificarEdificio._nombre, CUR_Edificio.nombre),
           descripcion = COALESCE(spModificarEdificio._descripcion, CUR_Edificio.descripcion)
     WHERE CUR_Edificio.edificio = spModificarEdificio._edificio;       
    RETURN FOUND;
END;
$$;

----------------------------------------------------------------------------------------
-- Function: spConsultaEdificio()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spConsultaEdificio(integer)
CREATE OR REPLACE FUNCTION spConsultaEdificio(
    IN idEdificio integer,
    OUT nombre text,
    OUT descripcion text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
	SELECT e.nombre, e.descripcion
	FROM CUR_Edificio e
	WHERE e.edificio = idEdificio;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spConsultaEdificio(integer)
  OWNER TO postgres;

 Select 'Script para Gestion de Edificios Instalado' as "Gestion Edificios";