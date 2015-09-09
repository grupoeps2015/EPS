<?php

/**
 * Description of admCrearUsuarioModel
 *
 * @author Rickardo
 */
class gestionUsuarioModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    //Metodos utiliados para agregar usuarios nuevos
    public function getUsuarios() {
        try{
            $post = $this->_db->query("select * from spconsultageneral('usuario,nombre','adm_usuario');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function getCentros() {
        try{
            $post = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function getDocentes() {
        try{
            $post = $this->_db->query("select * from spconsultageneral('tipodocente,descripcion','cat_tipocatedratico');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function agregarUsuario($_datos) {
        $sp = '\'' . $_datos["nombreUsr"] . '\',\'' . $_datos["correoUsr"] . '\',\'';
        $sp .= $_datos["claveUsr"] . '\',' . $_datos["preguntaUsr"] . ',\'';
        $sp .= $_datos["respuestaUsr"] . '\',' . $_datos["intentosUsr"] . ',\'';
        $sp .= $_datos["fotoUsr"] . '\',' . $_datos["centroUnidad"];
        try {
            $post = $this->_db->query("SELECT * from spagregarusuarios(" . $sp . ") as Id;");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
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
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
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
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
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
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function asignarRolUsuario($idRol, $id) {
        try {
            $this->_db->query("SELECT spAsignarRolUsuario(" . $idRol . "," . $id . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    //Metodos utilizados para cambiar estado del usuario
    public function informacionUsuario($idCentroUnidad) {
        try {
            $post = $this->_db->query("select * from spInformacionUsuario({$idCentroUnidad});");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function eliminarUsuario($intIdUsuario, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarUsuario(" . $intIdUsuario . "," . $intEstadoNuevo . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    //Metodos utilizados para actualizar usuarios
    public function getPreguntas() {
        try{
            $preguntas = $this->_db->query("select * from spconsultageneral('preguntasecreta,descripcion','adm_preguntasecreta');");
            return $preguntas->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getRol($idUsuario){
        try{
            $rol = $this->_db->query("select * from spRolxUsuario({$idUsuario}) as idRol;");
            return $rol->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function datosUsuario($idUsuario) {
        try {
            $post = $this->_db->query("select * from spdatosusuario('" . $idUsuario . "');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }

    public function actualizarUsuario($_datos) {
        $sp = $_datos["id"] . ', \'' . $_datos["correoUsr"] . '\',\'';
        $sp .= $_datos["clave"] . '\',';
        $sp .= $_datos["preguntaUsr"] . ',\'' . $_datos["respuestaUsr"].'\'';
        try {
            $this->_db->query("SELECT * from spactualizarusuario(" . $sp . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
}
