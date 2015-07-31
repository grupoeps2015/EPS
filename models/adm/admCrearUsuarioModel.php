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
        $post = $this->_db->query("SELECT * from spConsultaDepartamentos()");
        return $post->fetchall();
    }
    
    public function getPreguntas(){
        $preguntas = $this->_db->query("SELECT * from spconsultarpreguntasecreta()");
        return $preguntas->fetchall();
    }
    
    public function getUsuarios(){
        $post = $this->_db->query("SELECT * from spConsultaUsuarios()");
        return $post->fetchall();
    }
    
    public function agregarUsuario($_nombre,
                                   $_correo,
                                   $_clave,
                                   $_preguntasecreta,
                                   $_respuestasecreta,
                                   $_intentos,
                                   $_foto,
                                   $_unidadacademica){
        $sp = '\'' .  $_nombre . '\',\'' . $_correo . '\',\'' . $_clave . '\',\'';
        $sp .= $_preguntasecreta . '\',\'' . $_respuestasecreta . '\',' . $_intentos . ',\'';
        $sp .= $_foto . '\',' . $_unidadacademica . ');';
        try{
            $this->_db->query("SELECT spagregarusuarios(" . $sp);
            return "SELECT spagregarusuarios(" . $sp;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>