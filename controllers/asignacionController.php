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
        session_start();
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
        }
        
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        
        $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_CURSOS, ASIGN_OTRAS, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                $this->_view->asignacion = $periodo[0]['periodo'];
                //TODO: Marlen: agregar listado de cursos
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
            }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        
        $this->_view->setJs(array('inicio'));
        $this->_view->renderizar('inicio');
    }
}

?>
