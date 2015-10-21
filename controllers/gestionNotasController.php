<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class gestionNotasController extends Controller{
    private $_ajax;
    private $_notas;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_ajax = $this->loadModel('ajax');
        $this->_notas = $this->loadModel('gestionNotas');
    }
    
    public function index($id = 0){
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONNOTA);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARNOTA);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        
        if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
            if($this->getInteger('hdCentroUnidad')){
                $idCentroUnidad = $this->getInteger('hdCentroUnidad');
            }else if ($id != 0){
                $idCentroUnidad = $id;
            }else{
                //session_start();
                $idCentroUnidad = $_SESSION["centrounidad"];
            }

            $this->_view->id = $idCentroUnidad;

            $lsCat = $this->_notas->getDocentesActivos($idCentroUnidad);
            if(is_array($lsCat)){
                $this->_view->lstCat = $lsCat;
            }else{
                $this->redireccionar("error/sql/" . $lsCat);
                exit;
            }

            $infoCentroUnidad = $this->_ajax->spGetNombreCentroUnidad($idCentroUnidad);
            if(is_array($infoCentroUnidad)){
                $this->_view->infoCentroUnidad = $infoCentroUnidad;
            }else{
                $this->redireccionar("error/sql/" . $infoCentroUnidad);
                exit;
            }

            $this->_view->setJs(array('gestionNotas'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));
            $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
            $this->_view->id = $idCentroUnidad;
            $this->_view->renderizar('gestionNotas');
       
    }
    
    public function cursosXDocente($idUsuario, $UnidadCentro){
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        
        $datosCat = $this->_notas->getDocenteEspecifico($idUsuario);
        if(is_array($datosCat)){
            $this->_view->datosCat = $datosCat;
        }else{
            $this->redireccionar('error/sql/' . $datosCat);
            exit;
        }
        
        $lsTipoCiclo = $this->_ajax->getTipoCiclo();
        if(is_array($lsTipoCiclo)){
            $this->_view->lsTipoCiclo = $lsTipoCiclo;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoCiclo);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('cursosXDocente'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('cursosXDocente','gestionNotas');
    }
    
    public function actividades(){
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
    }
    
}
