-- Database: "EPS"

-- DROP DATABASE "EPS";

--CREATE DATABASE "EPS"
--  WITH OWNER = postgres
--       ENCODING = 'UTF8'
--       TABLESPACE = pg_default
--       LC_COLLATE = 'Spanish_Guatemala.1252'
--       LC_CTYPE = 'Spanish_Guatemala.1252'
--       CONNECTION LIMIT = -1;

-- UPDATE pg_database SET encoding=6 WHERE datname='EPS'
-- ALTER DATABASE "EPS" SET datestyle TO "ISO, DMY";


-- -----------------------------------------------------
-- Table CAT_TipoCatedratico
-- -----------------------------------------------------
CREATE TABLE CAT_TipoCatedratico (
  TipoDocente SERIAL NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoDocente));


-- -----------------------------------------------------
-- Table ADM_Departamento
-- -----------------------------------------------------
CREATE TABLE ADM_Departamento (
  Departamento SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  PRIMARY KEY (Departamento));


-- -----------------------------------------------------
-- Table ADM_Municipio
-- -----------------------------------------------------
CREATE TABLE ADM_Municipio (
  Municipio SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Departamento INTEGER NOT NULL,
  PRIMARY KEY (Municipio),
  CONSTRAINT fk_ADM_Municipio_ADM_Departamento1
    FOREIGN KEY (Departamento)
    REFERENCES ADM_Departamento (Departamento));


-- -----------------------------------------------------
-- Table ADM_TipoUnidadAcademica
-- -----------------------------------------------------
CREATE TABLE ADM_TipoUnidadAcademica (
  TipoUnidadAcademica SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (TipoUnidadAcademica));


-- -----------------------------------------------------
-- Table ADM_UnidadAcademica
-- -----------------------------------------------------
CREATE TABLE ADM_UnidadAcademica (
  UnidadAcademica SERIAL NOT NULL,
  UnidadAcademicaSuperior INTEGER NULL,
  Nombre TEXT NOT NULL,
  Tipo INTEGER NOT NULL,
  PRIMARY KEY (UnidadAcademica),
  CONSTRAINT TipoUnidadAcademica
    FOREIGN KEY (Tipo)
    REFERENCES ADM_TipoUnidadAcademica (TipoUnidadAcademica),
  CONSTRAINT UnidadAcademicaSuperior
    FOREIGN KEY (UnidadAcademicaSuperior)
    REFERENCES ADM_UnidadAcademica (UnidadAcademica));

-- -----------------------------------------------------
-- Table ADM_Centro
-- -----------------------------------------------------
CREATE TABLE ADM_Centro (
  Centro SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Direccion TEXT NOT NULL,
  Municipio INTEGER NOT NULL,
  Zona INTEGER NULL,
  PRIMARY KEY (Centro),
  CONSTRAINT fk_ADM_Centro_ADM_Municipio1
    FOREIGN KEY (Municipio)
    REFERENCES ADM_Municipio (Municipio));


-- -----------------------------------------------------
-- Table ADM_Centro_UnidadAcademica
-- -----------------------------------------------------
CREATE TABLE ADM_Centro_UnidadAcademica (
  Centro_UnidadAcademica INTEGER NOT NULL,
  Centro INTEGER NOT NULL,
  UnidadAcademica INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  Extensiones TEXT NULL,
  PRIMARY KEY (Centro_UnidadAcademica),
  CONSTRAINT Centro
    FOREIGN KEY (UnidadAcademica)
    REFERENCES ADM_UnidadAcademica (UnidadAcademica),
  CONSTRAINT UnidadAcademica
    FOREIGN KEY (Centro)
    REFERENCES ADM_Centro (Centro),
  CONSTRAINT u_Centro 
    UNIQUE (Centro),
  CONSTRAINT u_UnidadAcademica
    UNIQUE(UnidadAcademica));

CREATE UNIQUE INDEX u_Centro_UnidadAcademica ON ADM_Centro_UnidadAcademica (Centro, UnidadAcademica);
ALTER TABLE ADM_Centro_UnidadAcademica DROP CONSTRAINT u_Centro;
ALTER TABLE ADM_Centro_UnidadAcademica DROP CONSTRAINT u_UnidadAcademica;
--ALTER TABLE ADM_Centro_UnidadAcademica ADD PRIMARY KEY (Centro,UnidadAcademica);

-- -----------------------------------------------------
-- Table ADM_PreguntaSecreta
-- -----------------------------------------------------
CREATE TABLE  ADM_PreguntaSecreta (
  PreguntaSecreta SERIAL NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (PreguntaSecreta)
 );
 
-- -----------------------------------------------------
-- Table ADM_Usuario
-- -----------------------------------------------------
CREATE TABLE ADM_Usuario (
  Usuario SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Correo TEXT NOT NULL,
  Clave TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PreguntaSecreta INTEGER NOT NULL,
  RespuestaSecreta TEXT NOT NULL,
  FechaUltimaAutenticacion TIMESTAMP NOT NULL,
  IntentosAutenticacion INTEGER NOT NULL,
  Foto TEXT NOT NULL,
  PRIMARY KEY (Usuario),
  CONSTRAINT fk_ADM_Usuario_ADM_PreguntaSecreta1
    FOREIGN KEY (PreguntaSecreta)
    REFERENCES ADM_PreguntaSecreta (PreguntaSecreta)	
);
-- -----------------------------------------------------
-- Table ADM_Rol
-- -----------------------------------------------------
CREATE TABLE ADM_Rol (
  Rol SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Rol));


