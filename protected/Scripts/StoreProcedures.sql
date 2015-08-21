-- -----------------------------------------------------
-- Function: spAgregarUsuarios()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarusuarios(text, text, text, integer, text, integer, text, integer);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(_nombre text, _correo text,
					     _clave text, _preguntasecreta integer,
					     _respuestasecreta text, _intentosautenticacion integer,
					     _foto text, _unidadacademica integer) RETURNS integer AS $BODY$
DECLARE idUsuario integer;
DECLARE fecha timestamp;
BEGIN
	SELECT current_timestamp into fecha;
	INSERT INTO adm_usuario (usuario, nombre, correo, clave, estado, preguntasecreta, respuestasecreta, 
		fechaultimaautenticacion, intentosautenticacion, foto, unidadacademica) 
	VALUES (DEFAULT,_nombre, _correo, _clave, 0, _preguntasecreta, _respuestasecreta, 
		fecha, _intentosautenticacion, _foto, _unidadacademica);

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
BEGIN
	INSERT INTO est_estudiante(
            estudiante, carnet, direccion, zona, municipio, telefono, estado, 
            telefonoemergencia, tiposangre, alergias, segurovida, centroemergencia, 
            usuario, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (DEFAULT, _carnet, _direccion, _zona, _municipio, _telefono, 0, 
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
BEGIN
	INSERT INTO adm_empleado(
            empleado, registropersonal, direccion, zona, municipio, telefono, 
            usuario, estado, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (DEFAULT, _registro, _direccion, _zona, _municipio, _telefono,
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
BEGIN
	INSERT INTO cat_catedratico(
            catedratico, registropersonal, direccion, zona, municipio, telefono, 
            tipodocente, usuario, estado, paisorigen, primernombre, segundonombre, 
            primerapellido, segundoapellido)
	VALUES (DEFAULT, _registro, _direccion, _zona, _municipio, _telefono, _tipodocente,
            _idUsuario, 0, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spObtenerSecuencia()
-- -----------------------------------------------------
-- DROP FUNCTION spObtenerSecuencia(text,text);
CREATE OR REPLACE FUNCTION spObtenerSecuencia(_campo text, _tabla text) RETURNS int as $BODY$
DECLARE secuencia int;
BEGIN
	EXECUTE format('SELECT max(%s) FROM %s',_campo, _tabla) into secuencia;
	RETURN secuencia+1;
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spconsultageneral()
-- -----------------------------------------------------
-- DROP FUNCTION spconsultageneral(text,text);

CREATE OR REPLACE FUNCTION spconsultageneral(IN _campos text,IN _tabla text,OUT codigo int,OUT nombre text) RETURNS setof record AS
$BODY$
begin
 Return query EXECUTE format('SELECT %s FROM %s',_campos, _tabla);
end;
$BODY$
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
-- Function: spInformacionUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionUsuario();
CREATE OR REPLACE FUNCTION spInformacionUsuario(OUT Id int, OUT registro int, OUT nombre text, OUT Rol text, OUT Correo text, OUT Estado text) RETURNS setof record as 
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
    ADM_Usuario u
  where 
    u.usuario > 1
  order by 
    u.usuario;
END;
$BODY$
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
-- Function: spAgregarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarparametro(text, text, text, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarParametro(_nombre integer, 
					     _valor text,
					     _descripcion text, 
					     _centro integer,
					     _unidadacademica integer, 
					     _carrera integer,
						 _extension integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_parametro(
            parametro, nombre,valor,descripcion,centro,unidadacademica,carrera,extension)
	VALUES (DEFAULT,_nombre,_valor,_descripcion,_centro,_unidadacademica,_carrera,_extension,0);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spautenticarusuario(integer, text, text, text)
-- -----------------------------------------------------
-- DROP FUNCTION spautenticarusuario(integer, text, text, text);

CREATE OR REPLACE FUNCTION spautenticarusuario(
    IN _id integer,
    IN _clave text,
    IN _campo text,
    IN _tabla text,
    OUT usuario integer,
    OUT nombre text,
    OUT estado integer,
    OUT rol integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query EXECUTE format('SELECT adm_usuario.usuario, adm_usuario.nombre, adm_usuario.estado, adm_rol_usuario.rol FROM adm_usuario join %s on adm_usuario.usuario = %s.usuario and %s.%s = %s and adm_usuario.clave = ''%s'' join adm_rol_usuario on adm_rol_usuario.usuario = adm_usuario.usuario', _tabla, _tabla, _tabla, _campo, _id, _clave);

end;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spautenticarusuario(integer, text, text, text)
  OWNER TO postgres;
  
  
-- -----------------------------------------------------
-- Function: spdatosusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spdatosusuario(int);

CREATE OR REPLACE FUNCTION spdatosusuario(Id int, OUT nombre text, out correo text, OUT unidadacademica text, OUT preguntasecreta text, OUT respuestasecreta text ) 
RETURNS setof record as 
$BODY$
BEGIN
  RETURN query EXECUTE format('SELECT u.nombre, u.correo, ua.nombre, ps.descripcion, u.respuestasecreta FROM adm_usuario u JOIN adm_unidadacademica ua ON u.unidadacademica = ua.unidadacademica 
  JOIN adm_preguntasecreta ps ON u.preguntasecreta = ps.preguntasecreta WHERE usuario = %s',Id);
END;
$BODY$
LANGUAGE 'plpgsql';
  
-- -----------------------------------------------------
-- Function: spactualizarusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spactualizarusuario(int,int);
CREATE OR REPLACE FUNCTION spactualizarusuario(_idUsuario int,_nombreNuevo text, _correoNuevo text,
					     _claveNueva text, _preguntasecretaNueva int,
					     _respuestasecretaNueva text,
					     _fotoNueva text, _unidadacademicaNueva int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_usuario SET nombre = %s, correo = %s,
					     clave = %s, preguntasecreta = %s, respuestasecreta = %s, 
					     foto = %s, unidadacademica = %L WHERE usuario = %L',_nombreNuevo, _correoNuevo,
					     _claveNueva, _preguntasecretaNueva,_respuestasecretaNueva,_fotoNueva, _unidadacademicaNueva,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';



