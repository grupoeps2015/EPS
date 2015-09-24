-- -----------------------------------------------------
-- Function: spAgregarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarparametro(text, text, text, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarParametro(_nombre text, _valor text,
					      _descripcion text, 
					      _centro_unidadacademica integer, _carrera integer,
					      _codigo integer, _tipoparametro integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_parametro(
            parametro, nombre,valor,descripcion,centro_unidadacademica,carrera,codigo,tipoparametro,estado)
	VALUES (DEFAULT,_nombre,_valor,_descripcion,_centro_unidadacademica,_carrera,_codigo,_tipoparametro,0);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spInformacionParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionParametro(integer);
CREATE OR REPLACE FUNCTION spInformacionParametro(idCentroUnidadAcademica integer, OUT Parametro int, OUT NombreParametro text, 
					          OUT ValorParametro text, OUT DescripcionParametro text, 
					          OUT NombreCentro text, OUT NombreUnidadAcademica text, 
					          OUT NombreCarrera text, OUT CodigoParametro int, 
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
	 p.codigo AS CodigoParametro,
	 tp.nombre AS NombreTipoParametro,
	 p.estado AS EstadoParametro
  FROM ADM_Parametro p
	JOIN ADM_Centro_UnidadAcademica cu ON cu.centro_unidadacademica = p.centro_unidadacademica
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = cu.unidadacademica
	JOIN ADM_Centro c ON c.centro = cu.centro
	JOIN CUR_Carrera car ON car.carrera = p.carrera
	JOIN ADM_TipoParametro tp ON tp.tipoparametro = p.tipoparametro
	WHERE cu.centro_unidadacademica = $1
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
					    OUT CodigoParametro int, OUT NombreTipoParametro text, OUT TipoParametro int) RETURNS setof record as 
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
         p.codigo AS CodigoParametro,
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
						_codigo integer, 
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
	   codigo = COALESCE(spModificarParametro._codigo, ADM_Parametro.codigo),
	   estado = COALESCE(spModificarParametro._estado, ADM_Parametro.estado),
	   tipoparametro = COALESCE(spModificarParametro._tipoparametro, ADM_Parametro.tipoparametro)
     WHERE ADM_Parametro.parametro = spModificarParametro._parametro;       
    RETURN FOUND;
END;
$$;

-- -----------------------------------------------------
-- Function: spConsultaCentroUnidadacademica()
-- -----------------------------------------------------
-- DROP FUNCTION spConsultaCentroUnidadacademica(integer);
CREATE OR REPLACE FUNCTION spConsultaCentroUnidadacademica(CentroUnidad integer, OUT NombreCentro text, OUT NombreUnidadAcademica text, OUT Centro_UnidadAcademica int) RETURNS setof record as 
$BODY$

  DECLARE
  sql text := 'SELECT c.nombre AS NombreCentro, ua.nombre AS NombreUnidadAcademica, cu.centro_unidadacademica AS Centro_UnidadAcademica
  FROM ADM_Centro_UnidadAcademica cu
  JOIN ADM_Centro c ON c.Centro = cu.Centro
  JOIN ADM_UnidadAcademica ua ON ua.UnidadAcademica = cu.UnidadAcademica';
BEGIN
   IF $1 != 0 THEN
      sql := sql || ' WHERE cu.centro_unidadacademica = ' || $1;
	  sql := sql || ' ORDER BY c.nombre;';
	ELSE 
	  sql := sql || ' ORDER BY c.nombre;';
   END IF;

   RETURN QUERY EXECUTE sql;
   
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


-- Function: spinformacionperiodoparametro(integer)

-- DROP FUNCTION spinformacionperiodoparametro(integer);

CREATE OR REPLACE FUNCTION spinformacionperiodoparametro(
    IN _centrounidad integer,
	OUT id integer,
    OUT anio integer,
    OUT ciclo integer,
    OUT nombreciclo text,
    OUT tipo text,
    OUT asignacion text,
    OUT inicio date,
    OUT fin date,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query select
		per.periodo,
		cic.anio, cic.ciclo,
		to_char(cic.numerociclo, 'FMRN') || ' ' || tip.nombre ,
		tipper.nombre,
		tipasi.nombre,
		per.fechainicial,
		per.fechafinal,
		case 
			when per.estado=0 then 'Validación Pendiente'
			when per.estado=1 then 'Activo'
			when per.estado=-1 then 'Desactivado'
		end as "Estado"
	      from 
	        cur_ciclo cic
	      join cur_tipociclo tip on tip.tipociclo = cic.tipociclo
	      join adm_periodo per on cic.ciclo = per.ciclo
	      join adm_tipoperiodo tipper on per.tipoperiodo = tipper.tipoperiodo
	      join adm_tipoasignacion tipasi on per.tipoasignacion = tipasi.tipoasignacion
	      where per.centro_unidadacademica = _centrounidad order by cic.anio desc;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacionperiodoparametro(integer)
  OWNER TO postgres;

  
-- Function: spactivardesactivarperiodoparametro(integer, integer)

-- DROP FUNCTION spactivardesactivarperiodoparametro(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarperiodoparametro(
    _idperiodo integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_periodo SET estado = %L WHERE periodo = %L',_estadoNuevo,_idperiodo);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarperiodoparametro(integer, integer)
  OWNER TO postgres;
  
  
-- Function: spagregarperiodoparametro(integer, integer, integer, text, text, integer)

-- DROP FUNCTION spagregarperiodoparametro(integer, integer, integer, text, text, integer);

CREATE OR REPLACE FUNCTION spagregarperiodoparametro(
    _ciclo integer,
    _tipoperiodo integer,
    _tipoasign integer,
    _fechainicial text,
    _fechafinal text,
    _centrounidad integer)
  RETURNS integer AS
$BODY$
DECLARE idPeriodo integer;
BEGIN
	INSERT INTO adm_periodo (ciclo, fechainicial, fechafinal, tipoperiodo, estado, tipoasignacion, centro_unidadacademica) 
	VALUES (_ciclo, case when _fechainicial <> '' then cast(_fechainicial as date) else null end, case when _fechafinal <> '' then cast(_fechafinal as date) else null end, _tipoperiodo, 1, _tipoasign, _centrounidad) RETURNING Periodo into idPeriodo;
	RETURN idPeriodo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  
-- Function: spactualizarperiodoparametro(integer, integer, integer, integer, text, text)

-- DROP FUNCTION spactualizarperiodoparametro(integer, integer, integer, integer, text, text);

CREATE OR REPLACE FUNCTION spactualizarperiodoparametro(
    _id integer,
    _ciclo integer,
    _tipoperiodo integer,
    _tipoasign integer,
    _fechainicial text,
    _fechafinal text)
  RETURNS integer AS
$BODY$
DECLARE idPeriodo integer;
BEGIN
	UPDATE ADM_Periodo SET ciclo = _ciclo, tipoperiodo = _tipoperiodo, tipoasignacion = _tipoasign, fechainicial = case when _fechainicial <> '' then cast(_fechainicial as date) else null end, fechafinal = case when _fechafinal <> '' then cast(_fechafinal as date) else null end
	WHERE periodo = _id RETURNING Periodo into idPeriodo;
	RETURN idPeriodo;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarperiodoparametro(integer, integer, integer, integer, text, text)
  OWNER TO postgres;

  
-- Function: spdatosperiodoparametro(integer)

-- DROP FUNCTION spdatosperiodoparametro(integer);

CREATE OR REPLACE FUNCTION spdatosperiodoparametro(
    IN id integer,
    OUT ciclo integer,
    OUT tipoperiodo integer,
    OUT tipoasignacion integer,
    OUT fechainicial text,
    OUT fechafinal text,
    OUT anio integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT p.ciclo, p.tipoperiodo, p.tipoasignacion, to_char(p.fechainicial, 'DD/MM/YYYY'), to_char(p.fechafinal, 'DD/MM/YYYY'), c.anio from adm_periodo p join cur_ciclo c on c.ciclo = p.ciclo
  where p.periodo = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatosperiodoparametro(integer)
  OWNER TO postgres;
