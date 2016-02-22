<?php
/**
 * Description of gestionCentroUnidadModel
 *
 * @author Rickardo
 */
class gestionCentroUnidadModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getInfoCentros(){
        $centros = $this->_db->query("select * from spInfoCentros();");
        if($centros === false){
            return "1104/getInfoCentros";
        }else{
            return $centros->fetchall();
        }
    }
    
    public function getNombreCentro($idCentro){
        $centros = $this->_db->query("select * from spNombreCentro({$idCentro});");
        if($centros === false){
            return "1104/getNombreCentro";
        }else{
            return $centros->fetchall();
        }
    }
    
    public function getDatosCentro($idCentro){
        $info = $this->_db->query("select * from spDatosCentro({$idCentro});");
        if($info === false){
            return "1104/getDatosCentro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function setCentro($_datos){
        $info = $this->_db->prepare("SELECT * from spAgregarCentros(:codigo,:nombre,:direccion,:municipio,:zona);");
        $data = $info->execute($_datos);
        if($data === false){
            return "1101/setCentro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function updateCentro($_datos){
        $info = $this->_db->prepare("SELECT * from spActualizarCentro(:id,:nombre,:direccion,:municipio,:zona);");
        $info->execute($_datos);
        if($info === false){
            return "1103/updateCentro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getInfoUnidades($idCentro){
        $unidades = $this->_db->query("select * from spInfoUnidades({$idCentro});");
        if($unidades === false){
            return "1104/getInfoUnidades";
        }else{
            return $unidades->fetchall();
        }
    }
    
    public function getUnidadesPropias($idCentro){
        $unidades = $this->_db->query("select * from spUnidadesPropias({$idCentro});");
        if($unidades === false){
            return "1104/getUnidadesPropias";
        }else{
            return $unidades->fetchall();
        }
    }
    
    public function setUnidad($_datos){
        $sp = $_datos[':id'] . ',' . $_datos[':padre'] . ',\'' . $_datos[':nombre'] . '\',' . $_datos[':tipo'];
        $info = $this->_db->query("SELECT * from spAgregarUnidad({$sp});");
        if($info === false){
            return "1101/setUnidad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function setCentroUnidad($idCentro, $idUnidad){
        $info = $this->_db->query("SELECT * from spAgregarCentroUnidad({$idCentro},{$idUnidad});");
        if($info === false){
            return "1101/setCentroUnidad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function removeCentroUnidad($idCentro, $idUnidad){
        $info = $this->_db->query("SELECT * from spQuitarCentroUnidad({$idCentro},{$idUnidad});");
        if($info === false){
            return "1102/removeCentroUnidad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function estadoNuevo($estado, $centro, $unidad){
        $info = $this->_db->query("SELECT * from spCambiarEstadoCentroUnidad({$estado},{$centro},{$unidad});");
        if($info === false){
            return "1102/estadoNuevo";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getExtensionesCentroUnidad($idCentroUnidad){
        $extensiones = $this->_db->query("select * from spObtenerExtensionesCentroUnidad({$idCentroUnidad});");
        if($extensiones === false){
            return "1104/getExtensionesCentroUnidad";
        }else{
            return $extensiones->fetchall();
        }
    }
    
    public function actualizarExtensiones($idCentro, $extensiones) {
        $info = $this->_db->query("SELECT * from spactualizarextensiones({$idCentro},'{$extensiones}');");
        if($info === false){
            return "1101/actualizarExtensiones";
        }else{
            return $info->fetchall();
        }
    }
}