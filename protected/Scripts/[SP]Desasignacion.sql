 
-- Function: spgetasignaciones(integer,integer);

-- DROP FUNCTION spgetasignaciones(integer,integer);

CREATE OR REPLACE FUNCTION spgetasignaciones(
    IN _estudiante integer, IN _carrera integer,
    OUT asignacion integer,
    OUT carnet integer,
    OUT nombreEstudiante text,
    OUT codigo text,
    OUT nombre text,
    OUT seccion integer,
	OUT nombreseccion text,
    OUT fecha date,
    OUT oportunidadActual integer,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
	select eca.asignacion, ee.carnet, (ee.primerNombre || ' ' || ee.segundoNombre || ' ' || ee.primerApellido || '' || ee.segundoApellido) as nombreEstudiante, 
	cc.codigo, cc.nombre, cs.seccion, cs.nombre as nombreseccion, ecla.fecha, eca.oportunidadActual, case 
	when eca.estado=-1 then 'Inactivo'
	when eca.estado=1 then 'Activo'
	end as "Estado" 
	from est_cur_asignacion eca
	join est_ciclo_asignacion ecla on eca.ciclo_asignacion = ecla.ciclo_asignacion 
	join cur_seccion cs on eca.seccion = cs.seccion
	join cur_curso cc on cs.curso = cc.curso and cc.estado = 1
	join est_estudiante ee on ecla.estudiante=ee.estudiante
	join adm_periodo ap on ecla.periodo = ap.periodo and ap.estado = 1
	join adm_centro_unidadacademica_usuario cua on cua.usuario = ee.usuario and cua.estado = 1
	join est_estudiante_carrera ec on ec.estudiante = ee.estudiante
	where cua.usuario = _estudiante and eca.estado = 1 and ec.carrera = _carrera;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spgetasignaciones(integer,integer)
  OWNER TO postgres;
  
  
-- Function: spgetasignacion(integer);

-- DROP FUNCTION spgetasignacion(integer);

CREATE OR REPLACE FUNCTION spgetasignacion(
    IN _asignacion integer,
    OUT asignacion integer,
    OUT carnet integer,
    OUT nombreEstudiante text,
    OUT codigo text,
    OUT nombre text,
    OUT seccion integer,
    OUT fecha date,
    OUT oportunidadActual integer,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
	select eca.asignacion, ee.carnet, (ee.primerNombre || ' ' || ee.segundoNombre || ' ' || ee.primerApellido || '' || ee.segundoApellido) as nombreEstudiante, 
	cc.codigo, cc.nombre, cs.seccion, ecla.fecha, eca.oportunidadActual, case 
	when eca.estado=-1 then 'Inactivo'
	when eca.estado=1 then 'Activo'
	end as "Estado" 
	from est_cur_asignacion eca
	join est_ciclo_asignacion ecla on eca.ciclo_asignacion = ecla.ciclo_asignacion 
	join cur_seccion cs on eca.seccion = cs.seccion
	join cur_curso cc on cs.curso = cc.curso and cc.estado = 1
	join est_estudiante ee on ecla.estudiante=ee.estudiante and ee.estado = 1
	join adm_periodo ap on ecla.periodo = ap.periodo and ap.estado = 1
	where  eca.asignacion = _asignacion and eca.estado = 1;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spgetasignacion(integer)
  OWNER TO postgres;


------------------------------------------------------------------------------------------------------------------------------------
-- Function: spactivardesactivasignacion(integer, integer)
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spactivardesactivarasignacion(integer, integer);
CREATE OR REPLACE FUNCTION spactivardesactivarasignacion(
    _asignacion integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE est_cur_asignacion SET estado = %L WHERE asignacion = %L',_estadoNuevo,_asignacion);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarasignacion(integer, integer)
  OWNER TO postgres;  
  
-----------------------------------------------------------------------------------------
-- Function: spagregardesasignacion(integer, text)

-- DROP FUNCTION spagregardesasignacion(integer, text);

CREATE OR REPLACE FUNCTION spagregardesasignacion(
    _asignacion integer,
    _descripcion text)
  RETURNS integer AS
$BODY$
DECLARE fechaactual DATE;
DECLARE horaactual TIME;
DECLARE idAs INTEGER;
begin
 SELECT current_date into fechaactual;
 SELECT current_time into horaactual;
 INSERT INTO cur_desasignacion (asignacion, Fecha, Hora, descripcion, adjuntos) 
 values (_asignacion, current_date, current_time, _descripcion, (select adjuntos from est_cur_asignacion where asignacion = _asignacion)) 
 RETURNING desasignacion INTO idAs;
 RETURN idAs;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregardesasignacion(integer, text)
  OWNER TO postgres;
  
  
-- Function: spgetdesasignacion(integer, integer);

-- DROP FUNCTION spgetdesasignacion(integer, integer);

CREATE OR REPLACE FUNCTION spgetdesasignacion(
    IN _carnet integer,
	IN _curso integer,
    OUT desasignacion integer,
    OUT carnet integer
    )
 RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select  cd.desasignacion, e.carnet from est_estudiante e 
join est_ciclo_asignacion eca on e.estudiante = eca.estudiante
join est_cur_asignacion ecra on ecra.ciclo_asignacion = eca.ciclo_asignacion
join cur_desasignacion cd on cd.asignacion = ecra.asignacion
join cur_seccion cs on cs.seccion = ecra.seccion
and e.carnet = _carnet and cs.curso = _curso;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spgetdesasignacion(integer, integer)
  OWNER TO postgres;