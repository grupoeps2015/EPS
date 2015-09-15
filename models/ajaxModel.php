<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais(){
        $info = $this->_db->query("select * from spconsultageneral('pais,nombre','adm_pais');");
        if($info === false){
            return "1105/getPais";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDeptos(){
        $deptos = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
        if($deptos === false){
            return "1200/getDeptos";
        }else{
            return $deptos->fetchall();
        }
    }
    
    public function getMunicipio($depto){
        $municipios = $this->_db->query("select * from spMunicipioXDepto({$depto})");
        $municipios->setFetchMode(PDO::FETCH_ASSOC);
        if($municipios === false){
            return "1200/getMunicipio";
        }else{
            return $municipios->fetchall();
        }
    }
    
    public function getJornada(){
        $jornada = $this->_db->query("select * from spconsultageneral('jornada,nombre','cur_jornada');");
        if($jornada === false){
            return "1200/getJornada";
        }else{
            return $jornada->fetchall();
        }
    }
    
    public function getCentro(){
        $centros = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro');");
        if($centros === false){
            return "1200/getCentro";
        }else{
            return $centros->fetchall();
        }
    }
    
    public function getUnidades(){
        $unidades = $this->_db->query("select * from spconsultageneral('unidadAcademica,nombre','adm_unidadAcademica');");
        if($unidades === false){
            return "1200/getUnidades";
        }else{
            return $unidades->fetchall();
        }
    }
    
    public function getTipoCiclo(){
        $ciclos = $this->_db->query("select * from spconsultageneral('tipociclo,nombre','cur_tipociclo');");
        if($ciclos === false){
            return "1200/getTipoCiclo";
        }else{
            return $ciclos->fetchall();
        }
    }
    
    public function getUnidadesAjax($centro){
        $unidades = $this->_db->query("select * from spUnidadxCentro({$centro})");
        $unidades->setFetchMode(PDO::FETCH_ASSOC);
        if($unidades === false){
            return "1200/getUnidadesAjax";
        }else{
            return $unidades->fetchall();
        }
    }
    
    public function getCiclosAjax($tipo){
        $ciclos = $this->_db->query("select * from spCicloxTipo({$tipo})");
        $ciclos->setFetchMode(PDO::FETCH_ASSOC);
        if($ciclos === false){
            return "1200/getCiclosAjax";
        }else{
            return $ciclos->fetchall();
        }
    }
    
    public function getPeriodosAjax($tipo){
        $periodos = $this->_db->query("select * from spPeriodoxTipo({$tipo})");
        $periodos->setFetchMode(PDO::FETCH_ASSOC);
        if($periodos === false){
            return "1200/getPeriodosAjax";
        }else{
            return $periodos->fetchall();
        }
    }
    
    public function getSalonesAjax($edificio){
        $salones = $this->_db->query("select * from spSalonesxEdificio({$edificio})");
        $salones->setFetchMode(PDO::FETCH_ASSOC);
        if($salones === false){
            return "1200/getSalonesAjax";
        }else{
            return $salones->fetchall();
        }
    }
    
    public function getCentroUnidadAjax($centro, $unidad){
        $post = $this->_db->query("select * from spCentroUnidad({$centro},{$unidad}) as id");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        if($post === false){
            return "1200/getCentroUnidadAjax";
        }else{
            return $post->fetchall();
        }
    }
    
    public function getCarreras($unidad){
        $carreras = $this->_db->query("select * from spcarreraxunidad({$unidad})");
        $carreras->setFetchMode(PDO::FETCH_ASSOC);
        if($carreras === false){
            return "1200/getCarreras";
        }else{
            return $carreras->fetchall();
        }
    }
    
    public function getSecuencia($campo, $tabla){
        $secuencia = $this->_db->query("select * from spcarreraxunidad({$campo},{$tabla})");
        $secuencia->setFetchMode(PDO::FETCH_ASSOC);
        if($secuencia === false){
            return "1200/getSecuencia";
        }else{
            return $secuencia->fetchall();
        }
    }
    
    public function getInfoCarreras($centro_unidadacademica){
        $post = $this->_db->query("select * from spinformacioncarrera({$centro_unidadacademica})");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        if($post === false){
            return "1200/getInfoCarreras";
        }else{
            return $post->fetchall();
        }
    }
    
    public function spGetNombreCentroUnidad($id){
        $info = $this ->_db->query("select * from spGetNombreCentroUnidadacademica({$id})");
        $info->setFetchMode(PDO::FETCH_ASSOC);
        if($info === false){
            return "1200/spGetNombreCentroUnidad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDocenteSeccion($cat,$ciclo){
        $post = $this->_db->query("select * from spDocenteCicloCursos({$cat},{$ciclo})");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        if($post === false){
            return "1200/getDocenteSeccion";
        }else{
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
    
}