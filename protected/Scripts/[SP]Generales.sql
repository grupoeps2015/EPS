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

-- -----------------------------------------------------
-- Function: spUnidadxCentro()
-- -----------------------------------------------------
-- DROP FUNCTION spUnidadxCentro(integer);

CREATE OR REPLACE FUNCTION spUnidadxCentro(IN _centro int, OUT codigo int, OUT nombre text) RETURNS setof record AS
$BODY$
begin
 Return query select distinct
		coalesce(uni.unidadacademica, 0),
		coalesce(uni.nombre,'No se encontro informacion')
	      from 
	        adm_unidadacademica uni, adm_centro_unidadacademica mix 
	      where mix.centro = _centro;
end;
$BODY$
LANGUAGE 'plpgsql';


-- Function: spcentrounidad(integer, integer)

-- DROP FUNCTION spcentrounidad(integer, integer);

CREATE OR REPLACE FUNCTION spcentrounidad(
    _centro integer,
    _unidad integer)
  RETURNS integer AS
$BODY$
DECLARE ID INTEGER;
begin
              select 
		centro_unidadacademica
	      from 
	        adm_centro_unidadacademica
	      where centro = _centro and unidadacademica = _unidad INTO ID; 
RETURN ID;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcentrounidad(integer, integer)
  OWNER TO postgres;
  

-- Function: spcicloxtipo(integer)

-- DROP FUNCTION spcicloxtipo(integer);

CREATE OR REPLACE FUNCTION spcicloxtipo(
    IN _tipo integer,
    OUT codigo integer,
    OUT nombre text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query select distinct
		cic.ciclo,
		cic.numerociclo || 'º ' || tip.nombre || ' ' || cic.anio
	      from 
	        cur_ciclo cic, cur_tipociclo tip 
	      where cic.tipociclo = tip.tipociclo and cic.tipociclo = _tipo;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spcicloxtipo(integer)
  OWNER TO postgres;

  
-- Function: spperiodoxtipo(integer)

-- DROP FUNCTION spperiodoxtipo(integer);

CREATE OR REPLACE FUNCTION spperiodoxtipo(
    IN _tipo integer,
    OUT codigo integer,
    OUT minutos integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query select distinct
		per.periodo,
		per.duracionminutos
	      from 
	        cur_periodo per, cur_tipoperiodo tip 
	      where per.tipoperiodo = tip.tipoperiodo and per.tipoperiodo = _tipo;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spperiodoxtipo(integer)
  OWNER TO postgres;
  
  
-- Function: spsalonesxedificio(integer)

-- DROP FUNCTION spsalonesxedificio(integer);

CREATE OR REPLACE FUNCTION spsalonesxedificio(
    IN _edificio integer,
    OUT codigo integer,
    OUT nombre text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query select distinct
		sal.salon,
		sal.nombre || ' - ' || sal.nivel || 'º nivel - ' || sal.capacidad || ' personas'
	      from 
	        cur_salon sal, cur_edificio edi 
	      where sal.edificio = edi.edificio and edi.edificio = _edificio;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spsalonesxedificio(integer)
  OWNER TO postgres;

