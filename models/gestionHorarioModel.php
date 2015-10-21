<?php

/**
 * Description of gestionHorarioModel
 *
 * @author Arias
 */

class gestionHorarioModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getJornadas() {
        $info = $this->_db->query("select * from spconsultageneral('jornada,nombre','cur_jornada');");
        if($info === false){
            return "1104/getJornadas";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposPeriodo() {
        $info = $this->_db->query("select * from spconsultageneral('tipoperiodo,nombre','cur_tipoperiodo');");
        if($info === false){
            return "1104/getTiposPeriodo";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDias() {
        $info = $this->_db->query("select * from spconsultageneral('codigo,nombre','cur_dia');");
        if($info === false){
            return "1104/getDias";
        }else{
            return $info->fetchall();
        }
    }

    public function informacionEdificio($centrounidadacademica) {
        $info = $this->_db->query("select * from spInformacionEdificio(" . $centrounidadacademica . ");");
        if($info === false){
            return "1104/informacionEdificio";
        }else{
            return $info->fetchall();
        }
    }
    
    public function informacionHorario($ciclo, $seccion) {
        $info = $this->_db->query("select * from spInformacionHorario({$ciclo},{$seccion});");
        if($info === false){
            return "1104/informacionHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarCursoCatedratico($catedratico, $curso) {
        $info = $this->_db->query("select * from spagregarcursocatedratico({$catedratico},{$curso}) as Id;");
        if($info === false){
            //return "select * from spagregarcursocatedratico({$catedratico},{$curso}) as Id;";
            return "1101/agregarCursoCatedratico";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarTrama($_datos) {
        $info = $this->_db->prepare("SELECT * from spagregartrama(:cursocatedratico,:dia,:periodo,:inicio,:fin,:seccion) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarTrama";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarHorario($_datos) {
        $info = $this->_db->prepare("SELECT * from spagregarhorario(:jornada,:trama,:ciclo,:estado) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarHorarioSalon($horario, $salon) {
        $info = $this->_db->query("select * from spagregarhorariosalon({$horario},{$salon});");
        if($info === false){
            return "1101/agregarHorarioSalon";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarHorario($intIdHorario, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spActivarDesactivarHorario(" . $intIdHorario . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosHorario($idHorario) {
        $info = $this->_db->query("select * from spDatosHorario(" . $idHorario . ");");
        if($info === false){
            return "1104/datosHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarHorario($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarHorario(:jornada,:horario) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarTrama($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarTrama(:cursocatedratico,:dia,:periodo,:inicio,:fin,:id) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarTrama";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarCiclo($_datos) {
        $info = $this->_db->prepare("SELECT * from spagregarciclo(:tipo,:anio,:numero) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarCiclo";
        }else{
            return $info->fetchall();
        }
    }
    
    public function copiarHorario($_datos) {
        $info = $this->_db->prepare("SELECT * from spcopiarhorariodecicloaciclo(:cicloO,:cicloD,:centroUnidad) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/copiarHorario";
        }else{
            return $info->fetchall();
        }
    }
    
    //Desde gestionCursoModel 
    public function informacionSeccion($centrounidadacademica) {
        $info = $this->_db->query("select * from spInformacionSeccion(" . $centrounidadacademica . ");");
        if($info === false){
            return "1104/informacionSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosSeccion($idSeccion) {
        $info = $this->_db->query("select * from spDatosSeccion(" . $idSeccion . ");");
        if($info === false){
            return "1104/datosSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    //Desde catedraticoModel
    public function getCatedraticos($centrounidad){
        $info = $this->_db->query("SELECT * from spinformacioncatedratico(" . $centrounidad . ") order by id;");
        if($info === false){
            return "1104/getCatedraticos";
        }else{
            return $info->fetchall();
        }
    }
    
}
