--************************************************ Function: spAgregarUsuarios() ************************************************
DROP FUNCTION spagregarusuarios(text, text, text, text, text, integer, text, integer);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(
	_nombre text,
	_correo text,
	_clave text,
	_preguntasecreta text,
	_respuestasecreta text,
	_integerentosautenticacion integer,
	_foto text,
	_unidadacademica integer
)
RETURNS void AS $BODY$
BEGIN

 INSERT INTO adm_usuario VALUES (DEFAULT,_nombre, _correo, _clave, 0, _preguntasecreta, _respuestasecreta, 
				 current_timestamp, _integerentosautenticacion, _foto, _unidadacademica);
END;
$BODY$
LANGUAGE 'plpgsql';
select * from adm_usuario

--************************************************ Function: spconsultausuarios() ************************************************
DROP FUNCTION spconsultausuarios();

CREATE OR REPLACE FUNCTION spconsultausuarios(
	OUT usuario int,
	OUT nombre text,
	OUT correo text
) RETURNS setof record AS

$BODY$
begin
 return query select usr.usuario, usr.nombre, usr.correo from adm_usuario usr;
end;
$BODY$
LANGUAGE 'plpgsql';

--************************************************ Function: spconsultadepartamentos() ************************************************
DROP FUNCTION spconsultadeptos();

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