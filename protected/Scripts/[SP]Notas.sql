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

-- -----------------------------------------------------
-- Function: spListaDocentesActivos()
-- -----------------------------------------------------
-- DROP FUNCTION spListaDocentesActivos(int);
CREATE OR REPLACE FUNCTION spListaDocentesActivos(IN _centrounidadacademica integer,
						  OUT usuario integer, OUT registro integer,
						  OUT nombrecompleto text, OUT tipodocente text,
						  OUT estado int) RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query 
  Select 
    c.usuario,
    c.registropersonal,
    concat(c.primernombre, ' ', c.segundonombre, ' ', c.primerapellido, ' ', c.segundoapellido),
    t.descripcion as "tipodocente",
    c.estado
  from 
    CAT_catedratico c 
  join CAT_tipocatedratico t on c.tipodocente = t.tipodocente 
  join adm_usuario u on u.usuario = c.usuario 
  where u.centro_unidadacademica = _centrounidadacademica and u.estado >= 0;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spDocentesEspecifico()
-- -----------------------------------------------------
-- DROP FUNCTION spDocentesEspecifico(int);
CREATE OR REPLACE FUNCTION spDocentesEspecifico(IN _idUsuario integer,
						OUT idCatedratico int,
						OUT registro integer,
						OUT nombrecompleto text) RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query 
  Select 
    c.catedratico,
    c.registropersonal,
    concat(c.primernombre, ' ', c.segundonombre, ' ', c.primerapellido, ' ', c.segundoapellido)
  from 
    CAT_catedratico c 
  where c.usuario = _idusuario;
END;
$BODY$
LANGUAGE 'plpgsql';

-- -----------------------------------------------------
-- Function: spDocenteCicloCursos()
-- -----------------------------------------------------
-- DROP FUNCTION spDocenteCicloCursos(int,int);
CREATE OR REPLACE FUNCTION spDocenteCicloCursos(IN _idCatedratico integer,
						IN _idCiclo integer,
						OUT idCurso integer,
						OUT idSeccion int,
						OUT infoSeccion text) RETURNS SETOF record AS
$BODY$
BEGIN
  RETURN query 
  SELECT distinct
    s.curso as idCurso,
    s.seccion as idSeccion,
    (c.codigo || ' - ' || c.nombre || ' - Seccion ' || s.nombre ) as infoSeccion
  FROM 
    CUR_Seccion s 
  JOIN CUR_Trama t ON t.seccion = s.seccion
  JOIN CUR_Curso_catedratico cc ON cc.curso_catedratico = t.curso_catedratico
  JOIN CAT_Catedratico cat ON cat.catedratico = cc.catedratico
  JOIN CUR_Curso c ON cc.curso = c.curso
  JOIN CUR_Horario h ON h.trama = t.trama
  JOIN CUR_Jornada j ON j.jornada = h.jornada
  JOIN CUR_Ciclo ci ON ci.ciclo = h.ciclo
  WHERE cat.catedratico = _idCatedratico AND ci.ciclo = _idCiclo;
END;
$BODY$
LANGUAGE 'plpgsql';

Select 'Script para Gestion de Notas Instalado' as "Gestion Notas";