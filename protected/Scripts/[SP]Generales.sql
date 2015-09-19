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
-- Function: spfuncionmenupadre()
-- -----------------------------------------------------
-- DROP FUNCTION spfuncionmenupadre(int);
CREATE OR REPLACE FUNCTION spFuncionMenuPadre(Rol int, OUT FuncionMenu int, 
					          OUT Url text, OUT Nombre text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
		SELECT fm.FuncionMenu AS FuncionMenu, fm.Url AS Url, fm.Nombre AS Nombre
		FROM ADM_FuncionMenu fm
		JOIN ADM_Funcion f ON f.Funcion = fm.Funcion
		JOIN ADM_Rol_Funcion rf ON rf.Funcion = fm.Funcion
		WHERE fm.FuncionPadre IS NULL
		AND rf.Rol = $1
		ORDER BY fm.Nombre;		
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spfuncionmenuhijo()
-- -----------------------------------------------------
-- DROP FUNCTION spfuncionmenuhijo(int,int);
CREATE OR REPLACE FUNCTION spFuncionMenuHijo(FuncionPadre int, Rol int, OUT FuncionMenu int, 
					          OUT Url text, OUT Nombre text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
		SELECT fm.FuncionMenu, fm.Url, fm.Nombre
		FROM ADM_FuncionMenu fm
		JOIN ADM_Funcion f ON f.Funcion = fm.Funcion
		JOIN ADM_Rol_Funcion rf ON rf.Funcion = fm.Funcion
		WHERE fm.FuncionPadre = $1
		AND rf.Rol = $2
		ORDER BY fm.Nombre;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spValidarRolFuncion()
-- -----------------------------------------------------
-- DROP FUNCTION spValidarRolFuncion(integer,integer);
CREATE OR REPLACE FUNCTION spValidarRolFuncion(Rol integer, Funcion integer)
  RETURNS integer AS
$BODY$
BEGIN

RETURN (SELECT EXISTS (SELECT rf.funcion FROM ADM_Rol_Funcion rf WHERE rf.Rol = $1 AND rf.Funcion = $2)::int);

END;
$BODY$
LANGUAGE 'plpgsql';
  
  
-- -----------------------------------------------------
-- Function: spValidarPrimerIngresoUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spValidarPrimerIngresoUsuario(integer);
CREATE OR REPLACE FUNCTION spValidarPrimerIngresoUsuario(Usuario integer)
  RETURNS integer AS
$BODY$
BEGIN

RETURN (SELECT EXISTS (SELECT u.usuario FROM ADM_Usuario u WHERE u.Usuario = $1 AND u.estado = 0)::int);

END;
$BODY$
LANGUAGE 'plpgsql';


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
  
  
-- Function: spanioxtipociclo(integer)

-- DROP FUNCTION spanioxtipociclo(integer);

CREATE OR REPLACE FUNCTION spanioxtipociclo(
    IN _tipo integer)
  RETURNS INTEGER AS
$BODY$
begin
 Return (select distinct
		cic.anio
	      from 
	        cur_ciclo cic
	      where cic.tipociclo = _tipo order by cic.anio asc) ::INTEGER;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spanioxtipociclo(integer)
  OWNER TO postgres;
  
  
  
-- Function: spcicloxtipo(integer, integer)

-- DROP FUNCTION spcicloxtipo(integer, integer);

CREATE OR REPLACE FUNCTION spcicloxtipo(
    IN _tipo integer,
	IN _anio integer,
    OUT codigo integer,
    OUT nombre text,
	OUT numerociclo integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query select distinct
		cic.ciclo,
		to_char(cic.numerociclo, 'FMRN') || ' ' || tip.nombre ,
		cic.numerociclo
	      from 
	        cur_ciclo cic, cur_tipociclo tip 
	      where cic.tipociclo = tip.tipociclo and cic.tipociclo = _tipo and cic.anio = _anio order by cic.numerociclo asc;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spcicloxtipo(integer, integer)
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

  

-- -----------------------------------------------------
-- Function: spestudiantexusuario(integer)
-- -----------------------------------------------------
-- DROP FUNCTION spestudiantexusuario(integer);

CREATE OR REPLACE FUNCTION spestudiantexusuario(IN _usuario int) RETURNS INTEGER AS
$BODY$
DECLARE ESTUDIANTE INTEGER;
begin
 select e.estudiante INTO ESTUDIANTE from est_estudiante e join adm_usuario u on u.usuario = e.usuario where e.usuario = _usuario;
 RETURN ESTUDIANTE;
end;
$BODY$
LANGUAGE 'plpgsql';



-- -----------------------------------------------------
-- Function: spcarrerasxestudiante(integer)
-- -----------------------------------------------------
-- DROP FUNCTION spcarrerasxestudiante(integer);

CREATE OR REPLACE FUNCTION spcarrerasxestudiante(IN _estudiante int, OUT codigo int, OUT nombre text) RETURNS setof record AS
$BODY$
begin
 Return query select c.carrera, c.nombre from cur_carrera c join est_estudiante_carrera ec on ec.carrera = c.carrera where ec.estudiante =_estudiante and ec.estado = 1;
end;
$BODY$
LANGUAGE 'plpgsql';