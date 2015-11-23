<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais(){
        $info = $this->_db->query("select * from spconsultageneral('pais,nombre','adm_pais') order by codigo;");
        if($info === false){
            return "1105/getPais";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDeptos(){
        $deptos = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento') order by codigo;");
        if($deptos === false){
            return "1200/getDeptos";
        }else{
            return $deptos->fetchall();
        }
    }
    
    public function getMunicipio($depto){
        $municipios = $this->_db->query("select * from spMunicipioXDepto({$depto})");
        if($municipios === false){
            return "1200/getMunicipio";
        }else{
            $municipios->setFetchMode(PDO::FETCH_ASSOC);
            return $municipios->fetchall();
        }
    }
    
    public function getJornada(){
        $jornada = $this->_db->query("select * from spconsultageneral('jornada,nombre','cur_jornada') order by codigo;");
        if($jornada === false){
            return "1200/getJornada";
        }else{
            return $jornada->fetchall();
        }
    }
    
    public function getCentro(){
        $centros = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro') order by codigo;");
        if($centros === false){
            return "1200/getCentro";
        }else{
            return $centros->fetchall();
        }
    }
    
    public function getUnidades(){
        $unidades = $this->_db->query("select * from spconsultageneral('unidadAcademica,nombre','adm_unidadAcademica') order by codigo;");
        if($unidades === false){
            return "1200/getUnidades";
        }else{
            return $unidades->fetchall();
        }
    }
    
    public function getTipoCiclo(){
        $ciclos = $this->_db->query("select * from spconsultageneral('tipociclo,nombre','cur_tipociclo') order by codigo;");
        if($ciclos === false){
            return "1200/getTipoCiclo";
        }else{
            return $ciclos->fetchall();
        }
    }
    
    public function getUnidadesAjax($centro){
        $unidades = $this->_db->query("select * from spUnidadxCentro({$centro})");
        if($unidades === false){
            return "1200/getUnidadesAjax";
        }else{
            $unidades->setFetchMode(PDO::FETCH_ASSOC);
            return $unidades->fetchall();
        }
    }
    
    public function getAniosAjax($tipo){
        $anios = $this->_db->query("select * from spanioxtipociclo({$tipo}) as anio");
        if($anios === false){
            return "1200/getAniosAjax";
        }else{
            $anios->setFetchMode(PDO::FETCH_ASSOC);
            return $anios->fetchall();
        }
    }
    
    public function getCiclosAjax($tipo,$anio){
        $ciclos = $this->_db->query("select * from spCicloxTipo({$tipo},{$anio})");
        if($ciclos === false){
            return "1200/getCiclosAjax";
        }else{
            $ciclos->setFetchMode(PDO::FETCH_ASSOC);
            return $ciclos->fetchall();
        }
    }
    
    public function getPeriodosAjax($tipo){
        $periodos = $this->_db->query("select * from spPeriodoxTipo({$tipo})");
        if($periodos === false){
            return "1200/getPeriodosAjax";
        }else{
            $periodos->setFetchMode(PDO::FETCH_ASSOC);
            return $periodos->fetchall();
        }
    }
    
    public function getSalonesAjax($edificio){
        $salones = $this->_db->query("select * from spSalonesxEdificio({$edificio}) order by codigo");
        if($salones === false){
            return "1200/getSalonesAjax";
        }else{
            $salones->setFetchMode(PDO::FETCH_ASSOC);
            return $salones->fetchall();
        }
    }
    
    public function getCentroUnidadAjax($centro, $unidad){
        $post = $this->_db->query("select * from spCentroUnidad({$centro},{$unidad}) as id");
        if($post === false){
            return "1200/getCentroUnidadAjax";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getCarreras($unidad){
        $carreras = $this->_db->query("select * from spcarreraxunidad({$unidad})");
        if($carreras === false){
            return "1200/getCarreras";
        }else{
            $carreras->setFetchMode(PDO::FETCH_ASSOC);
            return $carreras->fetchall();
        }
    }
    
    public function getSecuencia($campo, $tabla){
        $secuencia = $this->_db->query("select * from spcarreraxunidad({$campo},{$tabla})");
        if($secuencia === false){
            return "1200/getSecuencia";
        }else{
            $secuencia->setFetchMode(PDO::FETCH_ASSOC);
            return $secuencia->fetchall();
        }
    }
    
    public function getAllCarreras(){
        $info = $this->_db->query("select * from spconsultageneral('carrera,nombre','cur_carrera') order by codigo;");
        if($info === false){
            return "1105/getAllCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
     public function getAllAreas(){
        $info = $this->_db->query("select * from spmostrarareasactivas();");
        if($info === false){
            return "1105/getAllAreas";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getAllAreasCarreraNoAsignadas($idCarrera){
        $info = $this->_db->query("select * from spmostrarareasactivascarrera({$idCarrera});");
        if($info === false){
            return "1105/getAllAreasCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getAllCarreraAreas($idCarrera){
        $info = $this->_db->query("select * from spmostrarcarerraareasactivas({$idCarrera});");
        if($info === false){
            return "1105/getAllCarreraAreas";
        }else{
            return $info->fetchall();
        } 
    }


    public function getInfoCarreras($centro_unidadacademica){
        $post = $this->_db->query("select * from spinformacioncarrera({$centro_unidadacademica})");
        if($post === false){
            return "1200/getInfoCarreras";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function spGetNombreCentroUnidad($id){
        $info = $this ->_db->query("select * from spGetNombreCentroUnidadacademica({$id})");
        if($info === false){
            return "1200/spGetNombreCentroUnidad";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getDocenteSeccion($cat,$ciclo){
        $post = $this->_db->query("select * from spDocenteCicloCursos({$cat},{$ciclo}) order by idCurso;");
        if($post === false){
            return "1200/getDocenteSeccion";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getIdTrama($cat,$ciclo,$sec,$cur){
        $post = $this->_db->query("select * from spIdTrama({$cat},{$ciclo},{$cur},{$sec})");
        if($post === false){
            return "1200/getIdTrama";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getListaAlumnosAsignados($id,$ciclo){
        
        $post = $this->_db->query("select * from spListaAlumnosAsignados({$id},{$ciclo}) order by carnet");
        if($post === false){
            return "1200/getListaAlumnosAsignados";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getDatosCentroUnidad(){
        $centroUnidad = $this->_db->query("select * from spdatoscentrounidad();");
        if($centroUnidad === false){
            return "1200/getDatosCentroUnidad";
        }else{
            return $centroUnidad->fetchall();
        }
    }
    
    public function getPermisosRolFuncion($rol,$funcion)
    {
        $post = $this->_db->query("SELECT * FROM spValidarRolFuncion({$rol},{$funcion}) AS valido");
        if($post === false){
            return "1200/getPermisosRolFuncion";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getEstudianteUsuario($usuario){
        $info = $this ->_db->query("select * from spEstudianteXUsuario({$usuario}) AS id;");
        if($info === false){
            return "1200/getEstudianteUsuario";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getCarrerasEstudiante($estudiante,$centrounidad){
        $info = $this ->_db->query("select * from spCarrerasXEstudiante({$estudiante},{$centrounidad})");
        if($info === false){
            return "1200/getCarrerasEstudiante";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getCentroUnidadUsuario($usuario){
        $info = $this ->_db->query("select * from spcentrounidadxusuario({$usuario})");
        if($info === false){
            return "1200/getCentroUnidadUsuario";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getCentrosUsuario($usuario){
        $info = $this ->_db->query("select * from spcentroxusuario({$usuario})");
        if($info === false){
            return "1200/getCentrosUsuario";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getUnidadesCentrosUsuario($usuario,$centro){
        $info = $this ->_db->query("select * from spunidadxcentroxusuario({$usuario},{$centro})");
        if($info === false){
            return "1200/getUnidadesCentrosUsuario";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getTipoUnidadAcademica(){
        $info = $this->_db->query("select * from spconsultageneral('tipounidadacademica,nombre','adm_tipounidadacademica') order by codigo;");
        if($info === false){
            return "1200/getTipoUnidadAcademica";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getSeccionesCursoHorarioAjax($curso,$ciclo){
        $post = $this->_db->query("select * from spSeccionesCursoHorario({$curso},{$ciclo})");
        if($post === false){
            return "1200/getSeccionesCursoHorarioAjax";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getDisponibilidadSalon($_datos) {
        $info = $this->_db->prepare("SELECT * from spDisponibilidadSalon(:ciclo,:salon,:dia,:inicio,:fin) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1200/getDisponibilidadSalon";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDisponibilidadCatedratico($_datos) {
        $info = $this->_db->prepare("SELECT * from spDisponibilidadCatedratico(:ciclo,:cat,:dia,:inicio,:fin) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1200/getDisponibilidadCatedratico";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getSiguienteCicloAjax($tipo){
        $info = $this ->_db->query("select * from spsiguienteciclo({$tipo})");
        if($info === false){
            return "1200/getSiguienteCicloAjax";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function valorParametro($codigoParametro,$carrera,$centroUnidad) {
        $info = $this->_db->query("select * from spvalorparametro($codigoParametro,$carrera,$centroUnidad);");
        if($info === false){
            return "1200/valorParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getEstadoUsuario($idusuario){
        $info = $this ->_db->query("select * from spVerEstadoUsuario({$idusuario})");
        if($info === false){
            return "1200/getEstadoUsuario";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getCupoSeccionAjax($ciclo, $seccion){
        $info = $this ->_db->query("select * from spobtenercuposeccion({$ciclo},{$seccion}) as cupo");
        if($info === false){
            return "1200/getCupoSeccionAjax";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getCreditosEstudianteCarrera($estudiante, $carrera){
        $info = $this ->_db->query("select * from spcreditoscursosaprobados({$estudiante},{$carrera}) as creditos");
        if($info === false){
            return "1200/getCreditosEstudianteCarrera";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getEstudiantesInscritosAnio($centrounidad, $anio){
        $info = $this ->_db->query("select * from spEstudiantesInscritosxCentroUnidad({$centrounidad},{$anio});");
        if($info === false){
            return "1200/getEstudiantesInscritosAnio";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function getAniosInscripcion(){
        $info = $this ->_db->query("select * from spAniosXInscripcion();");
        if($info === false){
            return "1200/getAniosInscripcion";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
     public function getInfoGeneralEstudiante($idUsuario){
       
        $info = $this->_db->query("select * from spInfoGeneralEstudiante({$idUsuario})");
        if($info === false){
            return "1104/getInfoGeneral";
        }else{
            return $info->fetchall();
        }
    }
    
}