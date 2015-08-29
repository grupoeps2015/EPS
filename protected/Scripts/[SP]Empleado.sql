﻿-- -----------------------------------------------------
-- Function: spInfoGeneralEmpleado()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoGeneralEmpleado(integer);
CREATE OR REPLACE FUNCTION spInfoGeneralEmpleado(IN _idUsuario integer, OUT registro int, 
						 OUT nombre text, OUT dircorta text,
						 OUT direccion text, OUT telefono text, 
						 OUT pais text, OUT zona int) RETURNS setof record AS
$BODY$
declare idMuni int;
declare idPais int;
begin
 select emp.paisorigen from adm_empleado emp where emp.usuario = _idUsuario into idPais;
 select emp.municipio from adm_empleado emp where emp.usuario = _idUsuario into idMuni;
 
 Return query 
	select emp.registropersonal as registro,
	       concat(emp.primernombre, ' ', 
		      emp.segundonombre, ' ', 
		      emp.primerapellido, ' ', 
		      emp.segundoapellido) as nombre,
	       emp.direccion as dircorta,
	       concat(emp.direccion, ' zona ', 
		      emp.zona, ', ', 
		      (select concat(muni.nombre, ', ', depto.nombre) from
			adm_municipio muni,
			adm_departamento depto
		      where muni.departamento = depto.departamento and
			muni.municipio = idMuni)) as direccion,
		emp.telefono as telefono,
		(select nac.nombre from adm_pais nac where nac.pais = idPais) as nacionalidad,
		emp.zona as zona
	from
		adm_empleado emp
	where
		emp.usuario = _idUsuario;
end;
$BODY$
LANGUAGE 'plpgsql';