-- -----------------------------------------------------
-- Table ADM_Modulo
-- -----------------------------------------------------
CREATE TABLE ADM_Modulo (
  Modulo SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Modulo));


-- -----------------------------------------------------
-- Table ADM_Funcion
-- -----------------------------------------------------
CREATE TABLE ADM_Funcion (
  Funcion SERIAL NOT NULL,
  Modulo INTEGER NOT NULL,
  FuncionPadre INTEGER NULL,
  Nombre TEXT NOT NULL,
  Orden INTEGER NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (Funcion),
  CONSTRAINT FK_Funcion
    FOREIGN KEY (Funcion)
    REFERENCES ADM_Funcion (Funcion),
  CONSTRAINT FK_Modulo
    FOREIGN KEY (Modulo)
    REFERENCES ADM_Modulo (Modulo));


-- -----------------------------------------------------
-- Table ADM_FuncionMenu
-- -----------------------------------------------------
CREATE TABLE ADM_FuncionMenu (
  FuncionMenu SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Tipo INTEGER NOT NULL,
  URL TEXT NULL,
  FuncionPadre INTEGER NULL,
  Funcion INTEGER NULL,
  Orden INTEGER NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (FuncionMenu),
  CONSTRAINT FK_FuncionMenu
    FOREIGN KEY (FuncionMenu)
    REFERENCES ADM_FuncionMenu (FuncionMenu),
  CONSTRAINT FK_Funcion
    FOREIGN KEY (Funcion)
    REFERENCES ADM_Funcion (Funcion));


-- -----------------------------------------------------
-- Table ADM_Rol_Funcion
-- -----------------------------------------------------
CREATE TABLE ADM_Rol_Funcion (
  Rol INTEGER NOT NULL,
  Funcion INTEGER NOT NULL,
  CONSTRAINT FK_Rol
    FOREIGN KEY (Rol)
    REFERENCES ADM_Rol (Rol),
  CONSTRAINT FK_Funcion
    FOREIGN KEY (Funcion)
    REFERENCES ADM_Funcion (Funcion));


-- -----------------------------------------------------
-- Table ADM_Rol_Usuario
-- -----------------------------------------------------
CREATE TABLE ADM_Rol_Usuario (
  Rol INTEGER NOT NULL,
  Usuario INTEGER NOT NULL,
  CONSTRAINT FK_Usuario
    FOREIGN KEY (Usuario)
    REFERENCES ADM_Usuario (Usuario),
  CONSTRAINT FK_Rol
    FOREIGN KEY (Rol)
    REFERENCES ADM_Rol (Rol));

-- -----------------------------------------------------
-- Table ADM_Pais
-- -----------------------------------------------------
CREATE TABLE ADM_Pais (
  Pais SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  PRIMARY KEY (Pais));


-- -----------------------------------------------------
-- Table CAT_Catedratico
-- -----------------------------------------------------
CREATE TABLE CAT_Catedratico (
  Catedratico SERIAL NOT NULL,
  RegistroPersonal INTEGER UNIQUE NOT NULL,
  PrimerNombre TEXT NOT NULL,
  Direccion TEXT NOT NULL,
  Zona INTEGER NOT NULL,
  Municipio INTEGER NOT NULL,
  Telefono TEXT NULL,
  TipoDocente INTEGER NOT NULL,
  Usuario INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PaisOrigen INTEGER NOT NULL,
  SegundoNombre TEXT NOT NULL,
  PrimerApellido TEXT NOT NULL,
  SegundoApellido TEXT NOT NULL,
  PRIMARY KEY (Catedratico),
  CONSTRAINT TipoDocente
    FOREIGN KEY (TipoDocente)
    REFERENCES CAT_TipoCatedratico (TipoDocente),
  CONSTRAINT Usuario
    FOREIGN KEY (Usuario)
    REFERENCES ADM_Usuario (Usuario),
  CONSTRAINT fk_DOC_Docente_ADM_Municipio1
    FOREIGN KEY (Municipio)
    REFERENCES ADM_Municipio (Municipio),
  CONSTRAINT fk_CAT_Catedratico_ADM_Pais1
    FOREIGN KEY (PaisOrigen)
    REFERENCES ADM_Pais (Pais));


-- -----------------------------------------------------
-- Table CUR_Edificio
-- -----------------------------------------------------
CREATE TABLE CUR_Edificio (
  Edificio SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Edificio));


-- -----------------------------------------------------
-- Table CUR_Salon
-- -----------------------------------------------------
CREATE TABLE CUR_Salon (
  Salon SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Edificio INTEGER NOT NULL,
  Nivel INTEGER NOT NULL,
  Capacidad INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Salon),
  CONSTRAINT Edificio
    FOREIGN KEY (Edificio)
    REFERENCES CUR_Edificio (Edificio));


-- -----------------------------------------------------
-- Table CUR_Tipo
-- -----------------------------------------------------
CREATE TABLE CUR_Tipo (
  TipoCurso SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (TipoCurso));


