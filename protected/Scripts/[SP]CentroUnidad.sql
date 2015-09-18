-- -----------------------------------------------------
-- Function: spInfoCentros()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoCentros();
CREATE OR REPLACE FUNCTION spInfoCentros(OUT centro int, OUT nombre text, OUT direccion text) RETURNS setof record as 
$BODY$
BEGIN 
  RETURN query
	select 
	  cen.centro, 
	  cen.nombre, 
	  (cen.direccion || ' zona' || cen.zona || ', ' || mun.nombre) as direccion
	from 
	  adm_centro cen
	join adm_municipio mun on mun.municipio = cen.municipio;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarCentros()
-- -----------------------------------------------------
-- DROP FUNCTION spAgregarCentros(text,text,int,int);
CREATE OR REPLACE FUNCTION spAgregarCentros(_nombre text, _direccion text, _municipio int, _zona int) RETURNS void as 
$BODY$
Declare id integer;
BEGIN
  select * from spObtenerSecuencia('centro','adm_centro') into id;
  INSERT INTO adm_centro(centro, nombre, direccion, municipio, zona)
    VALUES (id, _nombre, _direccion, _municipio, _zona);
END;
$BODY$
LANGUAGE 'plpgsql';

SELECT * from spAgregarCentros('Escuela de Formación de Profesores de Enseñanza Media','Avenida Petapa',4,12);
SELECT * from spAgregarCentros('Escuela de Formación de Profesores de Enseñanza Media','Avenida Petapa',4,12);
