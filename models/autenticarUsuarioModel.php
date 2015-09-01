<?php

/**
 * Description of allAutenticarUsuarioModel
 *
 * @author Marlen
 */
class autenticarUsuarioModel extends Model{
    
    public function autenticarUsuario($tipo, $usuario, $pass){
        $sp = $usuario . ',\''; 
        $sp .= $pass . '\'';
        if ($tipo == 1){
            //Estudiante
            $sp .= ', \'carnet\', \'est_estudiante\'';
        }
        elseif ($tipo == 2){
            //Catedratico
            $sp .= ', \'registropersonal\', \'cat_catedratico\'';
        }    
        elseif ($tipo == 3 || $tipo == 0){
            //Empleado
            $sp .= ', \'registropersonal\', \'adm_empleado\'';
        }
        try{
            $y = $this->_db->query("SELECT * from spAutenticarUsuario(" . $sp . ");");
            //return "SELECT spAutenticarUsuarios(" . $sp . ");";
            //return $tipo . " " . $usuario . " " . $pass;
            //return "SELECT spAutenticarUsuario(" . $sp . ");";
            return $y->fetchall();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}

?>