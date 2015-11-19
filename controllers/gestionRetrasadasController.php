<?php

/**
 * Description of gestionRetrasadasController
 *
 * @author amoino   
 */
class gestionRetrasadasController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;
    private $_generaorden;
    private $estudiante;
    private $carrera;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->getLibrary('wsGeneraOrdenPago');
        $this->_session = new session();
        if (!$this->_session->validarSesion()) {
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionRetrasadas');
        $this->_ajax = $this->loadModel("ajax");
        if ($this->getInteger('slEstudiantes')) {
            $this->estudiante = $this->getInteger('slEstudiantes');
        }
        else if($_SESSION["rol"] == ROL_ESTUDIANTE){
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
                $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
        }
        if ($this->getInteger('slEstudiantes') && $this->getInteger('slCarreras')) {
            $this->carrera = $this->getInteger('slCarreras');
        }
        else if (isset($_SESSION["carrera"])) {
            $this->carrera = $_SESSION["carrera"];
        }
    }

    public function index() {
        $this->_view->titulo = 'Asignación Retrasadas - ' . APP_TITULO;
        $this->_view->setJs(array('gestionRetrasadas'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionRetrasadas');
    }
    
     public function listadoAsignaciones() {
        //$idCarrera = $this->getInteger('slCarreras'); 
        //$idEstudiante = $this->getInteger('slEstudiantes');
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
        
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $tipoAs = ASIGN_JUNTADIRECTIVA;
        }
        else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
            $tipoAs = ASIGN_OTRAS;
        }
        $periodo = $this->_post->getPeriodo($ciclo, PERIODO_ASIGNACION_1RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                //Sino continuar
                //Mostrar cursos disponibles para asignación
                
                //TODO: Marlen: agregar listado de cursos
                $this->_view->asignacion = $periodo[0]['periodo'];
                $this->_view->lstAsignaciones = $this->cursosDisponiblesRetrasada($ciclo);
                
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
                //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                //exit;
                //Si no hay de primera retrasada, buscar de segunda
                $periodo = $this->_post->getPeriodo($ciclo, PERIODO_ASIGNACION_2RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
                if(is_array($periodo)){
                    if(isset($periodo[0]['periodo'])){
                        //TODO: Marlen: agregar listado de cursos
                        $this->_view->asignacion = $periodo[0]['periodo'];
                        $this->_view->lstAsignaciones = $this->cursosDisponiblesRetrasada($ciclo);

                    }
                    else{
                        //TODO: Marlen: mostrar boleta de asignación de cursos
                        //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                        //exit;
                    }
                }else{
                    $this->redireccionar("error/sql/" . $periodo);
                    exit;
                }
            }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        
        $idUsuario = $_SESSION['usuario'];
        $idCarrera = $_SESSION['carrera'];
        $this->_view->carrera=$idCarrera;
       
        $info = $this->_post->allAsignaciones($idUsuario,$idCarrera);
        if (is_array($info)) {
            //$this->_view->lstAsignaciones = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Asignacion de Retrasadas - ' . APP_TITULO;
        //$this->_view->setJs(array('listadoAsignaciones'));
        //$this->_view->setJs(array('jquery.dataTables.min'), "public");
        //$this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoAsignaciones');
        
    }
    
     public function inicio() {
        //$idCarrera = $this->getInteger('slCarreras'); 
        //$idEstudiante = $this->getInteger('slEstudiantes');
        //$idUsuario = $_SESSION['usuario'];
        //$idCarrera = $_SESSION['carrera'];
        $idPago2='4802128';
        $carnet2='200610816';
                
        $this->_generaorden = new wsGeneraOrdenPago();
        $prueba = $this->_generaorden->confirmacionPago($idPago2,$carnet2);
        $cadena = implode(',', $prueba);
        
        if ($this->_generaorden->parsear_resultado($cadena,"CODIGO_RESP") == "1") {
            $this->_view->existePago = 1;
        }
        else {
            $this->_view->existePago = 2;
        }
 
       
        $this->_view->titulo = 'Gestión de retrasadas - ' . APP_TITULO;
        //$this->_view->setJs(array('listadoAsignaciones'));
        //$this->_view->setJs(array('jquery.dataTables.min'), "public");
        //$this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('inicio');
        
    }
    
    public function generarOrdenPago($carnet,$nombre,$carrera){
        if ($this->getInteger('hdCiclo') && $this->getTexto('slCurso')) {
            $slcurso = explode("-", $this->getTexto('slCurso'));
            $curso = $slcurso[0];
            $seccion = $slcurso[1];
            $ciclo = $this->getInteger('hdCiclo');
            if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
                $tipoAs = ASIGN_JUNTADIRECTIVA;
            }
            else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                $tipoAs = ASIGN_OTRAS;
            }
            $periodo = $this->_post->getPeriodo($ciclo, PERIODO_ASIGNACION_1RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
            if(is_array($periodo)){
                if(isset($periodo[0]['periodo'])){
                    $datosExtra = $this->_post->getDatosExtraBoleta($ciclo,PERIODO_ASIGNACION_1RETRASADA);
                    if(is_array($datosExtra)){
                        if(isset($datosExtra[0]['rubro'])){
                            $anio=$datosExtra[0]['anio'];
                            $rubro=$datosExtra[0]['rubro'];
                            $monto=MONTO_1RETRASADA;
                        }
                    }else{
                        $this->redireccionar("error/sql/" . $datosExtra);
                        exit;
                    }
                    
                }
                else{
                    $periodo = $this->_post->getPeriodo($ciclo, PERIODO_ASIGNACION_2RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
                    if(is_array($periodo)){
                        if(isset($periodo[0]['periodo'])){
                            $datosExtra = $this->_post->getDatosExtraBoleta($ciclo,PERIODO_ASIGNACION_2RETRASADA);
                            if(is_array($datosExtra)){
                                if(isset($datosExtra[0]['rubro'])){
                                    $anio=$datosExtra[0]['anio'];
                                    $rubro=$datosExtra[0]['rubro'];
                                    $monto=MONTO_2RETRASADA;
                                }
                            }else{
                                $this->redireccionar("error/sql/" . $datosExtra);
                                exit;
                            }
                        }
                    }else{
                        $this->redireccionar("error/sql/" . $periodo);
                        exit;
                    }
                }                    
            }else{
                    $this->redireccionar("error/sql/" . $periodo);
                    exit;
            }
        }
        //$carnet=200610816;
        $unidad=UNIDAD_ESCUELAHISTORIA;
        $extension=EXTENSION_ESCUELAHISTORIA;
        //$carrera=1;
        //$nombre='TRINIDAD PINEDA JORGE';
        $nombre2 = strtoupper($nombre);
        $monto=10;
        $anio=2014;
        $rubro=4;
        $varianterubro=VARIANTERUBRO_RETRASADAS;
        $tipocurso=TIPOCURSO_ESCUELAHISTORIA;
        $curso='084';
        $seccion='B';
        $subtotal=$monto;
        $subtotal=10;
        
        $this->_generaorden = new wsGeneraOrdenPago();
        $prueba = $this->_generaorden->generaOrdenPago($carnet,$unidad,$extension,$carrera,$nombre2,$monto,$anio,$rubro,$varianterubro,$tipocurso,$curso,$seccion,$subtotal);
        $cadena = implode(',', $prueba);
        
        if ($this->_generaorden->parsear_resultado($cadena,"CODIGO_RESP") == "1") {
            //print_r($cadena);
            date_default_timezone_set('America/Guatemala');
            $this->_view->fecha = date("d-m-Y, H:i:s");
            $this->_view->orden = $this->_generaorden->parsear_resultado($cadena,"ID_ORDEN_PAGO");
            $this->_view->carnet = $this->_generaorden->parsear_resultado($cadena,"CARNET");
            $this->_view->nombre = $nombre;
            $this->_view->unidad = $this->_generaorden->parsear_resultado($cadena,"UNIDAD");
            $this->_view->ext = $this->_generaorden->parsear_resultado($cadena,"EXTENSION");
            $this->_view->carrera = $this->_generaorden->parsear_resultado($cadena,"CARRERA");
            $this->_view->total = $this->_generaorden->parsear_resultado($cadena,"MONTO");
            $this->_view->rubro = $this->_generaorden->parsear_resultado($cadena,"RUBROPAGO");
            $this->_view->llave = $this->_generaorden->parsear_resultado($cadena,"CHECKSUM");
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));
            $this->_view->setJs(array('jspdf.debug'), "public");
            $this->_view->renderizar('ordenPago');
        }
    }
    
    public function cursosDisponiblesRetrasada($ciclo){
        $lsCursosDisponibles = $this->_post->getCursosDisponiblesRetrasada($ciclo, $this->carrera, $this->estudiante);
        if(is_array($lsCursosDisponibles)){

        }else{
            $this->redireccionar("error/sql/" . $lsCursosDisponibles);
            exit;
        }
        return $lsCursosDisponibles;
    }
    
    public function consultarOrdenPago($idPago,$carnet){
        
    }
}