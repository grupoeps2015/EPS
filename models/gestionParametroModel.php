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
        
        $info = $this->_db->query("SELECT spagregarparametro(" . $sp . ");");
        if($info === false){
            return "1101/agregarParametro";
        }else{
            return $info->fetchall();
        }
    }
        
    //Metodos utilizados para cambiar estado del usuario
    public function informacionParametro(){
        $info = $this->_db->query("select * from spInformacionParametro();");
        if($info === false){
            return "1104/informacionParametro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarParametro($intIdParametro, $intEstadoNuevo){
        $info = $this->_db->query("SELECT spModificarParametro(" . $intIdParametro . ",null,null,null,null,null,null," . $intEstadoNuevo . ",null);");
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
        
        $info = $this->_db->query("SELECT spModificarParametro(" . $sp. ");");
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
    
    public function getCentro_UnidadAcademica() {
        $info = $this->_db->query("select * from spconsultacentrounidadacademica();");
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
    
}