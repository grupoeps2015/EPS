<?php

/**
 * Description of admCrearUsuarioModel
 *
 * @author Rickardo
 */
class admCrearUsuarioModel extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function getDepartamentos(){
        $post = $this->_db->query("SELECT * from spConsultaDeptos()");
        return $post->fetchall();
    }
    
    public function agregarUsuario($_usuario,
                                   $_nombre,
                                   $_correo,
                                   $_clave,
                                   $_estado,
                                   $_preguntasecreta,
                                   $_respuestasecreta,
                                   $_fechaultimaautenticacion,
                                   $_integerentosautenticacion,
                                   $_foto,
                                   $_unidadacademica){
        $sp = $_usuario . ',' . $_nombre . ',' . $_correo . ',' . $_clave . ',';
        $sp .= $_estado . ',' . $_preguntasecreta . ',' . $_respuestasecreta . ',';
        $sp .= $_fechaultimaautenticacion . ',' . $_integerentosautenticacion . ',';
        $sp .= $_foto . ',' . $_unidadacademica . ');';
        try{
            $this->_db->query("SELECT spagregarusuarios(" . $sp);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>