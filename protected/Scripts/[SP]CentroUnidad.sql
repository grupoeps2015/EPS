-- -----------------------------------------------------
-- Function: spInfoCentros()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoCentros();
CREATE OR REPLACE FUNCTION spInfoCentros(OUT centro int, OUT nombre text, OUT direccion text) RETURNS setof record as 
$BODY$
BEGIN 
  RETURN query
	select 
	  cen.centro, 
	  cen.nombre, 
	  (cen.direccion || ' zona ' || cen.zona || ', ' || mun.nombre) as direccion
	from 
	  adm_centro cen
	join adm_municipio mun on mun.municipio = cen.municipio;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spNombreCentro()
-- -----------------------------------------------------
-- DROP FUNCTION spNombreCentro(int);
CREATE OR REPLACE FUNCTION spNombreCentro(IN _centro int) RETURNS text as
$BODY$
declare nombreCentro text;
BEGIN 
  select cen.nombre from adm_centro cen where cen.centro = _centro into nombreCentro;
  return nombreCentro;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarCentros()
-- -----------------------------------------------------
-- DROP FUNCTION spAgregarCentros(int,text,text,int,int);
CREATE OR REPLACE FUNCTION spAgregarCentros(_codigo int, _nombre text, _direccion text, _municipio int, _zona int) RETURNS void as 
$BODY$
BEGIN
  INSERT INTO adm_centro(centro, nombre, direccion, municipio, zona)
    VALUES (_codigo, _nombre, _direccion, _municipio, _zona);
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spDatosCentro()
-- -----------------------------------------------------
-- DROP FUNCTION spDatosCentro(int);
CREATE OR REPLACE FUNCTION spDatosCentro(IN _idCentro int, OUT nombre text, 
					 OUT direccion text, OUT municipio int, 
					 OUT departamento int, OUT zona int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
	select 
	  cen.nombre,
	  cen.direccion,
	  cen.municipio,
	  dep.departamento,
	  cen.zona
	from adm_centro cen 
	join adm_municipio mun on mun.municipio = cen.municipio
	join adm_departamento dep on dep.departamento = mun.departamento
	where cen.centro=_idCentro;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spActualizarCentro()
-- -----------------------------------------------------
-- DROP FUNCTION spActualizarCentro(integer, text, text, integer, integer);
CREATE OR REPLACE FUNCTION spActualizarCentro(
    _idCentro integer,
    _nombre text,
    _direccion text,
    _municipio integer,
    _zona integer
   )
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_centro SET nombre = %L, direccion = %L, 
					municipio = %L, 
					zona = %L
				     WHERE centro = %L',
					_nombre, _direccion, _municipio, _zona, _idCentro);
END;
$BODY$
LANGUAGE plpgsql;

-- -----------------------------------------------------
-- Function: spInfoUnidades()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoUnidades(int);
CREATE OR REPLACE FUNCTION spInfoUnidades(IN _idCentro int, OUT unidad int, 
					  OUT nombre text, OUT idPadre int, 
					  OUT nombrepadre text, OUT tipo text, 
					  OUT estado text) RETURNS setof record as 
$BODY$
BEGIN 
  RETURN query
	select 
	  cau.unidadacademica as unidad,
	  ua.nombre,
	  coalesce(ua.unidadacademicasuperior,0) as idPadre,
	  coalesce((select ua1.nombre from adm_unidadacademica ua1 where ua1.unidadacademica=ua.unidadacademicasuperior),'No tiene') as nombrePadre,
	  tp.nombre as tipo,
	  case
	    when cau.estado = -1 then 'Desactivado'
	    when cau.estado = 1  then 'Activado'
	    else 'Desconocido'
	  End as estado
	from adm_centro_unidadacademica cau
	join adm_unidadacademica ua on ua.unidadacademica = cau.unidadacademica
	join adm_tipounidadacademica tp on ua.tipo = tp.tipounidadacademica
	where cau.centro = _idCentro;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spUnidadesPropias()
-- -----------------------------------------------------
-- DROP FUNCTION spUnidadesPropias(int);
CREATE OR REPLACE FUNCTION spUnidadesPropias(IN _idCentro int, OUT unidad int, OUT nombre text) RETURNS setof record as 
$BODY$
BEGIN 
  RETURN query
	select 
	  cau.unidadacademica as unidad,
	  ua.nombre
	from adm_centro_unidadacademica cau
	join adm_unidadacademica ua on ua.unidadacademica = cau.unidadacademica
	where cau.centro = _idCentro;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarUnidad()
-- -----------------------------------------------------
-- DROP FUNCTION spAgregarUnidad(text,text,int,int);
CREATE OR REPLACE FUNCTION spAgregarUnidad(_codigo int, _idPadre int, _nombre text, _idTipo int) RETURNS void as 
$BODY$
BEGIN
	INSERT INTO adm_unidadacademica(unidadacademica, unidadacademicasuperior, nombre, tipo) VALUES (_codigo, _idPadre, _nombre, _idTipo);
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarCentroUnidad()
-- -----------------------------------------------------
-- DROP FUNCTION spAgregarCentroUnidad(int,int);
CREATE OR REPLACE FUNCTION spAgregarCentroUnidad(_centro int, _unidad int) RETURNS void as 
$BODY$
Declare id integer;
BEGIN
  select * from spObtenerSecuencia('centro_unidadacademica','adm_centro_unidadacademica') into id;
  INSERT INTO adm_centro_unidadacademica(centro_unidadacademica, centro, unidadacademica,estado)
	 VALUES (id, _centro, _unidad, 1);

END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spQuitarCentroUnidad()
-- -----------------------------------------------------
-- DROP FUNCTION spQuitarCentroUnidad(int,int);
CREATE OR REPLACE FUNCTION spQuitarCentroUnidad(_centro int, _unidad int) RETURNS void as 
$BODY$
BEGIN
  DELETE FROM adm_centro_unidadacademica WHERE centro=_centro AND unidadacademica=_unidad;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spCambiarEstadoCentroUnidad()
-- -----------------------------------------------------
-- DROP FUNCTION spCambiarEstadoCentroUnidad(int,int,int);
CREATE OR REPLACE FUNCTION spCambiarEstadoCentroUnidad(_estado int, _centro int, _unidad int) RETURNS void as 
$BODY$
BEGIN
  UPDATE adm_centro_unidadacademica SET estado = _estado  WHERE centro = _centro AND unidadacademica = _unidad;
END;
$BODY$
LANGUAGE 'plpgsql';

Select 'Script para Gestion Centro-Unidad Instalado' as "Gestion Centro Unidad";