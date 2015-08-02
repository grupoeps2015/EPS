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
-- Function: spconsultausuarios()
-- -----------------------------------------------------
-- DROP FUNCTION spconsultausuarios();

CREATE OR REPLACE FUNCTION spconsultausuarios(OUT usuario int,OUT nombre text,
					      OUT correo text) RETURNS setof record AS $BODY$
BEGIN
	RETURN query SELECT usr.usuario, usr.nombre, usr.correo FROM adm_usuario usr;
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spconsultarpreguntasecreta()
-- -----------------------------------------------------
-- DROP FUNCTION spconsultarpreguntasecreta();

CREATE OR REPLACE FUNCTION spconsultarpreguntasecreta(OUT id int,OUT pregunta text) RETURNS setof record AS $BODY$
BEGIN
	RETURN query SELECT * FROM adm_preguntasecreta pres where pres.preguntasecreta>0;
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
-- Function: spconsultadepartamentos()
-- -----------------------------------------------------
-- DROP FUNCTION spconsultadepartamentos();

CREATE OR REPLACE FUNCTION spconsultadepartamentos(
	OUT departamento int,
	OUT nombre text
) RETURNS setof record AS

$BODY$
begin
 return query select * from adm_departamento order by departamento;
end;
$BODY$
LANGUAGE 'plpgsql';

