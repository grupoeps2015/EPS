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
        $info = $this->_db->query("select * from spconsultageneral('usuario,nombre','adm_usuario');");
        if($info === false){
            return "1104/getUsuarios";
        }else{
            return $info->fetchall();
        }
    }

    public function getCentros() {
        $info = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro');");
        if($info === false){
            return "1104/getCentros";
        }else{
            return $info->fetchall();
        }
    }

    public function getDocentes() {
        $info = $this->_db->query("select * from spconsultageneral('tipodocente,descripcion','cat_tipocatedratico');");
        if($info === false){
            return "1104/getDocentes";
        }else{
            return $info->fetchall();
        }
    }

    public function agregarUsuario($_datos) {
        $sp = '\'' . $_datos["nombreUsr"] . '\',\'' . $_datos["correoUsr"] . '\',\'';
        $sp .= $_datos["claveUsr"] . '\',' . $_datos["preguntaUsr"] . ',\'';
        $sp .= $_datos["respuestaUsr"] . '\',' . $_datos["intentosUsr"] . ',\'';
        $sp .= $_datos["fotoUsr"] . '\',' . $_datos["centroUnidad"];
        
        $info = $this->_db->query("SELECT * from spagregarusuarios(" . $sp . ") as Id;");
        if($info === false){
            return "1101/agregarUsuario";
        }else{
            return $info->fetchall();
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

        $info = $this->_db->query("SELECT spagregarestudiante(" . $sp . ");");
        if($info === false){
            return "1101/agregarEstudiante";
        }else{
            return $info->fetchall();
        }     
    }

    public function agregarCatedratico($_datos) {
        $sp = $_datos["registroCat"] . ',\'' . $_datos["direccionCat"] . '\',';
        $sp .= $_datos["zonaCat"] . ',' . $_datos["municipioCat"] . ',\'';
        $sp .= $_datos["telefonoCat"] . '\',' . $_datos["tipoCat"] . ',';
        $sp .= $_datos["paisCat"] . ',\'' . $_datos["nombreCat"] . '\',\'';
        $sp .= $_datos["nombreCat2"] . '\',\'' . $_datos["apellidoCat"] . '\',\'';
        $sp .= $_datos["apellidoCat2"] . '\',' . $_datos["id"];
        
        $info = $this->_db->query("SELECT spAgregarCatedratico(" . $sp . ");");
        if($info === false){
            return "1101/agregarCatedratico";
        }else{
            return $info->fetchall();
        }
    }

    public function agregarEmpleado($_datos) {
        $sp = $_datos["registroEmp"] . ',\'' . $_datos["direccionEmp"] . '\',';
        $sp .= $_datos["zonaEmp"] . ',' . $_datos["municipioEmp"] . ',\'';
        $sp .= $_datos["telefonoEmp"] . '\',';
        $sp .= $_datos["paisEmp"] . ',\'' . $_datos["nombreEmp"] . '\',\'';
        $sp .= $_datos["nombreEmp2"] . '\',\'' . $_datos["apellidoEmp"] . '\',\'';
        $sp .= $_datos["apellidoEmp2"] . '\',' . $_datos["id"];

        $info = $this->_db->query("SELECT spAgregarEmpleado(" . $sp . ");");
        if($info === false){
            return "1101/agregarEmpleado";
        }else{
            return $info->fetchall();
        }
    }

    public function asignarRolUsuario($idRol, $id) {
        $info = $this->_db->query("SELECT spAsignarRolUsuario(" . $idRol . "," . $id . ");");
        if($info === false){
            return "1101/asignarRolUsuario";
        }else{
            return $info->fetchall();
        }
    }

    //Metodos utilizados para cambiar estado del usuario
    public function informacionUsuario($idCentroUnidad) {
        $info = $this->_db->query("select * from spInformacionUsuario({$idCentroUnidad});");
        if($info === false){
            return "1104/informacionUsuario";
        }else{
            return $info->fetchall();
        }
    }

    public function eliminarUsuario($intIdUsuario, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT spActivarDesactivarUsuario(" . $intIdUsuario . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarUsuario";
        }else{
            return $info->fetchall();
        }
    }

    //Metodos utilizados para actualizar usuarios
    public function getPreguntas() {
        $preguntas = $this->_db->query("select * from spconsultageneral('preguntasecreta,descripcion','adm_preguntasecreta');");
        if($preguntas === false){
            return "1104/getPreguntas";
        }else{
            return $preguntas->fetchall();
        }
    }
    
    public function getRol($idUsuario){
        $rol = $this->_db->query("select * from spRolxUsuario({$idUsuario}) as idRol;");
        if($rol === false){
            return "1104/getRol";
        }else{
            return $rol->fetchall();
        }
    }

    public function datosUsuario($idUsuario) {
        $info = $this->_db->query("select * from spdatosusuario('" . $idUsuario . "');");
        if($info === false){
            return "1104/datosUsuario";
        }else{
            return $info->fetchall();
        }
    }

    public function actualizarUsuario($_datos) {
        $sp = $_datos["id"] . ', \'' . $_datos["correoUsr"] . '\',\'';
        $sp .= $_datos["clave"] . '\',';
        $sp .= $_datos["preguntaUsr"] . ',\'' . $_datos["respuestaUsr"].'\'';
        
        $info = $this->_db->query("SELECT * from spactualizarusuario(" . $sp . ");");
        if($info === false){
            return "1103/datosUsuario";
        }else{
            return $info->fetchall();
        }
    }
    
}
