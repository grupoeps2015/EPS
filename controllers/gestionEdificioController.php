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

    public function actualizarAsignacion($intIdEdificio) {
//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARHORARIO);
         
//        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionHorario/index/" . $parametros . "';
//                </script>";
//        }
        
        
        
        $centroUnidad = $this->_post->informacionAsignacionEdificio($intIdEdificio);
        if(is_array($centroUnidad)){
            $this->_view->datosAsig = $centroUnidad;
        }else{
            $this->redireccionar("error/sql/" . $centroUnidad);
            exit;
        }
        
            
        $centro = $this->_ajax->spGetNombreCentroUnidad((isset($centroUnidad[0]['nombreunidad']) ? $centroUnidad[0]['nombreunidadacademica'] : 0));
        print_r($centroUnidad);
        if(is_array($centro)){
            $this->_view->centro = $centro;
        }else{
            $this->redireccionar("error/sql/" . $centro);
            exit;
        }
        
        $jornadas = $this->_post->getJornadas();
        if(is_array($jornadas)){
            $this->_view->jornadas = $jornadas;
        }else{
            $this->redireccionar("error/sql/" . $jornadas);
            exit;
        }
        
        
        
        $this->_view->setJs(array('jquery.validate'), "public");
        
        $arrayAsig = array();
        $this->_view->id = $intIdEdificio;
        $this->_view->titulo = 'Actualizar Asignación - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $unidad = $this->getInteger('slUnidades');
            $centro = $this->getInteger('slCentro');
            $jornada = $this->getInteger('slJornadas');
            
            $arrayAsig['jornada'] = $jornada;
            $arrayAsig['edificio'] = $intIdEdificio;
            $asignacion =  $this->_post->actualizarAsignacion($arrayAsig);
            if(!is_array($asignacion)){
                $this->redireccionar("error/sql/" . $asignacion);
                exit;
            }
            
            
            $this->redireccionar("gestionEdificio/gestionEdificio/" . $parametros);
        }
        //print_r($hor);
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
            $arrayAsignacion['estado'] = ESTADO_ACTIVO;
            $this->_post->asignarUnidadEdificio($arrayAsignacion);
            $this->redireccionar('gestionEdificio/gestionEdificio/'. $intIdEdificio);
        }

        $this->_view->renderizar('asignacionEdificio', 'gestionEdificio');
    }
}