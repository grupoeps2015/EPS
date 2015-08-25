<?php

/**
 * Description of admCrearParametroModel
 *
 * @author Gerson
 */
class admCrearParametroModel extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    //Metodos utiliados para agregar parametros nuevos
    public function agregarParametro($_datos){
        $sp = '\'' . $_datos["nombre"] . '\',\'' . $_datos["valor"] . '\',';
        $sp .= '\'' . $_datos["descripcion"] . '\',' . $_datos["centro"] . ',';
        $sp .= $_datos["unidadacademica"] . ',' . $_datos["carrera"] . ',';
        $sp .= $_datos["extension"] . ',' . $_datos["tipoparametro"];
        try{        
            $this->_db->query("SELECT spagregarparametro(" . $sp . ");");
            //echo("<script>console.log(".$sp.");</script>");
            //return "SELECT spagregarparametro(" . $sp . ");";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    
    //Metodos utilizados para cambiar estado del usuario
    public function informacionParametro(){
        try{
            $post = $this->_db->query("select * from spInformacionParametro();");
            return $post->fetchall();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function eliminarParametro($intIdParametro, $intEstadoNuevo){
        try{
            $this->_db->query("SELECT spModificarParametro(" . $intIdParametro . ",null,null,null,null,null,null,null," . $intEstadoNuevo . ",null);");
            //return "SELECT spModificarParametro(" . $intIdUsuario . ",null,null,null,null,null,null,null" . $intEstadoNuevo . ",null);";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    
}

?>