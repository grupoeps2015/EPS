<?php

/**
 * Description of gestionCursoController
 *
 * @author Arias
 */
class gestionCursoController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionCurso');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCURSO);
        
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){        
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
          
            
            $idCentroUnidad = $_SESSION["centrounidad"];

            $this->_view->titulo = 'Gestión de cursos - ' . APP_TITULO;
            $this->_view->id = $idCentroUnidad;

            $lstCur = $this->_post->informacionCurso($idCentroUnidad);
            if(is_array($lstCur)){
                $this->_view->lstCur = $lstCur;
            }else{
                $this->redireccionar("error/sql/" . $lstCur);
                exit;
            }

            $this->_view->setJs(array('gestionCurso'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));

            $this->_view->renderizar('gestionCurso');
        
    }

    public function agregarCurso() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCURSO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        $idCentroUnidad = $_SESSION["centrounidad"];
        if ($this->getInteger('hdEnvio')) {
            $tipoCurso = $this->getInteger('slTiposCurso');
            $codigoCurso = $this->getTexto('txtCodigo');
            $nombreCurso = $this->getTexto('txtNombre');
            $traslapeCurso = $this->getTexto('slTraslape');

            $arrayCur['tipocurso'] = $tipoCurso;
            $arrayCur['codigo'] = $codigoCurso;
            $arrayCur['nombre'] = $nombreCurso;
            $arrayCur['traslape'] = $traslapeCurso;
            $arrayCur['estado'] = ESTADO_ACTIVO;
            $arrayCur['centrounidadacademica'] = $idCentroUnidad;
            
            $info = $this->_post->agregarCurso($arrayCur);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionCurso');
            exit;
        }
        $this->_view->titulo = 'Agregar Curso - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        
        $tiposCurso = $this->_post->getTiposCurso();
        if(is_array($tiposCurso)){
            $this->_view->tiposCurso = $tiposCurso;
        }else{
            $this->redireccionar("error/sql/" . $tiposCurso);
            exit;
        }
        
        $this->_view->setJs(array('agregarCurso'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCur = array();
        
        
        
        $this->_view->renderizar('agregarCurso', 'gestionCurso');    
    }
    
    public function eliminarCurso($intNuevoEstado, $intIdCurso) {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARCURSO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
       
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCurso($intIdCurso, $intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionCurso');
            } else {
                echo "Error al desactivar curso";
            }
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
    }
    
    public function actualizarCurso($intIdCurso = 0) {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCURSO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        $idCentroUnidad = $_SESSION["centrounidad"];
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCurso'));
        
        $tiposCurso = $this->_post->getTiposCurso();
        if(is_array($tiposCurso)){
            $this->_view->tiposCurso = $tiposCurso;
        }else{
            $this->redireccionar("error/sql/" . $tiposCurso);
            exit;
        }
        
        $arrayCur = array();
        $this->_view->id = $intIdCurso;
        
        $datosCur = $this->_post->datosCurso($intIdCurso);
        if(is_array($datosCur)){
            $this->_view->datosCur = $datosCur;
        }else{
            $this->redireccionar("error/sql/" . $datosCur);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Curso - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $tipoCurso = $this->getInteger('slTiposCurso');
            $codigoCurso = $this->getTexto('txtCodigo');
            $nombreCurso = $this->getTexto('txtNombre');
            $traslapeCurso = $this->getTexto('slTraslape');

            $arrayCur['id'] = $intIdCurso;
            $arrayCur['tipocurso'] = $tipoCurso;
            $arrayCur['codigo'] = $codigoCurso;
            $arrayCur['nombre'] = $nombreCurso;
            $arrayCur['traslape'] = $traslapeCurso;

            $respuesta = $this->_post->actualizarCurso($arrayCur);
            if (is_array($respuesta)){
                $this->redireccionar('gestionCurso');
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        $this->_view->renderizar('actualizarCurso', 'gestionCurso');
    }
    
    public function cargarCSV(){
        session_start();
        $idCentroUnidad = $_SESSION["centrounidad"];
        $iden = $this->getInteger('hdFile');
        $fileName = "";
        $fileExt = "";
        
        if($iden == 1){
            $fileName=$_FILES['csvFile']['name'];
            $fileExt = explode(".",$fileName);
            if(strtolower(end($fileExt)) == "csv"){
                $fileName=$_FILES['csvFile']['tmp_name'];
                $handle = fopen($fileName, "r");
                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                    $arrayCur = array();
                    $arrayCur['tipocurso'] = $data[2];
                    $arrayCur['codigo'] = $data[0];
                    $arrayCur['nombre'] = $data[1];
                    $arrayCur['traslape'] = $data[3];
                    $arrayCur['estado'] = $data[4];
                    $arrayCur['centrounidadacademica'] = $idCentroUnidad;
                    $info = $this->_post->agregarCurso($arrayCur);
                    if(!is_array($info)){
                        fclose($handle);
                        $this->redireccionar("error/sql/" . $info);
                        exit;
                    }
                }
                fclose($handle);
                $this->redireccionar('gestionCurso');
                exit;
            }else{
                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
            }
        }
        $this->_view->renderizar('agregarCurso', 'gestionCurso'); 
        
    }
}