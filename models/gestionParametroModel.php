<?php

/**
 * Description of gestionParametroModel
 *
 * @author Gerson
 */
class gestionParametroModel extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    //Metodos utiliados para agregar parametros nuevos
    public function agregarParametro($_datos){
        $sp = '\'' . $_datos["nombre"] . '\',\'' . $_datos["valor"] . '\',';
        $sp .= '\'' . trim($_datos["descripcion"]) . '\',' . $_datos["centro_unidadacademica"] . ',';
        $sp .= $_datos["carrera"] . ',';
        $sp .= $_datos["extension"] . ',' . $_datos["tipoparametro"];
        
        $info = $this->_db->query("SELECT * from spagregarparametro(" . $sp . ");");
        if($info === false){
            return "1101/agregarParametro";
        }else{
            return $info->fetchall();
        }
    }
        
    //Metodos utilizados para cambiar estado del usuario
    public function informacionParametro($idCentroUnidad){
        $info = $this->_db->query("select * from spInformacionParametro({$idCentroUnidad});");
        if($info === false){
            return "1104/informacionParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarParametro($intIdParametro, $intEstadoNuevo){
        $info = $this->_db->query("SELECT * from spModificarParametro(" . $intIdParametro . ",null,null,null,null,null,null," . $intEstadoNuevo . ",null);");
        if($info === false){
            return "1102/eliminarParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarParametro($_datos) {
        $sp = $_datos["parametro"] . ',';
        $sp .= '\'' . $_datos["nombre"] . '\',\'' . $_datos["valor"] . '\',';
        $sp .= '\'' . trim($_datos["descripcion"]) . '\',' . $_datos["centro_unidadacademica"] . ',';
        $sp .= $_datos["carrera"] . ',';
        $sp .= $_datos["extension"] . ',null,' . $_datos["tipoparametro"];
        
        $info = $this->_db->query("SELECT * from spModificarParametro(" . $sp. ");");
        if($info === false){
            return "1103/actualizarParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosParametro($idParametro) {
        $info = $this->_db->query("select * from spdatosparametro('" . $idParametro . "');");
        if($info === false){
            return "1104/datosParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getCentro_UnidadAcademica($idCentroUnidadAcademica) {
        $info = $this->_db->query("select * from spconsultacentrounidadacademica( " . $idCentroUnidadAcademica . ");");
        if($info === false){
            return "1104/getCentro_UnidadAcademica";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTipoParametro() {
        $info = $this->_db->query("select * from spConsultaTipoParametro();");
        if($info === false){
            return "1104/getTipoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    //Métodos para períodos en parámetros
    public function informacionPeriodoParametro($idCentroUnidad){
        $info = $this->_db->query("select * from spInformacionPeriodoParametro({$idCentroUnidad});");
        if($info === false){
            return "1104/informacionPeriodoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarPeriodoParametro($_datos) {
        $info = $this->_db->prepare("SELECT * from spAgregarPeriodoParametro(:ciclo,:tipoperiodo,:tipoasign,:fechainicial,:fechafinal,:centrounidad) as Id;");
        $data = $info->execute($_datos);
        if($data === false){
            return "1101/agregarPeriodoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarPeriodoParametro($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarPeriodoParametro(:id,:ciclo,:tipoperiodo,:tipoasign,:fechainicial,:fechafinal) as Id;");
        $data = $info->execute($_datos);
        if($data === false){
            return "1103/actualizarPeriodoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosPeriodoParametro($idPeriodo) {
        $info = $this->_db->query("select * from spDatosPeriodoParametro(" . $idPeriodo . ");");
        if($info === false){
            return "1104/datosPeriodoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarPeriodoParametro($intIdPeriodo, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spactivardesactivarperiodoparametro(" . $intIdPeriodo . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarPeriodoParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposPeriodo() {
        $info = $this->_db->query("select * from spconsultageneral('tipoperiodo,nombre','adm_tipoperiodo');");
        if($info === false){
            return "1104/getTiposPeriodo";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposAsign() {
        $info = $this->_db->query("select * from spconsultageneral('tipoasignacion,nombre','adm_tipoasignacion');");
        if($info === false){
            return "1104/getTiposAsign";
        }else{
            return $info->fetchall();
        }
    }
}