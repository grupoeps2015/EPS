﻿-- Function: spagregarcarrera()

-- DROP FUNCTION spagregarcarrera(text, integer, integer);

CREATE OR REPLACE FUNCTION spagregarcarrera(
    _nombre text,
    _estado integer,
    _centrounidadacademica integer)
  RETURNS integer AS
$BODY$
DECLARE idCarrera integer;
BEGIN
	INSERT INTO cur_carrera (nombre, estado, centro_unidadacademica) 
	VALUES (_nombre, _estado, _centrounidadacademica) RETURNING Carrera into idCarrera;
	--parámetros de tipo carrera
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (200,'Número máximo de cursos traslapados','3','',_centrounidadacademica,idCarrera,3,1);
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (201,'Tiempo máximo de traslape entre 2 cursos','60','En minutos',_centrounidadacademica,idCarrera,3,1);
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (202,'Criterio de tiempo de traslape entre 2 cursos','S','S: Semanal, D: Diario',_centrounidadacademica,idCarrera,3,1);
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (203,'Cantidad máxima de asignaciones por curso','3','',_centrounidadacademica,idCarrera,3,1);
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (204,'Cupo máximo por curso','60','Estudiantes asignados',_centrounidadacademica,idCarrera,3,1);
	INSERT INTO adm_parametro (codigo,nombre,valor,descripcion,centro_unidadacademica,carrera,tipoparametro,estado) values (205,'Cantidad máxima de cursos a asignar por ciclo','8','Por estudiante',_centrounidadacademica,idCarrera,3,1);
	--parámetros de tipo carrera
	RETURN idCarrera;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarcarrera(text, integer, integer)
  OWNER TO postgres;


-- Function: spinformacioncarrera(integer)

-- DROP FUNCTION spinformacioncarrera(integer);

