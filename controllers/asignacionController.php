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
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_asign=$this->loadModel('asignacion');
        $this->_ajax = $this->loadModel("ajax");
    }
    
    public function index(){
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
        if ($this->getInteger('hdEnvio')) {
            $anio = $this->getInteger('slAnio');            
        }
        else{
            $anio = (isset($lsAnios[count($lsAnios)-1]['anio']) ? $lsAnios[count($lsAnios)-1]['anio'] : -1);
        }
        
        $lsCiclos = $this->_ajax->getCiclosAjax($tipociclo, $anio);
        if(is_array($lsCiclos)){
            $this->_view->lstCiclos = $lsCiclos;
        }else{
            $this->redireccionar("error/sql/" . $lsCiclos);
            exit;
        }
        
        if ($this->getInteger('hdEnvio')) {
            $ciclo = $this->getInteger('slCiclo');            
        }
        else{
            $ciclo = (isset($lsCiclos[count($lsCiclos)-1]['codigo']) ? $lsCiclos[count($lsCiclos)-1]['codigo'] : -1);
        }
        
        
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        
        $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_CURSOS, ASIGN_OTRAS, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                $carrera = 1; //TODO: Marlen: $_SESSION["carrera"];
                $this->_view->asignacion = $periodo[0]['periodo'];
                $lsCursosDisponibles = $this->_asign->getCursosDisponibles($ciclo, $carrera);
                if(is_array($lsCursosDisponibles)){
                    $this->_view->lstCursos = $lsCursosDisponibles;
                }else{
                    $this->redireccionar("error/sql/" . $lsCursosDisponibles);
                    exit;
                }
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
    
    public function prueba(){
        $hola = json_decode('[{"name":"[002] TEORIA ECONOMICA I","id":"2","tipo":"1","valor":"-1"},{"name":"Creditos >=5","id":0,"tipo":"2","valor":"5"}]',true);
        //print_r($hola);
        for($i=0;$i<count($hola);$i++){
            echo $i.":"."<br>".
            $hola[$i]['name']."<br>".
            $hola[$i]['id']."<br>".
            $hola[$i]['tipo']."<br>".
            $hola[$i]['valor']."<br><br>";
        }
    }
    
    public function asignar(){
        if ($this->getInteger('hdEnvio')) {
            if ($this->getInteger('hdCiclo')) {
                $periodo = $this->_asign->getPeriodo($this->getInteger('hdCiclo'), PERIODO_ASIGNACION_CURSOS, ASIGN_OTRAS, $_SESSION["centrounidad"]);
                if(is_array($periodo)){
                    if(isset($periodo[0]['periodo'])){
                        $periodo = $periodo[0]['periodo'];
                    }
                    else{
                        //TODO: Marlen: Redirigir a página de error de asignación
                        exit;
                    }
                }
                else{
                    $this->redireccionar("error/sql/" . $periodo);
                    exit;
                }
            }
            $cursos = $this->getTexto('hdCursos');
            $cursos = explode(";", $cursos);
            if(count($cursos)){
                //TODO: Marlen: Crear ciclo asignación
                $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
                if(is_array($estudiante)){
                    $estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
                }else{
                    $this->redireccionar("error/sql/" . $estudiante);
                    exit;
                }
                
                
                $asignacionEstudiante = $this->_asign->agregarCicloAsignacion($estudiante,$periodo);
                if(is_array($asignacionEstudiante)){
                    $asignacionEstudiante = (isset($asignacionEstudiante[0]['id']) ? $asignacionEstudiante[0]['id'] : -1);
                }else{
                    $this->redireccionar("error/sql/" . $asignacionEstudiante);
                    exit;
                }
                for($i=0;$i<count($cursos);$i++){
                    if($cursos[$i] <> ""){
                        $asignacionCurso = $this->_asign->agregarAsignacionCurso($estudiante,$asignacionEstudiante,$cursos[$i],"");
                        if(is_array($asignacionCurso)){
                            $asignacionCurso = (isset($asignacionCurso[0]['id']) ? $asignacionCurso[0]['id'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $asignacionCurso);
                            exit;
                        }
                    }
                    //TODO: Marlen: Insertar cada curso en asignación
                }
            }
        }
    }
    
}

?>
