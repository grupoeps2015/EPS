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