CREATE OR REPLACE FUNCTION spinformacioncarrera(
    IN _centrounidadacademica integer,
    OUT id integer,
    OUT nombre text,
    OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    c.carrera,
    c.nombre,
    case 
	when c.estado=0 then 'Validación Pendiente'
	when c.estado=1 then 'Activo'
	when c.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CUR_Carrera c where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncarrera(integer)
  OWNER TO postgres;

  
-- Function: spactivardesactivarcarrera(integer, integer)

-- DROP FUNCTION spactivardesactivarcarrera(integer, integer);

CREATE OR REPLACE FUNCTION spactivardesactivarcarrera(
    _idcarrera integer,
    _estadonuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE cur_carrera SET estado = %L WHERE carrera = %L',_estadoNuevo,_idCarrera);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivardesactivarcarrera(integer, integer)
  OWNER TO postgres;


  
-- Function: spdatoscarrera(integer)

-- DROP FUNCTION spdatoscarrera(integer);

CREATE OR REPLACE FUNCTION spdatoscarrera(
    IN id integer,
    OUT nombre text,
    OUT estado integer)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  SELECT c.nombre, c.estado FROM CUR_Carrera c where c.carrera = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatoscarrera(integer)
  OWNER TO postgres;


-- Function: spactualizarcarrera(text, integer)

-- DROP FUNCTION spactualizarcarrera(text, integer);

CREATE OR REPLACE FUNCTION spactualizarcarrera(
    _nombre text,
    _id integer)
  RETURNS integer AS
$BODY$
DECLARE idCarrera integer;
BEGIN
	UPDATE CUR_Carrera SET nombre = _nombre
	WHERE carrera = _id RETURNING Carrera into idCarrera;
	RETURN idCarrera;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarcarrera(text, integer)
  OWNER TO postgres;
  
--select * from spagregarpensum(1, 1, '12/12/2014', '5', 'lalalalala', 1);
--select * from spallpensum();
  
-- Function: spagregarpensum(integer, integer, text, text, text, integer)

-- drop function spagregarpensum(integer, integer, text, text, text, integer)

CREATE OR REPLACE FUNCTION spagregarpensum(
    _carrera integer,
    _tipo integer,
    _inicioVigencia text,
    _duracionAnios text,
    _descripcion text,
    _estado integer)
  RETURNS integer AS
$BODY$
DECLARE idPensum integer;
BEGIN
	INSERT INTO adm_pensum (carrera, tipo, inicioVigencia, duracionAnios, descripcion, estado) 
	VALUES (_carrera, _tipo, cast(_inicioVigencia as date), cast(_duracionAnios as integer), _descripcion, _estado) RETURNING Pensum into idPensum;
	RETURN idPensum;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spagregarpensum(integer, integer, text, text, text, integer)
  OWNER TO postgres;

  
-- Function: spallpensum(integer)

-- DROP FUNCTION spallpensum(integer);

CREATE OR REPLACE FUNCTION spallpensum(
	_centrounidadacademica integer,
	OUT id integer,
    OUT carrera text,
	OUT idcarrera integer,
    OUT tipo text,
	OUT inicioVigencia text,
	OUT duracionAnios text,
	OUT finVigencia text,
	OUT descripcion text,
	OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
    SELECT p.pensum, c.nombre, c.carrera,
	 case 
	   when p.tipo=1 then 'Cerrado'
           when p.tipo=2 then 'Abierto'
	end as "Tipo",
	cast(p.inicioVigencia as text), cast(p.duracionAnios as text), cast(p.finVigencia as text), p.descripcion,
	case 
	when p.estado=-1 then 'Inactivo'
	when p.estado=1 then 'Activo'
	end as "Estado" FROM adm_pensum p 
	join cur_carrera c ON p.carrera = c.carrera where c.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spallpensum(integer)
  OWNER TO postgres;
  

-- Function: spallpensumactivos()

-- DROP FUNCTION spallpensumactivos();
  
   CREATE OR REPLACE FUNCTION spallpensumactivos(
	OUT id integer,
    OUT carrera text,
	OUT idcarrera integer,
    OUT tipo text,
	OUT inicioVigencia text,
	OUT duracionAnios text,
	OUT descripcion text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
    SELECT p.pensum, c.nombre, c.carrera,
	 case 
	   when p.tipo=1 then 'Cerrado'
           when p.tipo=2 then 'Abierto'
	end as "Tipo",
	cast(p.inicioVigencia as text), cast(p.duracionAnios as text), p.descripcion FROM adm_pensum p 
	join cur_carrera c ON p.carrera = c.carrera where p.finVigencia is null AND p.estado =1;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spallpensumactivos()
  OWNER TO postgres;


-- Function: spfinalizarVigenciaPensum(integer, integer)

-- DROP FUNCTION spfinalizarVigenciaPensum(integer, integer);
  
  
  
  CREATE OR REPLACE FUNCTION spfinalizarVigenciaPensum(
    _idPensum integer, _estadoNuevo integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_pensum SET finVigencia = current_date, estado = %L WHERE pensum = %L',_estadoNuevo,_idPensum);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spfinalizarVigenciaPensum(integer, integer)
  OWNER TO postgres;
  
 


 -- Function: spactivarpensum(integer)

-- DROP FUNCTION spactivarpensum(integer);
  
  
  
  CREATE OR REPLACE FUNCTION spactivarpensum(
    _idPensum integer)
  RETURNS void AS
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_pensum SET finVigencia = NULL, estado = 1 WHERE pensum = %L',_idPensum);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactivarpensum(integer)
  OWNER TO postgres;
 
 
-- -----------------------------------------------------
-- Function: spInformacionCursosPorPensum()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionCursosPorPensum(integer);
CREATE OR REPLACE FUNCTION spInformacionCursosPorPensum(_pensum integer, OUT nombrecurso text, OUT curso integer, 
					          OUT carreraarea integer, OUT nombrearea text, 
					          OUT numerociclo integer, OUT tipociclo integer, 
					          OUT nombretipociclo text, OUT creditos integer, OUT prerrequisitos text, 
					          OUT estado int, OUT id int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
   SELECT  c.Nombre as nombrecurso, 
   cpa.Curso, cca.carreraarea, a.Nombre as nombrearea, 
   cpa.numerociclo, cpa.tipociclo, 
   tc.Nombre as nombretipociclo, cpa.creditos, cpa.prerrequisitos, cpa.estado, cpa.cursopensumarea as id
FROM CUR_Pensum_Area cpa
JOIN CUR_Curso c ON c.Curso = cpa.Curso
JOIN CUR_Carrera_Area cca ON cpa.carreraarea = cca.carreraarea
JOIN ADM_Area a ON a.Area = cca.area
JOIN CUR_TipoCiclo tc ON tc.TipoCiclo = cpa.TipoCiclo
JOIN ADM_Pensum p ON p.Pensum = cpa.Pensum
WHERE cpa.Pensum = _pensum
ORDER BY c.Nombre asc;

END;
$BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spAgregarCursoPensum()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarcursopensum(integer, integer , integer, integer, integer, text, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarCursoPensum(_curso integer, _pensum integer,
					      _numerociclo integer, _tipociclo integer, 
					      _creditos integer, _prerrequisitos text,
					      _estado integer, _carreraarea integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO cur_pensum_area(
            cursopensumarea,curso, pensum,numerociclo,tipociclo,creditos,prerrequisitos,estado,carreraarea)
	VALUES (DEFAULT,_curso,_pensum,_numerociclo,_tipociclo,_creditos,_prerrequisitos,0,_carreraarea);

END; $BODY$
LANGUAGE 'plpgsql';

 

------------------------------------------------------------------------------------------------------------------------------------
-- Function: select * from spactualizarpensum(1, 1, 1, '05/04/2015', '5', 'hhff')
------------------------------------------------------------------------------------------------------------------------------------
-- DROP FUNCTION spactualizarpensum(integer, integer, integer,text, text, text);
CREATE OR REPLACE FUNCTION spactualizarpensum(
    _idPensum integer,
    _carrera integer,
    _tipo integer,
    _inicioVigencia text,
    _duracionAnios text,
    _descripcion text)
  RETURNS integer AS
$BODY$
DECLARE idPensum integer;
BEGIN
	UPDATE ADM_pensum SET carrera= _carrera,
	tipo = _tipo, inicioVigencia = cast(_inicioVigencia as date), duracionAnios = cast(_duracionAnios as integer), descripcion = _descripcion
	WHERE pensum = _idPensum RETURNING pensum into idPensum;
	RETURN idPensum;
END; $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spactualizarpensum(integer, integer,integer,text, text, text)
  OWNER TO postgres;


-- Function: spdatospensum(integer)

-- DROP FUNCTION spdatospensum(integer);

CREATE OR REPLACE FUNCTION spdatospensum(
    IN id integer,
    OUT pensum Integer,
    OUT carrera text,
    OUT tipo text,
    OUT iniciovigencia text,
    OUT duracionanios integer,
    OUT finvigencia text,
    OUT descripcion text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  select p.pensum, c.nombre,  
	case 
	   when p.tipo=1 then 'Cerrado'
           when p.tipo=2 then 'Abierto'
	end as "Tipo", cast(p.iniciovigencia as text), p.duracionanios, cast(p.finvigencia as text), p.descripcion
from adm_pensum p join cur_carrera c on p.carrera = c.carrera
where p.estado = 1 and p.pensum = id;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spdatospensum(integer)
  OWNER TO postgres;

  
  -- Function: spmodificarcursopensum(integer, integer, integer, integer, integer, integer, text, integer)

-- DROP FUNCTION spmodificarcursopensum(integer, integer, integer, integer, integer, integer, text, integer);

CREATE OR REPLACE FUNCTION spmodificarcursopensum(
    _cursopensumarea integer,
    _curso integer,
    _carreraarea integer,
    _numerociclo integer,
    _tipociclo integer,
    _creditos integer,
    _prerrequisitos text,
    _estado integer)
  RETURNS boolean AS
$BODY$

BEGIN
    UPDATE CUR_Pensum_Area
       SET curso = COALESCE(spModificarCursoPensum._curso, CUR_Pensum_Area.curso),
           carreraarea = COALESCE(spModificarCursoPensum._carreraarea, CUR_Pensum_Area.carreraarea),
           numerociclo = COALESCE(spModificarCursoPensum._numerociclo, CUR_Pensum_Area.numerociclo),
           tipociclo = COALESCE(spModificarCursoPensum._tipociclo, CUR_Pensum_Area.tipociclo),
	   creditos = COALESCE(spModificarCursoPensum._creditos, CUR_Pensum_Area.creditos),
	   prerrequisitos = COALESCE(spModificarCursoPensum._prerrequisitos, CUR_Pensum_Area.prerrequisitos),
	   estado = COALESCE(spModificarCursoPensum._estado, CUR_Pensum_Area.estado)
     WHERE CUR_Pensum_Area.cursopensumarea = spModificarCursoPensum._cursopensumarea;       
    RETURN FOUND;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION spmodificarcursopensum(integer, integer, integer, integer, integer, integer, text, integer)
  OWNER TO postgres;


-- Function: splistadoareaporcarrera(integer)

-- DROP FUNCTION splistadoareaporcarrera(integer);

CREATE OR REPLACE FUNCTION splistadoareaporcarrera(
    IN _idcarrera integer,
    OUT carreraarea integer,
    OUT nombre text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
	SELECT cca.carreraarea, a.nombre 
	FROM CUR_Carrera_Area cca
	JOIN ADM_Area a ON cca.area = a.area
	WHERE cca.carrera = _idCarrera
	AND a.estado = 1
	AND cca.estado = 1;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION splistadoareaporcarrera(integer)
  OWNER TO postgres;
  
  
  
-- Function: spupdateprerrequisitos(integer, text)

-- DROP FUNCTION spupdateprerrequisitos(integer, text);

CREATE OR REPLACE FUNCTION spupdateprerrequisitos(
    _cursopensumarea integer,
    _prerrequisitos text)
  RETURNS void AS
$BODY$
BEGIN
   EXECUTE format('UPDATE cur_pensum_area SET prerrequisitos = %L WHERE cursopensumarea = %L',_prerrequisitos,_cursopensumarea);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION spupdateprerrequisitos(integer, text)
  OWNER TO postgres;

-- -----------------------------------------------------
-- Function: spgetcursocursopensumarea(integer);
-- -----------------------------------------------------
-- DROP FUNCTION spgetcursocursopensumarea(integer);
CREATE OR REPLACE FUNCTION spgetcursocursopensumarea(_cursopensumarea integer, OUT curso integer, OUT nombrecurso text, OUT codigo text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
   --select c.curso, c.nombre, c.codigo from cur_pensum_area cpa join cur_curso c on c.curso = cpa.curso WHERE cpa.estado = 1 and c.estado = 1 AND cpa.cursopensumarea = _cursopensumarea;
   select c.curso, c.nombre, c.codigo from cur_pensum_area cpa join cur_curso c on c.curso = cpa.curso WHERE c.estado = 1 AND cpa.cursopensumarea = _cursopensumarea;
END;
$BODY$
LANGUAGE 'plpgsql';



-- -----------------------------------------------------
-- Function: splistadotipociclo();
-- -----------------------------------------------------
-- DROP FUNCTION splistadotipociclo();
CREATE OR REPLACE FUNCTION splistadotipociclo(
    OUT tipociclo integer,
    OUT nombre text)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
	SELECT tc.tipociclo,tc.nombre
	FROM CUR_TipoCiclo tc
	WHERE Estado = 1;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION splistadotipociclo()
  OWNER TO postgres;

  
Select 'Script para Gestion de Pensum Instalado' as "Gestion Pensum";