-- -----------------------------------------------------
-- Table CUR_Curso
-- -----------------------------------------------------
CREATE TABLE CUR_Curso (
  Curso SERIAL NOT NULL,
  Codigo TEXT NOT NULL,
  Nombre TEXT NOT NULL,
  Traslape BOOLEAN NOT NULL,
  Estado INTEGER NOT NULL,
  TipoCurso INTEGER NOT NULL,
  Centro_UnidadAcademica INTEGER NOT NULL,
  PRIMARY KEY (Curso),
  CONSTRAINT fk_CUR_Curso_CUR_Tipo1
    FOREIGN KEY (TipoCurso)
    REFERENCES CUR_Tipo (TipoCurso),
  CONSTRAINT fk_CUR_Curso_ADM_Centro_UnidadAcademica1
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica));


-- -----------------------------------------------------
-- Table CUR_Jornada
-- -----------------------------------------------------
CREATE TABLE CUR_Jornada (
  Jornada SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Jornada));


-- -----------------------------------------------------
-- Table CUR_Dia
-- -----------------------------------------------------
CREATE TABLE CUR_Dia (
  Codigo SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  PRIMARY KEY (Codigo));


-- -----------------------------------------------------
-- Table CUR_TipoPeriodo
-- -----------------------------------------------------
CREATE TABLE CUR_TipoPeriodo (
  TipoPeriodo SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoPeriodo));


-- -----------------------------------------------------
-- Table CUR_Periodo
-- -----------------------------------------------------
CREATE TABLE CUR_Periodo (
  Periodo SERIAL NOT NULL,
  DuracionMinutos INTEGER NOT NULL,
  TipoPeriodo INTEGER NOT NULL,
  PRIMARY KEY (Periodo),
  CONSTRAINT fk_CUR_Periodo_CUR_TipoPeriodo1
    FOREIGN KEY (TipoPeriodo)
    REFERENCES CUR_TipoPeriodo (TipoPeriodo));

-- -----------------------------------------------------
-- Table CUR_Carrera
-- -----------------------------------------------------
CREATE TABLE CUR_Carrera (
  Carrera SERIAL NOT NULL,
  Codigo INTEGER NOT NULL,
  Nombre TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  Centro_UnidadAcademica INTEGER NOT NULL,
  Extension TEXT NOT NULL,
  PRIMARY KEY (Carrera),
  CONSTRAINT Centro
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica));


-- -----------------------------------------------------
-- Table ADM_Pensum
-- -----------------------------------------------------
CREATE TABLE ADM_Pensum (
  Pensum SERIAL NOT NULL,
  Carrera INTEGER NOT NULL,
  Tipo INTEGER NOT NULL,
  InicioVigencia DATE NOT NULL,
  DuracionAnios INTEGER NOT NULL,
  FinVigencia DATE NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Pensum),
  CONSTRAINT fk_ADM_Pensum_CUR_Carrera1
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera));


-- -----------------------------------------------------
-- Table ADM_Area
-- -----------------------------------------------------
CREATE TABLE ADM_Area (
  Area SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Area));


-- -----------------------------------------------------
-- Table CUR_TipoCiclo
-- -----------------------------------------------------
CREATE TABLE CUR_TipoCiclo (
  TipoCiclo SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  DuracionMeses INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoCiclo));

-- -----------------------------------------------------
-- Table CUR_Carrera_Area
-- -----------------------------------------------------
CREATE TABLE CUR_Carrera_Area (
  CarreraArea SERIAL NOT NULL,
  Carrera INTEGER NOT NULL,
  Area INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (CarreraArea),
  CONSTRAINT fk_CUR_Carrera_ADM_Area1
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera),
  CONSTRAINT fk_ADM_Area_Cur_Carrera1
    FOREIGN KEY (Area)
    REFERENCES ADM_Area (Area));


-- -----------------------------------------------------
-- Table CUR_Pensum_Area
-- -----------------------------------------------------
CREATE TABLE CUR_Pensum_Area (
  CursoPensumArea SERIAL NOT NULL,
  Curso INTEGER NOT NULL,
  Pensum INTEGER NOT NULL,
  CarreraArea INTEGER NOT NULL,
  NumeroCiclo INTEGER NOT NULL,
  TipoCiclo INTEGER NOT NULL,
  Creditos INTEGER NULL,
  Prerrequisitos TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (CursoPensumArea),
  CONSTRAINT fk_CUR_Pensum_CUR_Curso1
    FOREIGN KEY (Curso)
    REFERENCES CUR_Curso (Curso),
  CONSTRAINT fk_CUR_Pensum_ADM_Pensum1
    FOREIGN KEY (Pensum)
    REFERENCES ADM_Pensum (Pensum),
  CONSTRAINT fk_CUR_Pensum_Area_CUR_Carrera_Area1
    FOREIGN KEY (CarreraArea)
    REFERENCES CUR_Carrera_Area (CarreraArea),
  CONSTRAINT fk_CUR_Pensum_Area_CUR_TipoCiclo1
    FOREIGN KEY (TipoCiclo)
    REFERENCES CUR_TipoCiclo (TipoCiclo));

CREATE UNIQUE INDEX u_Curso_Pensum_CarreraArea ON CUR_Pensum_Area (Curso, Pensum, CarreraArea);



