-- -----------------------------------------------------
-- Function: spAgregarUsuarios()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarusuarios(text, text, text, integer, text, integer, text, integer);

CREATE OR REPLACE FUNCTION spAgregarUsuarios(_nombre text, _correo text,
					     _clave text, _preguntasecreta integer,
					     _respuestasecreta text, _intentosautenticacion integer,
					     _foto text, _unidadacademica integer) RETURNS integer AS $BODY$
DECLARE idUsuario integer;
DECLARE fecha timestamp;
BEGIN
	SELECT current_timestamp into fecha;
	INSERT INTO adm_usuario (usuario, nombre, correo, clave, estado, preguntasecreta, respuestasecreta, 
		fechaultimaautenticacion, intentosautenticacion, foto, unidadacademica) 
	VALUES (DEFAULT,_nombre, _correo, _clave, 0, _preguntasecreta, _respuestasecreta, 
		fecha, _intentosautenticacion, _foto, _unidadacademica);

	SELECT usuario from adm_usuario where nombre=_nombre and clave=_clave and fechaultimaautenticacion = fecha into idUsuario;
	RETURN idUsuario;
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarEstudiante()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarestudiante(integer, text, integer, integer, text, text, text, text, boolean, text, integer, text, text, text, text, int);

CREATE OR REPLACE FUNCTION spAgregarEstudiante(_carnet integer, 
					       _direccion text,
					       _zona integer, 
					       _municipio integer,
					       _telefono text, 
					       _emergencia text,
					       _tiposangre text, 
					       _alergias text,
					       _segurovida boolean,
					       _centroemergencia text,
					       _paisorigen int,
					       _primernombre text,
					       _segundonombre text,
					       _primerapellido text,
					       _segundoapellido text,
					       _idUsuario int
					       ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO est_estudiante(
            estudiante, carnet, direccion, zona, municipio, telefono, estado, 
            telefonoemergencia, tiposangre, alergias, segurovida, centroemergencia, 
            usuario, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (DEFAULT, _carnet, _direccion, _zona, _municipio, _telefono, 0, 
            _emergencia, _tiposangre, _alergias, _segurovida, _centroemergencia, 
            _idUsuario, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarEmpleado()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarempleado(integer, text, integer, integer, text, integer, text, text, text, text, int); 
CREATE OR REPLACE FUNCTION spAgregarEmpleado(_registro integer, 
					     _direccion text,
					     _zona integer, 
					     _municipio integer,
					     _telefono text, 
					     _paisorigen int,
					     _primernombre text,
					     _segundonombre text,
					     _primerapellido text,
					     _segundoapellido text,
					     _idUsuario int
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_empleado(
            empleado, registropersonal, direccion, zona, municipio, telefono, 
            usuario, estado, paisorigen, primernombre, segundonombre, primerapellido, 
            segundoapellido)
	VALUES (DEFAULT, _registro, _direccion, _zona, _municipio, _telefono,
            _idUsuario, 0, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarCatedratico()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarcatedratico(integer, text, integer, integer, text, integer, integer, text, text, text, text, int);
CREATE OR REPLACE FUNCTION spAgregarCatedratico(_registro integer, 
						_direccion text,
						_zona integer, 
						_municipio integer,
						_telefono text, 
						_tipodocente int,
						_paisorigen int,
						_primernombre text,
						_segundonombre text,
						_primerapellido text,
						_segundoapellido text,
						_idUsuario int
						) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO cat_catedratico(
            catedratico, registropersonal, direccion, zona, municipio, telefono, 
            tipodocente, usuario, estado, paisorigen, primernombre, segundonombre, 
            primerapellido, segundoapellido)
	VALUES (DEFAULT, _registro, _direccion, _zona, _municipio, _telefono, _tipodocente,
            _idUsuario, 0, _paisorigen, _primernombre, _segundonombre, _primerapellido, 
            _segundoapellido);

END; $BODY$
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
-- Function: spAsignarRolUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spAsignarRolUsuario(integer);

CREATE OR REPLACE FUNCTION spAsignarRolUsuario(_rol integer, _usuario integer) RETURNS void AS $BODY$
BEGIN
	INSERT INTO adm_rol_usuario(rol, usuario)
	VALUES (_rol, _usuario);
END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spInformacionUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionUsuario();
CREATE OR REPLACE FUNCTION spInformacionUsuario(OUT Id int, OUT registro int, OUT nombre text, OUT Rol text, OUT Correo text, OUT Estado text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  Select 
    u.usuario,
    coalesce((select Carnet from Est_Estudiante where usuario=u.usuario),
	     (select registropersonal from Adm_Empleado where usuario=u.usuario),
	     (select registropersonal from Cat_Catedratico where usuario=u.usuario)),
    coalesce((select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Est_Estudiante where usuario=u.usuario),
	     (select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Cat_Catedratico where usuario=u.usuario),
	     (select primernombre || ' ' || segundonombre || ' ' || primerapellido || ' ' || segundoapellido from Adm_Empleado where usuario=u.usuario)),
    case
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 1 then 'Estudiante'
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 2 then 'Catedratico'
	when (select r.rol from adm_rol_usuario r where r.usuario = u.usuario) = 3 then 'Empleado'
	else 'No hay rol asociado'
    end as "Rol",
    u.correo,
    case 
	when u.estado=0 then 'Validacion Pendiente'
	when u.estado=1 then 'Activo'
	when u.estado=-1 then 'Desactivado'
    end as "Estado"
  from 
    ADM_Usuario u
  where 
    u.usuario > 1
  order by 
    u.usuario;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spActivarDesactivarUsuario()
-- -----------------------------------------------------
-- DROP FUNCTION spActivarDesactivarUsuario(int,int);
CREATE OR REPLACE FUNCTION spActivarDesactivarUsuario(_idUsuario int,_estadoNuevo int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_usuario SET estado = %L WHERE usuario = %L',_estadoNuevo,_idUsuario);
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spAgregarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spagregarparametro(text, text, text, integer, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarParametro(_nombre text, 
					      _valor text,
					      _descripcion text, 
					      _centro integer,
					      _unidadacademica integer, 
					      _carrera integer,
					      _extension integer,
					      _tipoparametro integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO adm_parametro(
            parametro, nombre,valor,descripcion,centro,unidadacademica,carrera,extension,tipoparametro,estado)
	VALUES (DEFAULT,_nombre,_valor,_descripcion,_centro,_unidadacademica,_carrera,_extension,_tipoparametro,0);

END; $BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spInformacionParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spInformacionParametro();
CREATE OR REPLACE FUNCTION spInformacionParametro(OUT Parametro int, OUT NombreParametro text, OUT ValorParametro text, OUT DescripcionParametro text, OUT NombreCentro text, OUT NombreUnidadAcademica text, OUT NombreCarrera text, OUT ExtensionParametro int, OUT NombreTipoParametro text, OUT EstadoParametro int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT p.parametro AS Parametro,p.nombre AS NombreParametro,p.valor AS ValorParametro,p.descripcion AS DescripcionParametro,c.nombre AS NombreCentro,ua.nombre AS NombreUnidadAcademica,car.nombre AS NombreCarrera,p.extension AS ExtensionParametro,tp.nombre AS NombreTipoParametro,p.estado AS EstadoParametro
	FROM ADM_Parametro p
	JOIN ADM_Centro c ON c.centro = p.centro
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = p.unidadacademica
	JOIN CUR_Carrera car ON car.carrera = p.carrera
	JOIN ADM_TipoParametro tp ON tp.tipoparametro = p.tipoparametro
	ORDER BY p.nombre;

END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spdatosparametro()
-- -----------------------------------------------------
-- DROP FUNCTION spdatosparametro(int);

CREATE OR REPLACE FUNCTION spDatosParametro(Parametro int, OUT NombreParametro text, OUT ValorParametro text, OUT DescripcionParametro text, OUT NombreCentro text, OUT NombreUnidadAcademica text, OUT NombreCarrera text, OUT ExtensionParametro int, OUT NombreTipoParametro text) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT p.nombre AS NombreParametro,p.valor AS ValorParametro,p.descripcion AS DescripcionParametro,c.nombre AS NombreCentro,ua.nombre AS NombreUnidadAcademica,car.nombre AS NombreCarrera,p.extension AS ExtensionParametro,tp.nombre AS NombreTipoParametro
	FROM ADM_Parametro p
	JOIN ADM_Centro c ON c.centro = p.centro
	JOIN ADM_UnidadAcademica ua ON ua.unidadacademica = p.unidadacademica
	JOIN CUR_Carrera car ON car.carrera = p.carrera
	JOIN ADM_TipoParametro tp ON tp.tipoparametro = p.tipoparametro
	WHERE p.parametro = $1;

END;
$BODY$
LANGUAGE 'plpgsql';


-- -----------------------------------------------------
-- Function: spModificarParametro()
-- -----------------------------------------------------
-- DROP FUNCTION spmodificarparametro(integer, text, text, text, integer, integer, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spModificarParametro(_parametro integer, 
						_nombre text, 
					        _valor text,
					        _descripcion text, 
					        _centro integer,
					        _unidadacademica integer, 
					        _carrera integer,
						_extension integer, 
						_estado integer,
						_tipoparametro integer
					     )RETURNS BOOLEAN LANGUAGE plpgsql SECURITY DEFINER AS $$

BEGIN
    UPDATE ADM_Parametro
       SET nombre = COALESCE(spModificarParametro._nombre, ADM_Parametro.nombre),
           valor = COALESCE(spModificarParametro._valor, ADM_Parametro.valor),
           descripcion = COALESCE(spModificarParametro._descripcion, ADM_Parametro.descripcion),
           centro = COALESCE(spModificarParametro._centro, ADM_Parametro.centro),
	   unidadacademica = COALESCE(spModificarParametro._unidadacademica, ADM_Parametro.unidadacademica),
	   carrera = COALESCE(spModificarParametro._carrera, ADM_Parametro.carrera),
	   extension = COALESCE(spModificarParametro._extension, ADM_Parametro.extension),
	   estado = COALESCE(spModificarParametro._estado, ADM_Parametro.estado),
	   tipoparametro = COALESCE(spModificarParametro._tipoparametro, ADM_Parametro.tipoparametro)
     WHERE ADM_Parametro.parametro = spModificarParametro._parametro;       
    RETURN FOUND;
END;
$$;


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
-- Function: spautenticarusuario(integer, text, text, text)
-- -----------------------------------------------------
-- DROP FUNCTION spautenticarusuario(integer, text, text, text);

CREATE OR REPLACE FUNCTION spautenticarusuario(
    IN _id integer,
    IN _clave text,
    IN _campo text,
    IN _tabla text,
    OUT usuario integer,
    OUT nombre text,
    OUT estado integer,
    OUT rol integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query EXECUTE format('SELECT adm_usuario.usuario, adm_usuario.nombre, adm_usuario.estado, adm_rol_usuario.rol FROM adm_usuario join %s on adm_usuario.usuario = %s.usuario and %s.%s = %s and adm_usuario.clave = ''%s'' join adm_rol_usuario on adm_rol_usuario.usuario = adm_usuario.usuario', _tabla, _tabla, _tabla, _campo, _id, _clave);

end;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spautenticarusuario(integer, text, text, text)
  OWNER TO postgres;
  
  
-- -----------------------------------------------------
-- Function: spdatosusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spdatosusuario(int);

CREATE OR REPLACE FUNCTION spdatosusuario(Id int, OUT nombre text, out correo text, OUT unidadacademica text, OUT preguntasecreta text, OUT respuestasecreta text ) 
RETURNS setof record as 
$BODY$
BEGIN
  RETURN query EXECUTE format('SELECT u.nombre, u.correo, ua.nombre, ps.descripcion, u.respuestasecreta FROM adm_usuario u JOIN adm_unidadacademica ua ON u.unidadacademica = ua.unidadacademica 
  JOIN adm_preguntasecreta ps ON u.preguntasecreta = ps.preguntasecreta WHERE usuario = %s',Id);
END;
$BODY$
LANGUAGE 'plpgsql';
  
-- -----------------------------------------------------
-- Function: spactualizarusuario()
-- -----------------------------------------------------
-- DROP FUNCTION spactualizarusuario(int,int);
CREATE OR REPLACE FUNCTION spactualizarusuario(_idUsuario int,_nombreNuevo text, _correoNuevo text,
					     _preguntasecretaNueva int,
					     _respuestasecretaNueva text,
					     _unidadacademicaNueva int) RETURNS void AS 
$BODY$
BEGIN
  EXECUTE format('UPDATE adm_usuario SET nombre = %s, correo = %s,
					     preguntasecreta = %s, respuestasecreta = %s, 
					     unidadacademica = %L WHERE usuario = %L',_nombreNuevo, _correoNuevo,
					     _preguntasecretaNueva,_respuestasecretaNueva,_unidadacademicaNueva,_idUsuario);
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
 Return query SELECT municipio, nombre FROM adm_municipio;
end;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spInfoGeneralEstudiante()
-- -----------------------------------------------------
-- DROP FUNCTION spInfoGeneralEstudiante(integer);
CREATE OR REPLACE FUNCTION spInfoGeneralEstudiante(IN _idUsuario integer, OUT carnet int, 
						   OUT nombre text, OUT direccion text, 
						   OUT telefono text, OUT pais text,
						   OUT emergencia text, OUT sangre text,
						   OUT alergias text, OUT seguro boolean,
						   OUT hospital text) RETURNS setof record AS
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
		est.centroemergencia as hospital
	from
		est_estudiante est
	where
		est.usuario = _idUsuario;
end;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spUpdateInfoGeneralEstudiante()
-- -----------------------------------------------------
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

-- -----------------------------------------------------
-- Function: spUpdateInfoEmergenciaEstudiante()
-- -----------------------------------------------------
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
