<?php

/**
 * Description of allAutenticarUsuarioModel
 *
 * @author Marlen
 */
class allAutenticarUsuarioModel extends Model{
    
    public function autenticarUsuario($tipo, $usuario, $pass){
        //$sp = '\'' .  $_datos["nombreUsr"] . '\',\'' . $_datos["correoUsr"] . '\',\''; 
        //$sp .= $_datos["claveUsr"] . '\',' . $_datos["preguntaUsr"] . ',\'';
        //$sp .= $_datos["respuestaUsr"] . '\',' . $_datos["intentosUsr"] . ',\'';
        //$sp .= $_datos["fotoUsr"] . '\',' . $_datos["unidadUsr"];
        try{
            //$this->_db->query("SELECT spagregarusuarios(" . $sp . ");");
            //return "SELECT spagregarusuarios(" . $sp . ");";
            return $tipo . " " . $usuario . " " . $pass;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function agregarEstudiante($_datos){
        $sp = $_datos["carnetEst"] . ',\'' . $_datos["direccionEst"] . '\',';
        $sp .= $_datos["zonaEst"] . ',' . $_datos["municipioEst"] . ',\'';
        $sp .= $_datos["telefonoEst"] . '\',\'' . $_datos["telefono2Est"] . '\',\'';
        $sp .= $_datos["sangreEst"] . '\',\'' . $_datos["alergiasEst"] . '\',';
        $sp .= $_datos["seguroEst"] . ',\'' . $_datos["centroEst"] . '\',';
        $sp .= $_datos["paisEst"] . ',\'' . $_datos["nombreEst"] . '\',\'';
        $sp .= $_datos["nombreEst2"] . '\',\'' . $_datos["apellidoEst"] . '\',\'';
        $sp .= $_datos["apellidoEst2"] . '\'';
        
        try{
            $this->_db->query("SELECT spagregarusuarios(" . $sp . ");");
            return "SELECT spagregarestudiante(" . $sp . ");";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function agregarCatedratico($_datos){
        $sp = $_datos["registroCat"] . ',\'' . $_datos["direccionCat"] . '\',';
        $sp .= $_datos["zonaCat"] . ',' . $_datos["municipioCat"] . ',\'';
        $sp .= $_datos["telefonoCat"] . '\',' . $_datos["tipoCat"] . ',';
        $sp .= $_datos["paisCat"] . ',\'' . $_datos["nombreCat"] . '\',\'';
        $sp .= $_datos["nombreCat2"] . '\',\'' . $_datos["apellidoCat"] . '\',\'';
        $sp .= $_datos["apellidoCat2"] . '\'';
        
        try{
            $this->_db->query("SELECT spAgregarCatedratico(" . $sp . ");");
            return "SELECT spAgregarCatedratico(" . $sp . ");";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function agregarEmpleado($_datos){
        $sp = $_datos["registroEmp"] . ',\'' . $_datos["direccionEmp"] . '\',';
        $sp .= $_datos["zonaEmp"] . ',' . $_datos["municipioEmp"] . ',\'';
        $sp .= $_datos["telefonoEmp"] . '\',';
        $sp .= $_datos["paisEmp"] . ',\'' . $_datos["nombreEmp"] . '\',\'';
        $sp .= $_datos["nombreEmp2"] . '\',\'' . $_datos["apellidoEmp"] . '\',\'';
        $sp .= $_datos["apellidoEmp2"] . '\'';
        
        try{
            $this->_db->query("SELECT spAgregarEmpleado(" . $sp . ");");
            return "SELECT spAgregarEmpleado(" . $sp . ");";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    
}

?>