-- -----------------------------------------------------
-- Table CUR_TipoSeccion
-- -----------------------------------------------------
CREATE TABLE CUR_TipoSeccion (
  TipoSeccion SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (TipoSeccion));


-- -----------------------------------------------------
-- Table CUR_Seccion
-- -----------------------------------------------------
CREATE TABLE CUR_Seccion (
  Seccion SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  TipoSeccion INTEGER NOT NULL,
  Curso INTEGER NOT NULL,
  PRIMARY KEY (Seccion),
  CONSTRAINT Curso
    FOREIGN KEY (Curso)
    REFERENCES CUR_Curso (Curso),
  CONSTRAINT fk_CUR_Seccion_CUR_TipoSeccion1
    FOREIGN KEY (TipoSeccion)
    REFERENCES CUR_TipoSeccion (TipoSeccion));


-- -----------------------------------------------------
-- Table CUR_Curso_Catedratico
-- -----------------------------------------------------
CREATE TABLE CUR_Curso_Catedratico (
  Curso_Catedratico SERIAL NOT NULL,
  Catedratico INTEGER NOT NULL,
  Curso INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Curso_Catedratico),
  CONSTRAINT fk_CUR_Curso_Docente_DOC_Docente1
    FOREIGN KEY (Catedratico)
    REFERENCES CAT_Catedratico (Catedratico),
  CONSTRAINT Curso
    FOREIGN KEY (Curso)
    REFERENCES CUR_Curso (Curso));


-- -----------------------------------------------------
-- Table CUR_Trama
-- -----------------------------------------------------
CREATE TABLE CUR_Trama (
  Trama SERIAL NOT NULL,
  Curso_Catedratico INTEGER NOT NULL,
  Dia INTEGER NOT NULL,
  Periodo INTEGER NOT NULL,
  Inicio TIME NOT NULL,
  Fin TIME NOT NULL,
  Seccion INTEGER NOT NULL,
  PRIMARY KEY (Trama),
  CONSTRAINT fk_CUR_Trama_CUR_Dia1
    FOREIGN KEY (Dia)
    REFERENCES CUR_Dia (Codigo),
  CONSTRAINT fk_CUR_Trama_CUR_Periodo1
    FOREIGN KEY (Periodo)
    REFERENCES CUR_Periodo (Periodo),
  CONSTRAINT fk_CUR_Trama_CUR_Seccion1
    FOREIGN KEY (Seccion)
    REFERENCES CUR_Seccion (Seccion),
  CONSTRAINT fk_CUR_Trama_CUR_Curso_Catedratico1
    FOREIGN KEY (Curso_Catedratico)
    REFERENCES CUR_Curso_Catedratico (Curso_Catedratico));


-- -----------------------------------------------------
-- Table CUR_Ciclo
-- -----------------------------------------------------
CREATE TABLE CUR_Ciclo (
  Ciclo SERIAL NOT NULL,
  NumeroCiclo INTEGER NOT NULL,
  Anio INTEGER NOT NULL,
  TipoCiclo INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Ciclo),
  CONSTRAINT TipoCiclo
    FOREIGN KEY (TipoCiclo)
    REFERENCES CUR_TipoCiclo (TipoCiclo));


-- -----------------------------------------------------
-- Table CUR_Horario
-- -----------------------------------------------------
CREATE TABLE CUR_Horario (
  Horario SERIAL NOT NULL,
  Jornada INTEGER NOT NULL,
  Trama INTEGER NOT NULL,
  Ciclo INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Horario),
  CONSTRAINT fk_CUR_Horario_CUR_Jornada1
    FOREIGN KEY (Jornada)
    REFERENCES CUR_Jornada (Jornada),
  CONSTRAINT fk_CUR_Horario_CUR_Trama1
    FOREIGN KEY (Trama)
    REFERENCES CUR_Trama (Trama),
  CONSTRAINT fk_CUR_Horario_CUR_Ciclo1
    FOREIGN KEY (Ciclo)
    REFERENCES CUR_Ciclo (Ciclo));


-- -----------------------------------------------------
-- Table ADM_Empleado
-- -----------------------------------------------------
CREATE TABLE ADM_Empleado (
  Empleado SERIAL NOT NULL,
  RegistroPersonal INTEGER UNIQUE NOT NULL,
  PrimerNombre TEXT NOT NULL,
  SegundoNombre TEXT NOT NULL,
  PrimerApellido TEXT NOT NULL,
  SegundoApellido TEXT NOT NULL,
  Direccion TEXT NOT NULL,
  Zona INTEGER NULL,
  Telefono TEXT NOT NULL,
  Estado TEXT NOT NULL,
  Usuario INTEGER NOT NULL,
  Municipio INTEGER NOT NULL,
  PaisOrigen INTEGER NOT NULL,
  PRIMARY KEY (Empleado),
  CONSTRAINT Usuario
    FOREIGN KEY (Usuario)
    REFERENCES ADM_Usuario (Usuario),
  CONSTRAINT fk_ADM_Empleado_ADM_Municipio1
    FOREIGN KEY (Municipio)
    REFERENCES ADM_Municipio (Municipio),
  CONSTRAINT PaisOrigen
    FOREIGN KEY (PaisOrigen)
    REFERENCES ADM_Pais (Pais));


