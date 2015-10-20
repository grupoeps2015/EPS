-- -----------------------------------------------------
-- Function: spautenticarusuario(integer, text, text, text, integer)
-- -----------------------------------------------------
-- DROP FUNCTION spautenticarusuario(integer, text, text, text, integer);
CREATE OR REPLACE FUNCTION spautenticarusuario(
    IN _id integer,
    IN _clave text,
    IN _campo text,
    IN _tabla text,
    IN _maxintentos integer,
    OUT usuario integer,
    OUT nombre text,
    OUT estado integer,
    OUT rol integer,
	OUT centrounidadacademica integer)
  RETURNS SETOF record AS
$BODY$
 declare idUsuario INTEGER;
 declare autCorrecto INTEGER;
 declare intentos INTEGER; 
begin

 EXECUTE format('SELECT adm_usuario.usuario FROM adm_usuario join %s on adm_usuario.usuario = %s.usuario and %s.%s = %s join adm_rol_usuario on adm_rol_usuario.usuario = adm_usuario.usuario join adm_centro_unidadacademica_usuario on adm_usuario.usuario = adm_centro_unidadacademica_usuario.usuario where adm_usuario.estado = 1', _tabla, _tabla, _tabla, _campo, _id) INTO idUsuario;
 
 SELECT u.usuario into autCorrecto FROM adm_usuario u WHERE u.usuario = idUsuario and u.clave = _clave;
 
 IF idUsuario IS NOT NULL AND autCorrecto IS NULL THEN
	UPDATE adm_usuario set intentosautenticacion = intentosautenticacion + 1 
	WHERE adm_usuario.usuario = idUsuario RETURNING intentosautenticacion INTO intentos;
	IF _maxintentos <> -1 THEN
		IF _maxintentos < intentos THEN
			UPDATE adm_usuario set estado = -1, intentosautenticacion = 0
			WHERE adm_usuario.usuario = idUsuario;
		END IF;
	END IF;
 END IF;
 
 Return query EXECUTE format('SELECT adm_usuario.usuario, adm_usuario.nombre, adm_usuario.estado, adm_rol_usuario.rol, adm_centro_unidadacademica_usuario.centro_unidadacademica FROM adm_usuario join %s on adm_usuario.usuario = %s.usuario and %s.%s = %s and adm_usuario.clave = ''%s'' join adm_rol_usuario on adm_rol_usuario.usuario = adm_usuario.usuario join adm_centro_unidadacademica_usuario on adm_usuario.usuario = adm_centro_unidadacademica_usuario.usuario where adm_centro_unidadacademica_usuario.estado = 1', _tabla, _tabla, _tabla, _campo, _id, _clave);

end;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spautenticarusuario(integer, text, text, text, integer)
  OWNER TO postgres;

----------------------------------------------------------------------------------------
-- Function: spvalidarpermisousuario(integer, integer)
----------------------------------------------------------------------------------------
-- DROP FUNCTION spvalidarpermisousuario(integer, integer);
CREATE OR REPLACE FUNCTION spvalidarpermisousuario(
    _funcion integer,
    _rol integer)
  RETURNS integer AS
$BODY$
DECLARE resultado integer;
BEGIN
	select count(*) FROM ADM_Rol_Funcion where Rol = _rol and Funcion = _funcion into resultado;
	RETURN resultado;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spvalidarpermisousuario(integer, integer)
  OWNER TO postgres;

----------------------------------------------------------------------------------------
-- Function: spactualizarautenticacion(integer)
----------------------------------------------------------------------------------------
-- DROP FUNCTION spactualizarautenticacion(integer);
CREATE OR REPLACE FUNCTION spactualizarautenticacion(_usuario integer)
  RETURNS integer AS
$BODY$
DECLARE fecha timestamp;
BEGIN
	SELECT current_timestamp into fecha;
	UPDATE adm_usuario set fechaultimaautenticacion = fecha, intentosautenticacion = 0 
	WHERE usuario = _usuario;
	RETURN 0;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarautenticacion(integer)
  OWNER TO postgres;

Select 'Scripts de Login Instalados' as "Login";