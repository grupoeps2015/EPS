--************************************************ Function: spconsultadeptos() ************************************************
DROP FUNCTION spagregarusuarios(integer, text, text, text, integer, text, text, timestamp without time zone, integer, text, integer);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(
	_usuario integer,
	_nombre text,
	_correo text,
	_clave text,
	_estado integer,
	_preguntasecreta text,
	_respuestasecreta text,
	_fechaultimaautenticacion timestamp,
	_integerentosautenticacion integer,
	_foto text,
	_unidadacademica integer
)
RETURNS void AS $BODY$
BEGIN

 INSERT INTO adm_usuario VALUES (_usuario, _nombre, _correo, _clave, _estado, _preguntasecreta, _respuestasecreta, 
				 _fechaultimaautenticacion, _integerentosautenticacion, _foto, _unidadacademica);
END;
$BODY$
LANGUAGE 'plpgsql';

--************************************************ Function: spconsultadeptos() ************************************************
DROP FUNCTION spconsultadeptos();

CREATE OR REPLACE FUNCTION spConsultaDeptos(
	OUT departamento int,
	OUT nombre text
) RETURNS setof record AS

$BODY$
begin
 return query select * from adm_departamento order by departamento;
end;
$BODY$
LANGUAGE 'plpgsql';

SELECT * from spConsultaDeptos()