-- -----------------------------------------------------
-- Table EST_Estudiante
-- -----------------------------------------------------
CREATE TABLE EST_Estudiante (
  Estudiante SERIAL NOT NULL,
  Carnet INTEGER UNIQUE NOT NULL,
  PrimerNombre TEXT NOT NULL,
  SegundoNombre TEXT NOT NULL,
  PrimerApellido TEXT NOT NULL,
  SegundoApellido TEXT NOT NULL,
  Direccion TEXT NOT NULL,
  Zona INTEGER NULL,
  Municipio INTEGER NOT NULL,
  Telefono TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  TelefonoEmergencia TEXT NOT NULL,
  TipoSangre TEXT NOT NULL,
  Alergias TEXT NULL,
  SeguroVida BOOLEAN NOT NULL,
  CentroEmergencia TEXT NOT NULL,
  Usuario INTEGER NOT NULL,
  PaisOrigen INTEGER NOT NULL,
  PRIMARY KEY (Estudiante),
  CONSTRAINT Usuario
    FOREIGN KEY (Usuario)
    REFERENCES ADM_Usuario (Usuario),
  CONSTRAINT fk_EST_Estudiante_ADM_Municipio1
    FOREIGN KEY (Municipio)
    REFERENCES ADM_Municipio (Municipio),
  CONSTRAINT PaisOrigen
    FOREIGN KEY (PaisOrigen)
    REFERENCES ADM_Pais (Pais));


-- -----------------------------------------------------
-- Table ADM_TipoAsignacion
-- -----------------------------------------------------
CREATE TABLE ADM_TipoAsignacion (
  TipoAsignacion SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (TipoAsignacion));

  
  -- -----------------------------------------------------
-- Table ADM_TipoPeriodo
-- -----------------------------------------------------
CREATE TABLE ADM_TipoPeriodo (
  TipoPeriodo SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoPeriodo));


-- -----------------------------------------------------
-- Table ADM_Periodo
-- -----------------------------------------------------
CREATE TABLE ADM_Periodo (
  Periodo SERIAL NOT NULL,
  Ciclo INTEGER NOT NULL,
  FechaInicial DATE NULL,
  FechaFinal DATE NULL,
  TipoPeriodo INTEGER NOT NULL,
  TipoAsignacion INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  Centro_UnidadAcademica INTEGER NOT NULL,
  PRIMARY KEY (Periodo),
  CONSTRAINT Centro_UnidadAcademica
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica),
  CONSTRAINT Tipo_Periodo
    FOREIGN KEY (TipoPeriodo)
    REFERENCES ADM_TipoPeriodo (TipoPeriodo),
  CONSTRAINT Tipo_Asignacion
    FOREIGN KEY (TipoAsignacion)
    REFERENCES ADM_TipoAsignacion (TipoAsignacion),
  CONSTRAINT Ciclo
    FOREIGN KEY (Ciclo)
    REFERENCES CUR_Ciclo (Ciclo));


-- -----------------------------------------------------
-- Table EST_Ciclo_Asignacion
-- -----------------------------------------------------
CREATE TABLE EST_Ciclo_Asignacion (
  Ciclo_Asignacion SERIAL NOT NULL,
  Estudiante INTEGER NOT NULL,
  Carrera INTEGER NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  Periodo INTEGER NOT NULL,
  PRIMARY KEY (Ciclo_Asignacion),
  CONSTRAINT Estudiante
    FOREIGN KEY (Estudiante)
    REFERENCES EST_Estudiante (Estudiante),
  CONSTRAINT Periodo
    FOREIGN KEY (Periodo)
    REFERENCES ADM_Periodo (Periodo),
  CONSTRAINT Carrera
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera));
	

-- -----------------------------------------------------
-- Table EST_CUR_Asignacion
-- -----------------------------------------------------
CREATE TABLE EST_CUR_Asignacion (
  Asignacion SERIAL NOT NULL,
  OportunidadActual INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  Seccion INTEGER NOT NULL,
  Ciclo_Asignacion INTEGER NOT NULL,
  Adjuntos TEXT NULL,
  PRIMARY KEY (Asignacion),
  CONSTRAINT Seccion
    FOREIGN KEY (Seccion)
    REFERENCES CUR_Seccion (Seccion),
  CONSTRAINT fk_EST_CUR_Asignacion_EST_Ciclo_Asignacion1
    FOREIGN KEY (Ciclo_Asignacion)
    REFERENCES EST_Ciclo_Asignacion (Ciclo_Asignacion));


-- -----------------------------------------------------
-- Table CUR_EstadoNota
-- -----------------------------------------------------
CREATE TABLE CUR_EstadoNota (
  EstadoNota SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (EstadoNota));


-- -----------------------------------------------------
-- Table EST_CUR_Nota
-- -----------------------------------------------------
CREATE TABLE EST_CUR_Nota (
  Asignacion SERIAL NOT NULL,
  Zona FLOAT NOT NULL,
  Final FLOAT NOT NULL,
  Total FLOAT NOT NULL,
  EstadoNota INTEGER NOT NULL,
  Aprobacion INTEGER NULL,
  Fecha DATE NOT NULL,
  PRIMARY KEY (Asignacion),
  CONSTRAINT Asignacion
    FOREIGN KEY (Asignacion)
    REFERENCES EST_CUR_Asignacion (Asignacion),
  CONSTRAINT fk_EST_Nota_CUR_EstadoNota1
    FOREIGN KEY (EstadoNota)
    REFERENCES CUR_EstadoNota (EstadoNota));


