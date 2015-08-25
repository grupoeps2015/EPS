<?php

/**
 * Description of admCrearUsuarioModel
 *
 * @author Rickardo
 */
class admCrearUsuarioModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    //Metodos utiliados para agregar usuarios nuevos
    public function getUsuarios() {
        $post = $this->_db->query("select * from spconsultageneral('usuario,nombre','adm_usuario');");
        return $post->fetchall();
    }

    public function getCentros() {
        $post = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro');");
        return $post->fetchall();
    }

    public function getDocentes() {
        $post = $this->_db->query("select * from spconsultageneral('tipodocente,descripcion','cat_tipocatedratico');");
        return $post->fetchall();
    }

    public function agregarUsuario($_datos) {
        $sp = '\'' . $_datos["nombreUsr"] . '\',\'' . $_datos["correoUsr"] . '\',\'';
        $sp .= $_datos["claveUsr"] . '\',' . $_datos["preguntaUsr"] . ',\'';
        $sp .= $_datos["respuestaUsr"] . '\',' . $_datos["intentosUsr"] . ',\'';
        $sp .= $_datos["fotoUsr"] . '\',' . $_datos["unidadUsr"];
        try {
            $post = $this->_db->query("SELECT * from spagregarusuarios(" . $sp . ") as Id;");
            return $post->fetchall();
            //return "SELECT spagregarusuarios(" . $sp . ");"; //aca le digo que devuelva el valor como tal del query a ejecutar
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function agregarEstudiante($_datos) {
        $sp = $_datos["carnetEst"] . ',\'' . $_datos["direccionEst"] . '\',';
        $sp .= $_datos["zonaEst"] . ',' . $_datos["municipioEst"] . ',\'';
        $sp .= $_datos["telefonoEst"] . '\',\'' . $_datos["telefono2Est"] . '\',\'';
        $sp .= $_datos["sangreEst"] . '\',\'' . $_datos["alergiasEst"] . '\',';
        $sp .= $_datos["seguroEst"] . ',\'' . $_datos["centroEst"] . '\',';
        $sp .= $_datos["paisEst"] . ',\'' . $_datos["nombreEst"] . '\',\'';
        $sp .= $_datos["nombreEst2"] . '\',\'' . $_datos["apellidoEst"] . '\',\'';
        $sp .= $_datos["apellidoEst2"] . '\',' . $_datos["id"];

        try {
            $this->_db->query("SELECT spagregarestudiante(" . $sp . ");");
            //return "SELECT spagregarestudiante(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function agregarCatedratico($_datos) {
        $sp = $_datos["registroCat"] . ',\'' . $_datos["direccionCat"] . '\',';
        $sp .= $_datos["zonaCat"] . ',' . $_datos["municipioCat"] . ',\'';
        $sp .= $_datos["telefonoCat"] . '\',' . $_datos["tipoCat"] . ',';
        $sp .= $_datos["paisCat"] . ',\'' . $_datos["nombreCat"] . '\',\'';
        $sp .= $_datos["nombreCat2"] . '\',\'' . $_datos["apellidoCat"] . '\',\'';
        $sp .= $_datos["apellidoCat2"] . '\',' . $_datos["id"];

        try {
            $this->_db->query("SELECT spAgregarCatedratico(" . $sp . ");");
            //return "SELECT spAgregarCatedratico(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function agregarEmpleado($_datos) {
        $sp = $_datos["registroEmp"] . ',\'' . $_datos["direccionEmp"] . '\',';
        $sp .= $_datos["zonaEmp"] . ',' . $_datos["municipioEmp"] . ',\'';
        $sp .= $_datos["telefonoEmp"] . '\',';
        $sp .= $_datos["paisEmp"] . ',\'' . $_datos["nombreEmp"] . '\',\'';
        $sp .= $_datos["nombreEmp2"] . '\',\'' . $_datos["apellidoEmp"] . '\',\'';
        $sp .= $_datos["apellidoEmp2"] . '\',' . $_datos["id"];

        try {
            $this->_db->query("SELECT spAgregarEmpleado(" . $sp . ");");
            return "SELECT spAgregarEmpleado(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function asignarRolUsuario($idRol, $id) {
        try {
            $this->_db->query("SELECT spAsignarRolUsuario(" . $idRol . "," . $id . ");");
            //return "SELECT spAsignarRolUsuario(" . $idRol . "," . $id . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Metodos utilizados para cambiar estado del usuario
    public function informacionUsuario() {
        try {
            $post = $this->_db->query("select * from spInformacionUsuario();");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function eliminarUsuario($intIdUsuario, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarUsuario(" . $intIdUsuario . "," . $intEstadoNuevo . ");");
            //return "SELECT spActivarDesactivarUsuario(" . $intIdUsuario . "," . $intEstadoNuevo . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Metodos utilizados para actualizar usuarios
    public function getPreguntas() {
        $preguntas = $this->_db->query("select * from spconsultageneral('preguntasecreta,descripcion','adm_preguntasecreta');");
        return $preguntas->fetchall();
    }

    /* para actualizar usuario */

    public function datosUsuario($idUsuario) {
        try {
            $post = $this->_db->query("select * from spdatosusuario('" . $idUsuario . "');");
            return $post->fetchall(); //entonces, aca recibimos lo de postgres y lo volvemos un array 
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function actualizarUsuario($idUsuario, $nombreUsr, $correoUsr, $preguntaUsr, $respuestaUsr, $unidadUsr) {
        try {
            $this->_db->query("SELECT spactualizarusuario('" . $idUsuario . "','" . $nombreUsr . "','" . $correoUsr . "','" . $preguntaUsr . "','" . $respuestaUsr . "','" . $unidadUsr . "');");
            //return "SELECT spactualizarusuario(" . $idUsuario . "," . $nombreUsr . "," . $correoUsr ."," . $preguntaUsr . "," . $respuestaUsr ."," . $unidadUsr .");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function actualizarEstudiante() {
        
    }

    public function actualizarCatedratico() {
        
    }

    public function actualizarEmpleado() {
        
    }

}

?>
