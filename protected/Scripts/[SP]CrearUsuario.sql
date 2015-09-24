-- -----------------------------------------------------
-- Function: spInformacionUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionUsuario(int,int);
CREATE OR REPLACE FUNCTION spInformacionUsuario(IN _cenuni int, 
						OUT Id int, OUT registro int, OUT nombre text, 
						OUT Rol text, OUT Correo text, OUT Estado text) RETURNS setof record as 
$BODY$
BEGIN 
  RETURN query
  Select 
    u.usuario,
    coalesce((select Carnet from Est_Estudiante where usuario=u.usuario),
	     (select registropersonal from Adm_Empleado where usuario=u.usuario),
	     (select registropersonal from Cat_Catedratico where usuario=u.usuario)),
    coalesce((select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Est_Estudiante where usuario=u.usuario),
	     (select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Cat_Catedratico where usuario=u.usuario),
	     (select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Adm_Empleado where usuario=u.usuario)),
    case
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 0 then 'Administrador'
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 1 then 'Estudiante'
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 2 then 'Catedratico'
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 3 then 'Empleado'
	else 'No hay rol asociado'
    end as "Rol",
    u.correo,
    case 
	when u.estado=0 then 'Validacion Pendiente'
	when u.estado=1 then 'Activo'
	when u.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    adm_Usuario u
  where 
    u.centro_unidadacademica = _cenuni
  order by 
    u.usuario;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarUsuarios()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarusuarios(text, text, text, int, text, int, text, int);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(_nombre text, _correo text,
					     _clave text, _preguntasecreta integer,
					     _respuestasecreta text, _intentosautenticacion int,
					     _foto text, _centrounidad int) RETURNS integer AS $BODY$
DECLARE idUsuario integer;
DECLARE fecha timestamp;
BEGIN
	SELECT current_timestamp into fecha;
	INSERT INTO adm_usuario (usuario, nombre, correo, clave, estado, preguntasecreta, respuestasecreta, 
		fechaultimaautenticacion, intentosautenticacion, foto, centro_unidadacademica) 
	VALUES (DEFAULT,_nombre, _correo, _clave, 0, _preguntasecreta, _respuestasecreta, 
		fecha, _intentosautenticacion, _foto, _centrounidad);

	SELECT usuario from adm_usuario where nombre=_nombre and clave=_clave and fechaultimaautenticacion = fecha into idUsuario;
	RETURN idUsuario;
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarEstudiante()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarestudiante(integer, text, integer, integer, text, text, text, text, boolean, text, integer, text, text, text, text, int);

CREATE OR REPLACE FUNCTION spAgregarEstudiante(_carnet integer, 
					       _direccion text,
					       _zona integer, 
					       _municipio integer,
					       _telefono text, 
					       _emergencia text,
					       _tiposangre text, 
					       _alergias text,
					       _segurovida boolean,
					       _centroemergencia text,
					       _paisorigen int,
					       _primernombre text,
					       _segundonombre text,
					       _primerapellido text,
					       _segundoapellido text,
					       _idUsuario int
					       ) RETURNS void AS 