-- -----------------------------------------------------
-- Table ADM_Bitacora
-- -----------------------------------------------------
CREATE TABLE ADM_Bitacora (
  Bitacora SERIAL NOT NULL,
  Usuario INTEGER NOT NULL,
  NombreUsuario TEXT NOT NULL,
  Funcion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  IP TEXT NOT NULL,
  Registro INTEGER NOT NULL,
  Tabla TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (Bitacora));


-- -----------------------------------------------------
-- Table ADM_CentroUnidad_Edificio
-- -----------------------------------------------------
CREATE TABLE ADM_CentroUnidad_Edificio (
  CentroUnidad_Edificio SERIAL NOT NULL,
  Centro_UnidadAcademica INTEGER NOT NULL,
  Edificio INTEGER NOT NULL,
  Jornada INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY(CentroUnidad_Edificio),
  CONSTRAINT Centro_UnidadAcademica
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica),
  CONSTRAINT Edificio
    FOREIGN KEY (Edificio)
    REFERENCES CUR_Edificio (Edificio),
  CONSTRAINT fk_ADM_UnidadAcademica_Edificio_CUR_Jornada1
    FOREIGN KEY (Jornada)
    REFERENCES CUR_Jornada (Jornada));
	
CREATE UNIQUE INDEX u_Centro_UnidadAcademica_Edificio_Jornada ON ADM_CentroUnidad_Edificio (Centro_UnidadAcademica, Edificio, Jornada);


-- -----------------------------------------------------
-- Table CUR_TipoPrerrequisito
-- -----------------------------------------------------
CREATE TABLE CUR_TipoPrerrequisito (
  TipoPrerrequisito SERIAL NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (TipoPrerrequisito));


-- -----------------------------------------------------
-- Table ADM_TipoParametro
-- -----------------------------------------------------
CREATE TABLE ADM_TipoParametro (
  TipoParametro SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoParametro));


-- -----------------------------------------------------
-- Table ADM_Parametro
-- -----------------------------------------------------
CREATE TABLE ADM_Parametro (
  Parametro SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Valor TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  Centro_UnidadAcademica INTEGER NULL,
  Carrera INTEGER NULL,
  TipoParametro INTEGER NOT NULL,
  Codigo INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Parametro),
  CONSTRAINT fk_ADM_Parametro_CUR_Carrera1
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera),
  CONSTRAINT fk_ADM_Parametro_ADM_UnidadAcademica1
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica),
  CONSTRAINT fk_ADM_Parametro_ADM_TipoParametro
    FOREIGN KEY (TipoParametro)
    REFERENCES ADM_TipoParametro (TipoParametro));


-- -----------------------------------------------------
-- Table CUR_Horario_Salon
-- -----------------------------------------------------
CREATE TABLE CUR_Horario_Salon (
  Horario INTEGER NOT NULL,
  Salon INTEGER NOT NULL,
  CONSTRAINT Horario
    FOREIGN KEY (Horario)
    REFERENCES CUR_Horario (Horario),
  CONSTRAINT Salon
    FOREIGN KEY (Salon)
    REFERENCES CUR_Salon (Salon));


-- -----------------------------------------------------
-- Table CAT_Bitacora
-- -----------------------------------------------------
CREATE TABLE CAT_Bitacora (
  Bitacora SERIAL NOT NULL,
  Usuario INTEGER NOT NULL,
  NombreUsuario TEXT NOT NULL,
  Funcion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  IP TEXT NOT NULL,
  Registro INTEGER NOT NULL,
  Tabla TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (Bitacora));


-- -----------------------------------------------------
-- Table EST_Bitacora
-- -----------------------------------------------------
CREATE TABLE EST_Bitacora (
  Bitacora SERIAL NOT NULL,
  Usuario INTEGER NOT NULL,
  NombreUsuario TEXT NOT NULL,
  Funcion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  IP TEXT NOT NULL,
  Registro INTEGER NOT NULL,
  Tabla TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (Bitacora));


-- -----------------------------------------------------
-- Table CUR_TipoActividad
-- -----------------------------------------------------
CREATE TABLE CUR_TipoActividad (
  TipoActividad SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoActividad));


-- -----------------------------------------------------
-- Table CUR_Actividad
-- -----------------------------------------------------
CREATE TABLE CUR_Actividad (
  Actividad SERIAL NOT NULL,
  Valor FLOAT NOT NULL,
  Nombre TEXT NOT NULL,
  Tipo INTEGER NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  ActividadPadre INTEGER NULL,
  PRIMARY KEY (Actividad),
  CONSTRAINT Tipo
    FOREIGN KEY (Tipo)
    REFERENCES CUR_TipoActividad (TipoActividad),
  CONSTRAINT fk_EST_Actividad_EST_Actividad1
    FOREIGN KEY (ActividadPadre)
    REFERENCES CUR_Actividad (Actividad));


