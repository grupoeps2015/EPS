﻿-- -----------------------------------------------------
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