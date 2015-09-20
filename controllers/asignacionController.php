<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of asignacionController
 *
 * @author ARIAS
 */
class asignacionController extends Controller{
    private $_asign;
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_asign=$this->loadModel('asignacion');
        $this->_ajax = $this->loadModel("ajax");
    }
    
    public function index(){
        $tipociclo = 1;//TODO: Marlen: consultar parámetro en base de datos
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        $anio = (isset($lsAnios[count($lsAnios)-1]['anio']) ? $lsAnios[count($lsAnios)-1]['anio'] : -1);
            
        $lsCiclos = $this->_ajax->getCiclosAjax($tipociclo, $anio);
        if(is_array($lsCiclos)){
            $this->_view->lstCiclos = $lsCiclos;
        }else{
            $this->redireccionar("error/sql/" . $lsCiclos);
            exit;
        }
        $ciclo = (isset($lsCiclos[count($lsCiclos)-1]['codigo']) ? $lsCiclos[count($lsCiclos)-1]['codigo'] : -1);
        
        if ($this->getInteger('hdEnvio')) {
            $anio = $this->getInteger('slAnio');
            $ciclo = $this->getInteger('slCiclo');
            
            $this->_view->asignacion = 1;
            
        }
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        
        $this->_view->setJs(array('inicio'));
        $this->_view->renderizar('inicio');
    }
}

?>