-- -----------------------------------------------------
-- Table EST_CUR_Nota_Actividad
-- -----------------------------------------------------
CREATE TABLE EST_CUR_Nota_Actividad (
  Asignacion INTEGER NOT NULL,
  Actividad INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Nota FLOAT NOT NULL,
  Descripcion TEXT NULL,
  Estado INTEGER NOT NULL,
  CONSTRAINT Asignacion
    FOREIGN KEY (Asignacion)
    REFERENCES EST_CUR_Nota (Asignacion),
  CONSTRAINT Actividad
    FOREIGN KEY (Actividad)
    REFERENCES CUR_Actividad (Actividad));


-- -----------------------------------------------------
-- Table EST_Estudiante_Carrera
-- -----------------------------------------------------
CREATE TABLE EST_Estudiante_Carrera (
  Estudiante INTEGER NOT NULL,
  Carrera INTEGER NOT NULL,
  FechaIngreso DATE NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Estudiante, Carrera),
  CONSTRAINT Estudiante
    FOREIGN KEY (Estudiante)
    REFERENCES EST_Estudiante (Estudiante),
  CONSTRAINT Carrera
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera));


-- -----------------------------------------------------
-- Table CUR_TipoAprobacion
-- -----------------------------------------------------
CREATE TABLE CUR_TipoAprobacion (
  TipoAprobacion SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (TipoAprobacion));


-- -----------------------------------------------------
-- Table ADM_TipoMensaje
-- -----------------------------------------------------
CREATE TABLE ADM_TipoMensaje (
  TipoMensaje SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Descripcion TEXT NULL,
  PRIMARY KEY (TipoMensaje));


-- -----------------------------------------------------
-- Table ADM_Mensaje
-- -----------------------------------------------------
CREATE TABLE ADM_Mensaje (
  Mensaje SERIAL NOT NULL,
  Titulo TEXT NOT NULL,
  Contenido TEXT NOT NULL,
  TipoMensaje INTEGER NOT NULL,
  UnidadAcademica INTEGER NOT NULL,
  PRIMARY KEY (Mensaje),
  CONSTRAINT fk_ADM_Mensaje_ADM_TipoMensaje1
    FOREIGN KEY (TipoMensaje)
    REFERENCES ADM_TipoMensaje (TipoMensaje),
  CONSTRAINT fk_ADM_Mensaje_ADM_UnidadAcademica1
    FOREIGN KEY (UnidadAcademica)
    REFERENCES ADM_UnidadAcademica (UnidadAcademica));


-- -----------------------------------------------------
-- Table CUR_Desasignacion
-- -----------------------------------------------------
CREATE TABLE CUR_Desasignacion (
  Desasignacion SERIAL NOT NULL,
  Asignacion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  Descripcion TEXT NULL,
  Adjuntos TEXT NULL,
  PRIMARY KEY (Desasignacion),
  CONSTRAINT fk_EST_CUR_Desasignacion_EST_CUR_Asignacion1
    FOREIGN KEY (Asignacion)
    REFERENCES EST_CUR_Asignacion (Asignacion));


-- -----------------------------------------------------
-- Table EST_TipoPago
-- -----------------------------------------------------
CREATE TABLE EST_TipoPago (
  TipoPago SERIAL NOT NULL,
  Nombre TEXT NOT NULL,
  Monto TEXT NOT NULL,
  Rubro INT NOT NULL,
  Variante INT NOT NULL,
  PRIMARY KEY (TipoPago));


-- -----------------------------------------------------
-- Table EST_Pago
-- -----------------------------------------------------
CREATE TABLE EST_Pago (
  Pago SERIAL NOT NULL,
  TipoPago INTEGER NULL,
  Boleta INTEGER NOT NULL,
  FechaPago DATE NOT NULL,
  Banco TEXT NULL,
  Estudiante INTEGER NULL,
  Periodo INTEGER NULL,
  Carrera INTEGER NULL,
  Estado INTEGER NOT NULL,
  PRIMARY KEY (Pago),
  CONSTRAINT fk_EST_Pago_EST_TipoPago1
    FOREIGN KEY (TipoPago)
    REFERENCES EST_TipoPago (TipoPago),
  CONSTRAINT fk_EST_Pago_EST_Estudiante
    FOREIGN KEY (Estudiante)
    REFERENCES EST_Estudiante (Estudiante),
  CONSTRAINT fk_EST_Pago_ADM_Periodo
    FOREIGN KEY (Periodo)
    REFERENCES ADM_Periodo (Periodo),
  CONSTRAINT fk_EST_Pago_CUR_Carrera
    FOREIGN KEY (Carrera)
    REFERENCES CUR_Carrera (Carrera));


-- -----------------------------------------------------
-- Table EST_Inscripcion
-- -----------------------------------------------------
CREATE TABLE EST_Inscripcion (
  Inscripcion SERIAL NOT NULL,
  Anio INTEGER NOT NULL,
  Fecha DATE NULL,
  Pago INTEGER NULL,
  Estudiante INTEGER NOT NULL,
  Carrera INTEGER NOT NULL,
  PRIMARY KEY (Inscripcion),
  CONSTRAINT fk_EST_Inscripcion_EST_Estudiante_Carrera1
    FOREIGN KEY (Estudiante , Carrera)
    REFERENCES EST_Estudiante_Carrera (Estudiante , Carrera),
  CONSTRAINT fk_EST_Inscripcion_EST_Pago1
    FOREIGN KEY (Pago)
    REFERENCES EST_Pago (Pago));


