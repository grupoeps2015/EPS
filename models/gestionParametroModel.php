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
        $sp .= '\'' . $_datos["descripcion"] . '\',' . $_datos["centro_unidadacademica"] . ',';
        $sp .= $_datos["carrera"] . ',';
        $sp .= $_datos["extension"] . ',' . $_datos["tipoparametro"];
        try{        
            $this->_db->query("SELECT spagregarparametro(" . $sp . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
        
    //Metodos utilizados para cambiar estado del usuario
    public function informacionParametro(){
        try{
            $post = $this->_db->query("select * from spInformacionParametro();");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function eliminarParametro($intIdParametro, $intEstadoNuevo){
        try{
            $this->_db->query("SELECT spModificarParametro(" . $intIdParametro . ",null,null,null,null,null,null," . $intEstadoNuevo . ",null);");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function actualizarParametro($_datos) {
        $sp = $_datos["parametro"] . ',';
        $sp .= '\'' . $_datos["nombre"] . '\',\'' . $_datos["valor"] . '\',';
        $sp .= '\'' . $_datos["descripcion"] . '\',' . $_datos["centro_unidadacademica"] . ',';
        $sp .= $_datos["carrera"] . ',';
        $sp .= $_datos["extension"] . ',null,' . $_datos["tipoparametro"];
      
        try{
            $this->_db->query("SELECT spModificarParametro(" . $sp. ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }       
    }
    
    public function datosParametro($idParametro) {
        try {
            $post = $this->_db->query("select * from spdatosparametro('" . $idParametro . "');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getCentro_UnidadAcademica() {
        try{
            $post = $this->_db->query("select * from spconsultacentrounidadacademica();");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getTipoParametro() {
        try{
            $post = $this->_db->query("select * from spConsultaTipoParametro();");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
}