$BODY$
DECLARE id integer;
BEGIN 
	SELECT * FROM spObtenerSecuencia('estudiante','est_estudiante') into id;
	INSERT INTO est_estudiante(
            estudiante, carnet, direccion, zona, municipio, telefono, estado, 
            telefonoemergencia, tiposangre, alergias, segurovida, centroemergencia, 
            usuario, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (id, _carnet, _direccion, _zona, _municipio, _telefono, 0, 
            _emergencia, _tiposangre, _alergias, _segurovida, _centroemergencia, 
            _idUsuario, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarEmpleado()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarempleado(integer, text, integer, integer, text, integer, text, text, text, text, int); 
CREATE OR REPLACE FUNCTION spAgregarEmpleado(_registro integer, 
					     _direccion text,
					     _zona integer, 
					     _municipio integer,
					     _telefono text, 
					     _paisorigen int,
					     _primernombre text,
					     _segundonombre text,
					     _primerapellido text,
					     _segundoapellido text,
					     _idUsuario int
					     ) RETURNS void AS 
$BODY$
DECLARE id integer;
BEGIN 
	SELECT * FROM spObtenerSecuencia('empleado','adm_empleado') into id;
	INSERT INTO adm_empleado(
            empleado, registropersonal, direccion, zona, municipio, telefono, 
            usuario, estado, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (id, _registro, _direccion, _zona, _municipio, _telefono,
            _idUsuario, 0, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarCatedratico()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarcatedratico(integer, text, integer, integer, text, integer, integer, text, text, text, text, int);
CREATE OR REPLACE FUNCTION spAgregarCatedratico(_registro integer, 
						_direccion text,
						_zona integer, 
						_municipio integer,
						_telefono text, 
						_tipodocente int,
						_paisorigen int,
						_primernombre text,
						_segundonombre text,
						_primerapellido text,
						_segundoapellido text,
						_idUsuario int
						) RETURNS void AS 
$BODY$
DECLARE id integer;
BEGIN 
	SELECT * FROM spObtenerSecuencia('catedratico','cat_catedratico') into id;
	INSERT INTO cat_catedratico(
            catedratico, registropersonal, direccion, zona, municipio, telefono, 
            tipodocente, usuario, estado, paisorigen, primernombre, segundonombre, 
            primerapellido, segundoapellido)
	VALUES (id, _registro, _direccion, _zona, _municipio, _telefono, _tipodocente,
            _idUsuario, 0, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spAsignarRolUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spAsignarRolUsuario(integer);

CREATE OR REPLACE FUNCTION spAsignarRolUsuario(_rol integer, _usuario integer) RETURNS void AS $BODY$
BEGIN
	INSERT INTO adm_rol_usuario(rol, usuario)
	VALUES (_rol, _usuario);
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spActivarDesactivarUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spActivarDesactivarUsuario(int,int);
CREATE OR REPLACE FUNCTION spActivarDesactivarUsuario(_idUsuario int,_estadoNuevo int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_usuario SET estado = %L WHERE usuario = %L',_estadoNuevo,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spdatosusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spdatosusuario(int);

CREATE OR REPLACE FUNCTION spdatosusuario(Id int, 
					  OUT nombre text, OUT correo text, 
					  OUT unidadacademica text, OUT clave text, OUT idPregunta int,
					  OUT preguntasecreta text, OUT respuestasecreta text, 
                                          OUT unidadCentro int, OUT estado int ) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query EXECUTE format('SELECT u.nombre, 
				      u.correo, 
				      (select ua.nombre from adm_unidadacademica ua where ua.unidadacademica = cen.unidadacademica),
				      u.clave,
				      ps.preguntasecreta,
				      ps.descripcion, 
				      u.respuestasecreta,
				      u.centro_unidadacademica,
                                      u.estado
			       FROM adm_usuario u 
				      JOIN adm_centro_unidadacademica cen ON u.centro_unidadacademica = cen.unidadacademica 
				      JOIN adm_preguntasecreta ps ON u.preguntasecreta = ps.preguntasecreta 
			       WHERE usuario = %s',Id);
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spactualizarusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spactualizarusuario(integer, text, text, integer, text);

CREATE OR REPLACE FUNCTION spactualizarusuario(
    _idusuario integer,
    _correonuevo text,
    _passwordNuevo text,
    _preguntasecretanueva integer,
    _respuestasecretanueva text
   )
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_usuario SET correo = %L, clave = %L, 
					 preguntasecreta = %L, 
					 respuestasecreta = %L
				     WHERE usuario = %L',
					_correoNuevo, _passwordNuevo, _preguntasecretaNueva, _respuestasecretaNueva, _idUsuario);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

ALTER FUNCTION spactualizarusuario(integer, text, text, integer, text)
  OWNER TO postgres;

Select 'Script para Gestion de usuarios Instalado' as "Gestion Usuarios";