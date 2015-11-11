-- -----------------------------------------------------
-- Function: spInfoGeneralCatedratico()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoGeneralCatedratico(integer);
CREATE OR REPLACE FUNCTION spInfoGeneralCatedratico(IN _idUsuario integer, OUT registro int, 
						    OUT nombre text, OUT dircorta text,
						    OUT direccion text, OUT telefono text, 
						    OUT pais text, OUT zona int) RETURNS setof record AS
$BODY$
declare idMuni int;
declare idPais int;
begin
 select cat.paisorigen from cat_catedratico cat where cat.usuario = _idUsuario into idPais;
 select cat.municipio from cat_catedratico cat where cat.usuario = _idUsuario into idMuni;
 
 Return query 
	select cat.registropersonal as registro,
	       concat(cat.primernombre, ' ', 
		      cat.segundonombre, ' ', 
		      cat.primerapellido, ' ', 
		      cat.segundoapellido) as nombre,
	       cat.direccion as dircorta,
	       concat(cat.direccion, ' zona ', 
		      cat.zona, ', ', 
		      (select concat(muni.nombre, ', ', depto.nombre) from
			adm_municipio muni,
			adm_departamento depto
		      where muni.departamento = depto.departamento and
			muni.municipio = idMuni)) as direccion,
		cat.telefono as telefono,
		(select nac.nombre from adm_pais nac where nac.pais = idPais) as nacionalidad,
		cat.zona as zona
	from
		cat_catedratico cat
	where
		cat.usuario = _idUsuario;
