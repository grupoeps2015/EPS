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