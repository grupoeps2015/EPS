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
        if($_datos["carrera"] == 0){$_datos["carrera"] = 'null';}
        
        $sp = '\'' . $_datos["nombre"] . '\',\'' . $_datos["valor"] . '\',';
        $sp .= '\'' . trim($_datos["descripcion"]) . '\',' . $_datos["centro_unidadacademica"] . ',';
        $sp .= $_datos["carrera"] . ',';
        $sp .= $_datos["codigo"] . ',' . $_datos["tipoparametro"];
        
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
        $info = $this->_db->query("SELECT * from spactivardesactivarparametro(" . $intIdParametro . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarParametro($param,$valor) {
       
        $info = $this->_db->query("SELECT * from spModificarParametro({$param},'{$valor}');");
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
        try {
        //$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $info = $this->_db->query("SELECT * from spActualizarPeriodoParametro({$_datos['id']},{$_datos['ciclo']},{$_datos['tipoperiodo']},{$_datos['tipoasign']},'{$_datos['fechainicial']}','{$_datos['fechafinal']}') as Id;");
        //$data = $info->execute($_datos);
        if($info === false){
            print_r("SELECT * from spActualizarPeriodoParametro({$_datos['id']},{$_datos['ciclo']},{$_datos['tipoperiodo']},{$_datos['tipoasign']},'{$_datos['fechainicial']}','{$_datos['fechafinal']}') as Id;");
            return "1103/actualizarPeriodoParametro";
        }else{
            return $info->fetchall();
        }
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
            exit;
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