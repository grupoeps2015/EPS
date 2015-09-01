﻿-- -----------------------------------------------------
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
-- Function: spconsultageneral2()
-- -----------------------------------------------------
-- DROP FUNCTION spconsultageneral2(text);

CREATE OR REPLACE FUNCTION spconsultageneral2(text)returns setof record as
'
declare
datos record;
begin
for datos in EXECUTE ''select * from '' || $1 loop
return next datos;
end loop;
return;
end
'
language 'plpgsql';
--Se llama a la función de la siguiente manera:
--select parametro from spconsultageneral2('adm_parametro') as par(parametro integer,nombre text, valor text,descripcion text, centro integer,unidadacademica integer, carrera integer,extension integer, estado integer,tipoparametro integer);

-- -----------------------------------------------------
-- Function: spMunicipioXDepto()
-- -----------------------------------------------------
-- DROP FUNCTION spMunicipioXDepto(integer);

CREATE OR REPLACE FUNCTION spMunicipioXDepto(IN _depto int, OUT codigo int, OUT nombre text) RETURNS setof record AS
$BODY$
begin
 Return query SELECT mun.municipio, mun.nombre FROM adm_municipio mun where mun.departamento = _depto;
end;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spcarreraxunidad()
-- -----------------------------------------------------
-- DROP FUNCTION spcarreraxunidad(integer);

CREATE OR REPLACE FUNCTION spcarreraxunidad(IN _unidad int, OUT codigo int, OUT nombre text) RETURNS setof record AS
$BODY$
begin
 Return query select c.carrera, c.nombre from cur_carrera c where c.unidadacademica =_unidad and c.estado = 1;
end;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spRolxUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spRolxUsuario(integer);

CREATE OR REPLACE FUNCTION spRolxUsuario(IN _idUsuario int) RETURNS integer AS
$BODY$
DECLARE idRol integer;
begin
 select rol from adm_rol_usuario where usuario = _idUsuario into idrol;
 Return idRol;
end;
$BODY$
LANGUAGE 'plpgsql';