-- -----------------------------------------------------
-- Table ADM_Centro_UnidadAcademica_Usuario
-- -----------------------------------------------------
CREATE TABLE ADM_Centro_UnidadAcademica_Usuario (
  Usuario INTEGER NOT NULL,
  Centro_UnidadAcademica INTEGER NOT NULL,
  Estado INTEGER NOT NULL,
  CONSTRAINT fk_ADM_Centro_UnidadAcademica_Usuario_ADM_Usuario1
    FOREIGN KEY (Usuario)
    REFERENCES ADM_Usuario (Usuario),
  CONSTRAINT fk_ADM_Centro_UnidadAcademica_Usuario_Centro1
    FOREIGN KEY (Centro_UnidadAcademica)
    REFERENCES ADM_Centro_UnidadAcademica (Centro_UnidadAcademica));

CREATE UNIQUE INDEX u_Centro_UnidadAcademica_Usuario ON ADM_Centro_UnidadAcademica_Usuario (Usuario, Centro_UnidadAcademica);


-- -----------------------------------------------------
-- Table CUR_CursoAntiguo
-- -----------------------------------------------------
CREATE TABLE CUR_CursoAntiguo (
  CursoActual INTEGER NOT NULL,
  CursoAntiguo INTEGER NOT NULL,
  CONSTRAINT fk_CUR_CursoAntiguo_CUR_Curso1
    FOREIGN KEY (CursoActual)
    REFERENCES CUR_Curso (Curso),
  CONSTRAINT fk_CUR_CursoAntiguo_CUR_Curso2
    FOREIGN KEY (CursoAntiguo)
    REFERENCES CUR_Curso (Curso));


-- -----------------------------------------------------
-- Table EST_AsignacionRetrasada
-- -----------------------------------------------------
CREATE TABLE EST_AsignacionRetrasada (
  AsignacionRetrasada SERIAL NOT NULL,
  Asignacion INTEGER NOT NULL,
  Pago INTEGER NOT NULL,
  Oportunidad INTEGER NOT NULL,
  NotaRetrasada FLOAT NOT NULL,
  estadonota INTEGER NOT NULL,
  PRIMARY KEY (AsignacionRetrasada),
  CONSTRAINT fk_EST_Asignacion_Retrasada_EST_CUR_Nota1
    FOREIGN KEY (Asignacion)
    REFERENCES EST_CUR_Nota (Asignacion),
  CONSTRAINT fk_EST_Asignacion_Retrasada_EST_Pago1
    FOREIGN KEY (Pago)
    REFERENCES EST_Pago (Pago),
  CONSTRAINT fk_EST_Asignacion_Retrasada_CUR_Estado_Nota1
    FOREIGN KEY (estadonota)
    REFERENCES CUR_EstadoNota (estadonota));

-- -----------------------------------------------------
-- Table EST_CursoAprobado
-- -----------------------------------------------------
CREATE TABLE EST_CursoAprobado (
  CursoAprobado SERIAL NOT NULL,
  Asignacion INTEGER NULL,
  AsignacionRetrasada INTEGER NULL,
  TipoAprobacion INTEGER NOT NULL,
  FechaAprobacion DATE NOT NULL,
  PRIMARY KEY (CursoAprobado),
  CONSTRAINT fk_EST_CursoAprobado_EST_CUR_Nota1
    FOREIGN KEY (Asignacion)
    REFERENCES EST_CUR_Nota (Asignacion),
  CONSTRAINT fk_EST_CursoAprobado_CUR_TipoAprobacion1
    FOREIGN KEY (TipoAprobacion)
    REFERENCES CUR_TipoAprobacion (TipoAprobacion),
  CONSTRAINT fk_EST_CursoAprobado_EST_AsignacionRetrasada1
    FOREIGN KEY (AsignacionRetrasada)
    REFERENCES EST_AsignacionRetrasada (AsignacionRetrasada));
	
	
-- -----------------------------------------------------
-- Table EST_CUR_Nota_Bitacora
-- -----------------------------------------------------
CREATE TABLE EST_CUR_Nota_Bitacora (
  Bitacora SERIAL NOT NULL,
  Usuario INTEGER NOT NULL,
  NombreUsuario TEXT NOT NULL,
  Funcion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  IP TEXT NOT NULL,
  Registro INTEGER NOT NULL,
  Tabla TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (Bitacora));


-- -----------------------------------------------------
-- Table EST_CUR_Asignacion_Bitacora
-- -----------------------------------------------------
CREATE TABLE EST_CUR_Asignacion_Bitacora (
  Bitacora SERIAL NOT NULL,
  Usuario INTEGER NOT NULL,
  NombreUsuario TEXT NOT NULL,
  Funcion INTEGER NOT NULL,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  IP TEXT NOT NULL,
  Registro INTEGER NOT NULL,
  Tabla TEXT NOT NULL,
  Descripcion TEXT NOT NULL,
  PRIMARY KEY (Bitacora));