end;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spUpdateInfoGeneralCatedratico()
-- -----------------------------------------------------
-- DROP FUNCTION spUpdateInfoGeneralCatedratico(int, text, int, int, text, int);
CREATE OR REPLACE FUNCTION spUpdateInfoGeneralCatedratico( _idUsuario int, 
							   _direccion text, 
							   _zona int,
							   _municipio int, 
							   _telefono text,
							   _nacionalidad int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE cat_catedratico SET direccion = %L, zona = %L,
					     municipio = %L, telefono = %s, 
					     paisorigen = %L WHERE usuario = %L', 
					     _direccion, _zona,
					     _municipio, _telefono,
					     _nacionalidad,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';


-- Function: spinformacioncatedratico(integer)

-- DROP FUNCTION spinformacioncatedratico(integer);

CREATE OR REPLACE FUNCTION spinformacioncatedratico(IN _centrounidadacademica integer,
					            OUT id integer, OUT registro integer, OUT primernombre text,
					            OUT segundonombre text, OUT primerapellido text, OUT segundoapellido text,
					            OUT tipodocente text, OUT usuario integer, OUT estado text)
  RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query
  Select 
    c.catedratico,
    c.registropersonal,
    c.primernombre, c.segundonombre, c.primerapellido, c.segundoapellido,
    t.descripcion as "tipodocente",
	c.usuario,
    case 
	when c.estado=0 then 'Validación Pendiente'
	when c.estado=1 then 'Activo'
	when c.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    CAT_catedratico c join CAT_tipocatedratico t on c.tipodocente = t.tipodocente 
  join adm_usuario u on u.usuario = c.usuario 
  join adm_centro_unidadacademica_usuario ucu on u.usuario = ucu.usuario where ucu.centro_unidadacademica = _centrounidadacademica;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spinformacioncatedratico(integer)
  OWNER TO postgres;
  

-- -----------------------------------------------------
-- Function: spConsultaEstudiantesAsignadosPorCatedratico()
-- -----------------------------------------------------
-- DROP FUNCTION spConsultaEstudiantesAsignadosPorCatedratico(integer,integer,integer,integer,integer);
CREATE OR REPLACE FUNCTION spConsultaEstudiantesAsignadosPorCatedratico(_Catedratico integer, _TipoPeriodo integer, _Ciclo integer, _TipoCiclo integer, _NumeroCiclo integer, OUT Asignacion integer, OUT Seccion integer, OUT NombreSeccion text, OUT Carnet integer, OUT PrimerNombre text, OUT SegundoNombre text, OUT PrimerApellido text, OUT SegundoApellido text, OUT TipoPeriodo integer, OUT NombreTipoPeriodo text, OUT Ciclo integer, OUT Anio integer, OUT TipoCiclo integer, OUT NumeroCiclo integer, OUT NombreTipoCiclo text) RETURNS setof record as 
$BODY$

  DECLARE
  sql text := 'SELECT distinct a.Asignacion, s.Seccion, s.Nombre as NombreSeccion, e.Carnet, e.PrimerNombre, e.SegundoNombre, e.PrimerApellido, e.SegundoApellido, tp.TipoPeriodo, tp.Nombre as NombreTipoPeriodo, c.Ciclo, c.Anio, tc.TipoCiclo, c.NumeroCiclo, tc.Nombre AS NombreTipoCiclo
		FROM EST_CUR_Asignacion a
		JOIN CUR_Seccion s ON s.Seccion = a.Seccion
		JOIN EST_Ciclo_Asignacion ca ON ca.Ciclo_Asignacion = a.Ciclo_Asignacion
		JOIN EST_Estudiante e ON e.Estudiante = ca.Estudiante
		JOIN ADM_Periodo p ON ca.Periodo = p.Periodo
		JOIN ADM_TipoPeriodo tp ON tp.TipoPeriodo = p.TipoPeriodo
		JOIN CUR_Ciclo c ON c.Ciclo = p.Ciclo
		JOIN CUR_TipoCiclo tc ON tc.TipoCiclo = c.TipoCiclo
		JOIN CUR_Trama t ON t.Seccion = a.Seccion
		JOIN CUR_Curso_Catedratico cc ON cc.Curso_Catedratico = t.Curso_Catedratico
		JOIN CAT_Catedratico cat ON cat.Catedratico = cc.Catedratico';
BEGIN
   sql := sql || ' WHERE cat.Catedratico = ' || $1;	  
   IF $2 != 0 THEN
      sql := sql || ' AND tp.TipoPeriodo = ' || $2;	  
   END IF;
   IF $3 != 0 THEN
      sql := sql || ' AND c.Ciclo = ' || $3;	  
   END IF;
   IF $4 != 0 THEN
      sql := sql || ' AND tc.TipoCiclo = ' || $4;	  
   END IF;
   IF $5 != 0 THEN
      sql := sql || ' AND c.NumeroCiclo = ' || $5;	  
   END IF;
   sql := sql || ' AND a.Estado = 1 ORDER BY e.Carnet;';	  
   
   RETURN QUERY EXECUTE sql;
   
END;
$BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spListaAlumnosAsignados()
-- -----------------------------------------------------
-- DROP FUNCTION spListaAlumnosAsignados(int);
CREATE OR REPLACE FUNCTION spListaAlumnosAsignados(IN _idTrama integer, IN _idCiclo integer,
					    OUT Asignacion integer,
					    OUT Seccion integer,
					    OUT NombreSeccion text,
					    OUT Carnet integer,
					    OUT Nombre text, OUT OportunidadActual integer, OUT TelefonoEmergencia text) RETURNS SETOF record AS
$BODY$
BEGIN
  return query
  SELECT distinct a.Asignacion, s.Seccion, s.Nombre as NombreSeccion, e.Carnet, concat(e.primernombre || ' ' || e.segundonombre || ' ' || e.primerapellido || ' ' || e.segundoapellido ) as nombre, a.OportunidadActual, e.TelefonoEmergencia
	FROM EST_CUR_Asignacion a
		JOIN CUR_Seccion s ON s.Seccion = a.Seccion
		JOIN EST_Ciclo_Asignacion ca ON ca.Ciclo_Asignacion = a.Ciclo_Asignacion
		JOIN EST_Estudiante e ON e.Estudiante = ca.Estudiante
		JOIN ADM_Periodo p ON ca.Periodo = p.Periodo
		JOIN ADM_TipoPeriodo tp ON tp.TipoPeriodo = p.TipoPeriodo
		JOIN CUR_Ciclo c ON c.Ciclo = p.Ciclo
		JOIN CUR_TipoCiclo tc ON tc.TipoCiclo = c.TipoCiclo
		JOIN CUR_Trama t ON t.Seccion = a.Seccion
		JOIN CUR_Curso_Catedratico cc ON cc.Curso_Catedratico = t.Curso_Catedratico
		JOIN CAT_Catedratico cat ON cat.Catedratico = cc.Catedratico
		JOIN CUR_Horario h ON h.Trama = t.Trama
		WHERE t.trama = _idTrama
		AND h.Ciclo = _idCiclo
		AND a.Estado = 1;

END;
$BODY$
LANGUAGE plpgsql;



Select 'Script de Catedraticos Instalado' as "Catedraticos";