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
    
    public function listadoEdificio() {
//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONEDIFICIO);
//                    
//        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){        
//            echo "<script>
//                alert('No tiene permisos para acceder a esta función.');
//                window.location.href='" . BASE_URL . "login/inicio';
//                </script>";
//        }
        
        $info = $this->_post->allEdificios();
        if(is_array($info)){
            $this->_view->lstEdif = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de Edificios - ' . APP_TITULO;
        $this->_view->setJs(array('listadoEdificios'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoEdificios');
        
    }
    
    public function index($id=0){
        if($this->getInteger('hdEdificio')){
            $idEdificio = $this->getInteger('hdEdificio');
        }else{
            $idEdificio = $id;
        }
        $this->_view->id = $idEdificio;

        $info = $this->_post->informacionAsignacionEdificio($idEdificio);
        if(is_array($info)){
            $this->_view->lstEdificio = $info;                
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Gestión de Edificios - ' . APP_TITULO;
        $this->_view->setJs(array('gestionEdificio'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionEdificio');
        
    }

    public function actualizarAsignacion($intIdAsignacion = 0, $intIdEdificio = 0) {
//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARHORARIO);
         
//        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionHorario/index/" . $parametros . "';
//                </script>";
//        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarAsignacion'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        $arrayAsig = array();
        $this->_view->id = $intIdAsignacion;
        $this->_view->idEdificio = $intIdEdificio;
        
        $datosAsig = $this->_post->datosAsignacionEdificio($intIdAsignacion);
        if(is_array($datosAsig)){
            $this->_view->datosAsig = $datosAsig;
        }else{
            $this->redireccionar("error/sql/" . $datosAsig);
            exit;
        }
        
        $unicentro = $this->_post->getCentro_UnidadAcademica(0);
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $lsJornadas = $this->_view->jornadas = $this->_ajax->getJornada();
        if(is_array($lsJornadas)){
            $this->_view->jornadas = $lsJornadas;
        }else{
            $this->redireccionar("error/sql/" . $lsJornadas);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayAsig["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayAsig["edificio"] = $intIdEdificio;  
            $arrayAsig["jornada"] = $this->getInteger('slJornadas');         
            $arrayAsig["centrounidad_edificio"] = $intIdAsignacion;
            
            $info = $this->_post->actualizarAsignacionEdificio($arrayAsig);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionEdificio/actualizarAsignacion/' . $intIdAsignacion . '/' . $intIdEdificio);
       
        }
        $this->_view->renderizar('actualizarAsignacion', 'gestionEdificio');
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
            $arrayCar['estado'] = ESTADO_PENDIENTE;
            $this->_post->agregarEdificio($arrayCar);
            $this->redireccionar('gestionEdificio/listadoEdificio');
        }

        $this->_view->renderizar('agregarEdificio', 'gestionEdificio');
    }
    
     public function activarDesactivarEdificio($intNuevoEstado, $intIdEdificio) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $info = $this->_post->activarDesactivarEdificio($intIdEdificio, $intNuevoEstado);
            
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionEdificio/listadoEdificio');
        } else {
            echo "Error al desactivar el edificio";
        }
    }

    public function asignacionEdificio($intIdEdificio = 0) {
         $this->_view->id = $intIdEdificio;

        $lsCentros = $this->_view->centros = $this->_ajax->getDatosCentroUnidad();
        if(is_array($lsCentros)){
            $this->_view->centros = $lsCentros;
        }else{
            $this->redireccionar("error/sql/" . $lsCentros);
            exit;
        }
        
        $lsJornadas = $this->_view->jornadas = $this->_ajax->getJornada();
        if(is_array($lsJornadas)){
            $this->_view->jornadas = $lsJornadas;
        }else{
            $this->redireccionar("error/sql/" . $lsJornadas);
            exit;
        }
        
        $this->_view->titulo = 'Asignacion de Edificio - ' . APP_TITULO;
        $this->_view->setJs(array('asignacionEdificio'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayAsignacion = array();
        
        if ($this->getInteger('hdEnvio')) {
            $centroUnidadAcademica = $this->getInteger('slCentros');
            $jornada = $this->getInteger('slJornadas');

            $arrayAsignacion['centroUnidadAcademica'] = $centroUnidadAcademica;
            $arrayAsignacion['edificio'] = $intIdEdificio;
            $arrayAsignacion['jornada'] = $jornada;
            $arrayAsignacion['estado'] = ESTADO_PENDIENTE;
            $this->_post->asignarUnidadEdificio($arrayAsignacion);
            $this->redireccionar('gestionEdificio/gestionEdificio/'. $intIdEdificio);
        }

        $this->_view->renderizar('asignacionEdificio', 'gestionEdificio');
    }
    
     public function eliminarAsignacionEdificio($intNuevoEstado, $intIdAsignacion, $idEdificio){
       
            if($intNuevoEstado == -1 || $intNuevoEstado == 1){
                $info = $this->_post->eliminarAsignacion($intIdAsignacion,$intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionEdificio/gestionEdificio/' . $idEdificio);
            }else{
                $this->_view->cambio = "No reconocio ningun parametro";    
            }
        }
    
}