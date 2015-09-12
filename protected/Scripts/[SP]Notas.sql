-- -----------------------------------------------------
-- Function: spConsultaCentroUnidadacademica()
-- -----------------------------------------------------
-- DROP FUNCTION spGetNombreCentroUnidadacademica(int);
CREATE OR REPLACE FUNCTION spGetNombreCentroUnidadacademica(IN id int, OUT NombreUnidad text, OUT NombreCentro text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT ua.nombre AS nombreUnidad, c.nombre AS nombreCentro
  FROM ADM_Centro_UnidadAcademica cu
  JOIN ADM_Centro c ON c.Centro = cu.Centro
  JOIN ADM_UnidadAcademica ua ON ua.UnidadAcademica = cu.UnidadAcademica
  WHERE cu.centro_unidadacademica = id;
END;
$BODY$
LANGUAGE 'plpgsql';

select * from spGetNombreCentroUnidadacademica(1)