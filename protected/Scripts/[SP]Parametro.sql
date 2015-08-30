-- -----------------------------------------------------
-- Function: spAgregarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarparametro(text, text, text, integer, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarParametro(_nombre text, _valor text,
					      _descripcion text, _centro integer,
					      _unidadacademica integer, _carrera integer,
					      _extension integer, _tipoparametro integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_parametro(
            parametro, nombre,valor,descripcion,centro,unidadacademica,carrera,extension,tipoparametro,estado)
	VALUES (DEFAULT,_nombre,_valor,_descripcion,_centro,_unidadacademica,_carrera,_extension,_tipoparametro,0);

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
	JOIN ADM_Centro c ON c.centro = p.centro
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = p.unidadacademica
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
					    OUT NombreUnidadAcademica text, OUT NombreCarrera text, 
					    OUT ExtensionParametro int, OUT NombreTipoParametro text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT p.nombre AS NombreParametro,
         p.valor AS ValorParametro,
         p.descripcion AS DescripcionParametro,
         c.nombre AS NombreCentro,
         ua.nombre AS NombreUnidadAcademica,
         car.nombre AS NombreCarrera,
         p.extension AS ExtensionParametro,
         tp.nombre AS NombreTipoParametro
  FROM ADM_Parametro p
	JOIN ADM_Centro c ON c.centro = p.centro
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = p.unidadacademica
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
					        _centro integer,
					        _unidadacademica integer, 
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
           centro = COALESCE(spModificarParametro._centro, ADM_Parametro.centro),
	   unidadacademica = COALESCE(spModificarParametro._unidadacademica, ADM_Parametro.unidadacademica),
	   carrera = COALESCE(spModificarParametro._carrera, ADM_Parametro.carrera),
	   extension = COALESCE(spModificarParametro._extension, ADM_Parametro.extension),
	   estado = COALESCE(spModificarParametro._estado, ADM_Parametro.estado),
	   tipoparametro = COALESCE(spModificarParametro._tipoparametro, ADM_Parametro.tipoparametro)
     WHERE ADM_Parametro.parametro = spModificarParametro._parametro;       
    RETURN FOUND;
END;
$$;

