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
        $this->_ajax = $this->loadModel('ajax');
        $this->_notas = $this->loadModel('gestionNotas');
    }
    
    public function index($id = 0){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONNOTA);
                    
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
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
