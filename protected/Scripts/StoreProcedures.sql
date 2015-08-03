-- -----------------------------------------------------
-- Function: spAgregarUsuarios()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarusuarios(text, text, text, integer, text, integer, text, integer);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(_nombre text, _correo text,
					     _clave text, _preguntasecreta integer,
					     _respuestasecreta text, _integerentosautenticacion integer,
					     _foto text, _unidadacademica integer) RETURNS void AS $BODY$
BEGIN
	INSERT INTO adm_usuario (usuario, nombre, correo, clave, estado, preguntasecreta, respuestasecreta, 
		fechaultimaautenticacion, intenentosautenticacion, foto, unidadacademica) 
	VALUES (DEFAULT,_nombre, _correo, _clave, 0, _preguntasecreta, _respuestasecreta, 
		current_timestamp, _integerentosautenticacion, _foto, _unidadacademica);
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