<?php

/**
 * Description of autenticarUsuarioModel
 *
 * @author Arias
 */
class loginModel extends Model{
    
    public function login(){
        
    }
    
    public function autenticarUsuario($tipo, $usuario, $pass, $maxintentos){
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
        $sp .= ','.$maxintentos;
        
        $autenticar = $this->_db->query("SELECT * from spAutenticarUsuario(" . $sp . ");");
        if($autenticar === false){
            return "1104/autenticarUsuario";
        }else{
            return $autenticar->fetchall();
        }
    }
    
    public function validarPermisoUsuario($funcion, $centroUnidad){
        try {
            if (isset($_SESSION["rol"])){
                if ($_SESSION["rol"] == ROL_ADMINISTRADOR || ($_SESSION["rol"] != ROL_ADMINISTRADOR && $_SESSION["centrounidad"] == $centroUnidad)){
                    $_datos[":funcion"] = $funcion;
                    $_datos[":rol"] = $_SESSION["rol"];
                    $post = $this->_db->prepare("SELECT * from spValidarPermisoUsuario(:funcion,:rol) as resultado;");
                    $post->execute($_datos);
                    $resultado = $post->fetchall();
                    if (isset($resultado[0][0]) && $resultado[0][0] > 0){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function actualizarAutenticacion($usuario){
        $autenticar = $this->_db->query("SELECT * from spactualizarautenticacion({$usuario});");
        if($autenticar === false){
            return "1103/actualizarAutenticacion";
        }else{
            return $autenticar->fetchall();
        }
    }
    
}
