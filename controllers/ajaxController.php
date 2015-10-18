<?php

/**
 * Description of ajaxController
 *
 * @author Rickardo
 */
class ajaxController extends Controller{
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax=$this->loadModel('ajax');
    }
    
    public function index(){
        
    }
    
    public function getMunicipio(){
        if($this->getInteger('Depto')){
            echo json_encode($this->_ajax->getMunicipio($this->getInteger('Depto')));
        }
    }
    
    public function getUnidadesAjax(){
        if($this->getInteger('centro')){
            session_start();
            if (isset($_SESSION["rol"]) && $_SESSION["rol"] == ROL_ADMINISTRADOR){
                echo json_encode($this->_ajax->getUnidadesAjax($this->getInteger('centro')));
            }
            else{
                echo json_encode($this->_ajax->getUnidadesCentrosUsuario($_SESSION["usuario"],$this->getInteger('centro')));
            }
        }
    }
    
    public function getJornadasAjax(){
        if($this->getInteger('jornada')){
            echo json_encode($this->_ajax->getJornadas());
        }
    }
    
    public function getTipoCiclo(){
        if($this->getInteger('tipoCiclo')){
            echo json_encode($this->_ajax->getTipoCiclo());
        }
    }
    
    public function getAniosAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getAniosAjax($this->getInteger('tipo')));
        }
    }
    
    public function getCiclosAjax(){
        if($this->getInteger('anio')){
            session_start();
            $tipo = $_SESSION["tipociclo"];
            echo json_encode($this->_ajax->getCiclosAjax($tipo,$this->getInteger('anio')));
        }
    }
    
    public function getPeriodosAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getPeriodosAjax($this->getInteger('tipo')));
        }
    }
    
     public function getDatosCentroUnidadAjax(){
        if($this->getInteger('centroUnidad')){
            echo json_encode($this->_ajax->getDatosCentroUnidad());
        }
    }
    
    public function getSalonesAjax(){
        if($this->getInteger('edificio')){
            echo json_encode($this->_ajax->getSalonesAjax($this->getInteger('edificio')));
        }
    }
    
    public function getCarreras(){
        if($this->getInteger('carr')){
            echo json_encode($this->_ajax->getCarreras($this->getInteger('carr')));
        }
    }
    
    public function getCentroUnidadAjax(){
        if($this->getInteger('centro') && $this->getInteger('unidad')){
            echo json_encode($this->_ajax->getCentroUnidadAjax($this->getInteger('centro'),$this->getInteger('unidad')));
        }
    }
    
    public function getInfoCarreras(){
        if($this->getInteger('centro_unidadacademica')){
            echo json_encode($this->_ajax->getInfoCarreras($this->getInteger('centro_unidadacademica')));
        }
    }
    
    public function getAllCarreras(){
        if($this->getInteger('carrera')){
            echo json_encode($this->_ajax->getAllCarerras());
        }
    }
    
    public function getAllAreas(){
        if($this->getInteger('area')){
            echo json_encode($this->_ajax->getAllAreas());
        }
    }
    
    public function getAllAreasCarreraNoAsignadas(){
        if($this->getInteger('carrera')){
            echo json_encode($this->_ajax->getAllAreasCarreraNoAsignadas());
        }
    }
    
    public function getAllCarreraAreas(){
        if($this->getInteger('CarreraArea')){
            echo json_encode($this->_ajax->getAllCarreraAreas());
        }
    }
    
    public function getDocenteSeccion(){
        if($this->getInteger('cat') && $this->getInteger('ciclo')){
            echo json_encode($this->_ajax->getDocenteSeccion($this->getInteger('cat'),$this->getInteger('ciclo')));
        }
    }
    
    public function getIdTrama(){
        if($this->getInteger('cat') && $this->getInteger('ciclo') && $this->getInteger('sec') && $this->getInteger('cur')){
            echo json_encode($this->_ajax->getIdTrama($this->getInteger('cat'),$this->getInteger('ciclo'),$this->getInteger('sec'),$this->getInteger('cur')));
        }
    }
    
    public function getListaAsignados(){
        if($this->getInteger('trama')){
            echo json_encode($this->_ajax->getListaAsignados($this->getInteger('trama')));
        }
    }
    
    public function getSeccionesCursoHorarioAjax(){
        if($this->getInteger('curso') && $this->getInteger('ciclo')){
            echo json_encode($this->_ajax->getSeccionesCursoHorarioAjax($this->getInteger('curso'),$this->getInteger('ciclo')));
        }
    }
    
    public function getDisponibilidadSalonAjax(){
        if($this->getInteger('ciclo') && $this->getInteger('salon') && $this->getInteger('dia') && $this->getTexto('inicio') && $this->getTexto('fin')){
            $arr['ciclo'] = $this->getInteger('ciclo');
            $arr['salon'] = $this->getInteger('salon');
            $arr['dia'] = $this->getInteger('dia');
            $arr['inicio'] = $this->getTexto('inicio');
            $arr['fin'] = $this->getTexto('fin');
            echo json_encode($this->_ajax->getDisponibilidadSalon($arr));
        }
    }
    
    public function getDisponibilidadCatedraticoAjax(){
        if($this->getInteger('ciclo') && $this->getInteger('cat') && $this->getInteger('dia') && $this->getTexto('inicio') && $this->getTexto('fin')){
            $arr['ciclo'] = $this->getInteger('ciclo');
            $arr['cat'] = $this->getInteger('cat');
            $arr['dia'] = $this->getInteger('dia');
            $arr['inicio'] = $this->getTexto('inicio');
            $arr['fin'] = $this->getTexto('fin');
            echo json_encode($this->_ajax->getDisponibilidadCatedratico($arr));
        }
    }
    
    public function getSiguienteCicloAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getSiguienteCicloAjax($this->getInteger('tipo')));
        }
    }
    
    public function getEstadoUsuario(){
        if($this->getInteger('idUsuario')){
            echo json_encode($this->_ajax->getEstadoUsuario($this->getInteger('idUsuario')));
        }
    }
}

?>