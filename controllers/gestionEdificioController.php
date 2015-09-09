<?php

/**
 * Description of gestionPensumController
 *
 * @author amoino   
 */
class gestionEdificioController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionEdificio');
        $this->_ajax = $this->loadModel("ajax");
    }
    
    public function index($id=0){
        if($this->getInteger('hdEdificio')){
            $idEdificio = $this->getInteger('hdEdificio');
        }else{
            $idEdificio = $id;
        }
        $this->_view->id = $idEdificio;
        $this->_view->lstEdificio = $this->_post->informacionAsignacionEdificio($idEdificio);
        $this->_view->titulo = 'Gestión de Edificios - ' . APP_TITULO;
        $this->_view->setJs(array('gestionEdificio'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionEdificio');
    }


    public function agregarEdificio() {
        $this->_view->titulo = 'Agregar Edificio - ' . APP_TITULO;
        $this->_view->setJs(array('agregarEdificio'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();

        if ($this->getInteger('hdEnvio')) {
            $nombreEdificio = $this->getTexto('txtNombre');
            $nombreDescripcion = $this->getTexto('txtDescripcion');

            $arrayCar['nombre'] = $nombreEdificio;
            $arrayCar['descripcion'] = $nombreDescripcion;
            $arrayCar['estado'] = ESTADO_ACTIVO;
            $this->_post->agregarEdificio($arrayCar);
            $this->redireccionar('gestionEdificio/gestionEdificio');
        }

        $this->_view->renderizar('agregarEdificio', 'gestionEdificio');
    }

}