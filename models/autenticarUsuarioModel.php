<?php

/**
 * Description of autenticarUsuarioModel
 *
 * @author Arias
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
            $autenticar = $this->_db->query("SELECT * from spAutenticarUsuario(" . $sp . ");");
            return $autenticar->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
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
}
