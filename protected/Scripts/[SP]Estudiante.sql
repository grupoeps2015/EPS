----------------------------------------------------------------------------------------
-- Function: spInfoGeneralEstudiante()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spInfoGeneralEstudiante(integer);
CREATE OR REPLACE FUNCTION spInfoGeneralEstudiante(IN _idUsuario integer, OUT carnet int, 
						   OUT nombre text, OUT dircorta text,
						   OUT direccion text, OUT telefono text, 
						   OUT pais text, OUT emergencia text, 
						   OUT sangre text, OUT alergias text, 
						   OUT seguro boolean, OUT hospital text, 
						   OUT zona int) RETURNS setof record AS
$BODY$
declare idMuni int;
declare idPais int;
begin
 select est.paisorigen from est_estudiante est where est.usuario = _idUsuario into idPais;
 select est.municipio from est_estudiante est where est.usuario = _idUsuario into idMuni;
 
 Return query 
	select est.carnet as carnet,
	       concat(est.primernombre, ' ', 
		      est.segundonombre, ' ', 
		      est.primerapellido, ' ', 
		      est.segundoapellido) as nombre,
	       est.direccion as dircorta,
	       concat(est.direccion, ' zona ', 
		      est.zona, ', ', 
		      (select concat(muni.nombre, ', ', depto.nombre) from
			adm_municipio muni,
			adm_departamento depto
		      where muni.departamento = depto.departamento and
			muni.municipio = idMuni)) as direccion,
		est.telefono as telefono,
		(select nac.nombre from adm_pais nac where nac.pais=idPais) as nacionalidad,
		est.telefonoemergencia as NoEmergencia,
		est.tiposangre as sangre,
		est.alergias as alergias,
		est.segurovida as seguro,
		est.centroemergencia as hospital,
		est.zona as zona 
	from
		est_estudiante est
	where
		est.usuario = _idUsuario;
end;
$BODY$
LANGUAGE 'plpgsql';

----------------------------------------------------------------------------------------
-- Function: spUpdateInfoGeneralEstudiante()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spUpdateInfoGeneralEstudiante(int, text, int, int, text, int);
CREATE OR REPLACE FUNCTION spUpdateInfoGeneralEstudiante( _idUsuario int, 
							  _direccion text, 
							  _zona int,
							  _municipio int, 
							  _telefono text,
							  _nacionalidad int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE est_estudiante SET direccion = %L, zona = %L,
					    municipio = %L, telefono = %s, 
					    paisorigen = %L WHERE usuario = %L', 
					    _direccion, _zona,
					    _municipio, _telefono,
					    _nacionalidad,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';

----------------------------------------------------------------------------------------
-- Function: spUpdateInfoEmergenciaEstudiante()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spUpdateInfoEmergenciaEstudiante(int, text, text, boolean, text, text);
CREATE OR REPLACE FUNCTION spUpdateInfoEmergenciaEstudiante( _idUsuario int, 
							     _telefono text, 
							     _alergias text,
							     _seguro boolean, 
							     _centro text,
							     _sangre text) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE est_estudiante SET telefonoemergencia = %L, alergias = %L,
					    segurovida = %L, centroemergencia = %L, 
					    tiposangre = %L WHERE usuario = %L', 
					    _telefono, _alergias,
					    _seguro, _centro,
					    _sangre,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';

Select 'Script para Estudiantes Instalado' as "Gestion Estudiante";