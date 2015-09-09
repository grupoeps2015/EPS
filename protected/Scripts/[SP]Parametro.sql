-- -----------------------------------------------------
-- Function: spAgregarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarparametro(text, text, text, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarParametro(_nombre text, _valor text,
					      _descripcion text, 
					      _centro_unidadacademica integer, _carrera integer,
					      _extension integer, _tipoparametro integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_parametro(
            parametro, nombre,valor,descripcion,centro_unidadacademica,carrera,extension,tipoparametro,estado)
	VALUES (DEFAULT,_nombre,_valor,_descripcion,_centro_unidadacademica,_carrera,_extension,_tipoparametro,0);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spInformacionParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionParametro();
CREATE OR REPLACE FUNCTION spInformacionParametro(OUT Parametro int, OUT NombreParametro text, 
					          OUT ValorParametro text, OUT DescripcionParametro text, 
					          OUT NombreCentro text, OUT NombreUnidadAcademica text, 
					          OUT NombreCarrera text, OUT ExtensionParametro int, 
					          OUT NombreTipoParametro text, OUT EstadoParametro int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT p.parametro AS Parametro,
	 p.nombre AS NombreParametro,
	 p.valor AS ValorParametro,
	 p.descripcion AS DescripcionParametro,
	 c.nombre AS NombreCentro,
	 ua.nombre AS NombreUnidadAcademica,
	 car.nombre AS NombreCarrera,
	 p.extension AS ExtensionParametro,
	 tp.nombre AS NombreTipoParametro,
	 p.estado AS EstadoParametro
  FROM ADM_Parametro p
	JOIN ADM_Centro_UnidadAcademica cu ON cu.centro_unidadacademica = p.centro_unidadacademica
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = cu.unidadacademica
	JOIN ADM_Centro c ON c.centro = cu.centro
	JOIN CUR_Carrera car ON car.carrera = p.carrera
	JOIN ADM_TipoParametro tp ON tp.tipoparametro = p.tipoparametro
	ORDER BY p.nombre;

END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spdatosparametro()
-- -----------------------------------------------------
-- DROP FUNCTION spdatosparametro(int);

CREATE OR REPLACE FUNCTION spDatosParametro(Parametro int, 
					    OUT NombreParametro text, OUT ValorParametro text, 
					    OUT DescripcionParametro text, OUT NombreCentro text, 
					    OUT NombreUnidadAcademica text, OUT CentroUnidadAcademica int, OUT NombreCarrera text,  OUT Carrera int,
					    OUT ExtensionParametro int, OUT NombreTipoParametro text, OUT TipoParametro int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT p.nombre AS NombreParametro, 
         p.valor AS ValorParametro,
         p.descripcion AS DescripcionParametro,
         c.nombre AS NombreCentro,
         ua.nombre AS NombreUnidadAcademica,
		 p.centro_unidadacademica AS CentroUnidadAcademica,
         car.nombre AS NombreCarrera,
		 p.carrera AS Carrera,
         p.extension AS ExtensionParametro,
         tp.nombre AS NombreTipoParametro,
		 p.tipoparametro AS TipoParametro
  FROM ADM_Parametro p
	JOIN ADM_Centro_UnidadAcademica cu ON cu.centro_unidadacademica = p.centro_unidadacademica
	JOIN ADM_Centro c ON c.centro = cu.centro
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = cu.unidadacademica
	JOIN CUR_Carrera car ON car.carrera = p.carrera
	JOIN ADM_TipoParametro tp ON tp.tipoparametro = p.tipoparametro
	WHERE p.parametro = $1;

END;
$BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spModificarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spmodificarparametro(integer, text, text, text, integer, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spModificarParametro(_parametro integer, 
						_nombre text, 
					        _valor text,
					        _descripcion text, 
					        _centro_unidadacademica integer,
					        _carrera integer,
						_extension integer, 
						_estado integer,
						_tipoparametro integer
					     )RETURNS BOOLEAN LANGUAGE plpgsql SECURITY DEFINER AS $$

BEGIN
    UPDATE ADM_Parametro
       SET nombre = COALESCE(spModificarParametro._nombre, ADM_Parametro.nombre),
           valor = COALESCE(spModificarParametro._valor, ADM_Parametro.valor),
           descripcion = COALESCE(spModificarParametro._descripcion, ADM_Parametro.descripcion),
           centro_unidadacademica = COALESCE(spModificarParametro._centro_unidadacademica, ADM_Parametro.centro_unidadacademica),
	   carrera = COALESCE(spModificarParametro._carrera, ADM_Parametro.carrera),
	   extension = COALESCE(spModificarParametro._extension, ADM_Parametro.extension),
	   estado = COALESCE(spModificarParametro._estado, ADM_Parametro.estado),
	   tipoparametro = COALESCE(spModificarParametro._tipoparametro, ADM_Parametro.tipoparametro)
     WHERE ADM_Parametro.parametro = spModificarParametro._parametro;       
    RETURN FOUND;
END;
$$;

-- -----------------------------------------------------
-- Function: spConsultaCentroUnidadacademica()
-- -----------------------------------------------------
-- DROP FUNCTION spConsultaCentroUnidadacademica();
CREATE OR REPLACE FUNCTION spConsultaCentroUnidadacademica(OUT NombreCentro text, OUT NombreUnidadAcademica text, OUT Centro_UnidadAcademica int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT c.nombre AS NombreCentro, ua.nombre AS NombreUnidadAcademica, cu.centro_unidadacademica AS Centro_UnidadAcademica
  FROM ADM_Centro_UnidadAcademica cu
  JOIN ADM_Centro c ON c.Centro = cu.Centro
  JOIN ADM_UnidadAcademica ua ON ua.UnidadAcademica = cu.UnidadAcademica
  ORDER BY c.nombre;
END;
$BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spConsultaTipoParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spConsultaTipoParametro();
CREATE OR REPLACE FUNCTION spConsultaTipoParametro(OUT TipoParametro int, OUT NombreTipoParametro text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT tp.TipoParametro, tp.Nombre AS NombreTipoParametro 
  FROM ADM_TipoParametro tp
  ORDER BY tp.Nombre;
END;
$BODY$
LANGUAGE 'plpgsql';