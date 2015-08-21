<?php

/**
 * Description of admCrearParametroController
 *
 * @author Gerson
 */

class admCrearParametroController extends Controller{
    
    private $_post;
    private $_encriptar;
    
     public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER,'admCrearParametro');
    }

    public function index(){
        $this->_view->lstPar = $this->_post->informacionParametro();
        $this->_view->titulo = 'Gestión de parámetros - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('eliminarParametro'));
        $this->_view->setPublicCSS(array('jquery.dataTables.min'));
        $this->_view->setPublicJs(array('jquery.dataTables.min'));
        $this->_view->renderizarAdm('admCrearParametro', 'admCrearParametro');
    }
    
    public function agregarParametro(){
        $iden = $this->getInteger('hdEnvio');
        $idUsr = 0;
        $nombreUsr='';
        $correoUsr='';
        $fotoUsr='';
        $crearUsr = false;
        
        $arrayUsr = array();
        $arrayEst = array();
        $arrayEmp = array();
        $arrayCat = array();
        
        $this->_view->centros = $this->_post->getCentros();
        $this->_view->docentes = $this->_post->getDocentes();
        
        $this->_view->titulo = 'Agregar Parametro - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarParametro'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        if($iden == 1){
            $this->_view->datos = $_POST;
            if(!$this->getTexto('txtNombreEst1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEst')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEst1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCarnetEst')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = true;
            
        }
        elseif($iden == 2){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreCat1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoCat')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoCat1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoCat')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = true;
            
        }
        elseif($iden == 3){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreEmp1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEmp')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEmp1')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoEmp')){
                $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreEmp1');
            $correoUsr = $this->getTexto('txtCorreoEmp');
            $fotoUsr = $this->getTexto('txtFotoEmp');
            $crearUsr = true;
        }
        
        if($crearUsr){
            $arrayUsr["nombreUsr"] = $nombreUsr;
            $arrayUsr["correoUsr"] = $correoUsr;
            $arrayUsr["fotoUsr"] = $fotoUsr;
            $claveAleatoria = $this->_encriptar->keyGenerator();
            $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, UNIDAD_ACADEMICA);
            $arrayUsr["preguntaUsr"] = 0;
            $arrayUsr["respuestaUsr"] = "USAC";
            $arrayUsr["intentosUsr"] = 5;
            $arrayUsr["unidadUsr"] = UNIDAD_ACADEMICA;
            $idUsr=$this->_post->agregarParametro($arrayUsr)[0][0];
            
            if($iden == 1){
                $arrayEst["id"] = $idUsr;
                $arrayEst["carnetEst"] = $this->getTexto('txtCarnetEst');
                $arrayEst["nombreEst"] = $nombreUsr;
                $arrayEst["nombreEst2"] = $this->getTexto('txtNombreEst2');
                $arrayEst["apellidoEst"] = $this->getTexto('txtApellidoEst1');
                $arrayEst["apellidoEst2"] = $this->getTexto('txtApellidoEst2');
                $arrayEst["direccionEst"] = "ciudad";
                $arrayEst["zonaEst"] = 0;
                $arrayEst["municipioEst"] = 1;
                $arrayEst["telefonoEst"] = "22220000";
                $arrayEst["telefono2Est"] = "22220000";
                $arrayEst["sangreEst"] = "desconocida";
                $arrayEst["alergiasEst"] = "desconocidas";
                $arrayEst["seguroEst"] = 'false';
                $arrayEst["centroEst"] = "desconocido";
                $arrayEst["paisEst"] = 1;
                $this->_view->query=$this->_post->agregarEstudiante($arrayEst);
                $this->_post->asignarRolParametro(ROL_ESTUDIANTE,$idUsr);
            }
            elseif($iden == 2){
                $arrayCat["id"] = $idUsr;
                $arrayCat["registroCat"] = $this->getTexto('txtCodigoCat');
                $arrayCat["nombreCat"] = $nombreUsr;
                $arrayCat["nombreCat2"] = $this->getTexto('txtNombreCat2');
                $arrayCat["apellidoCat"] = $this->getTexto('txtApellidoCat1');
                $arrayCat["apellidoCat2"] = $this->getTexto('txtApellidoCat2');
                $arrayCat["direccionCat"] = "ciudad";
                $arrayCat["zonaCat"] = 0;
                $arrayCat["municipioCat"] = 1;
                $arrayCat["telefonoCat"] = "22220000";
                $arrayCat["paisCat"] = 1;
                $arrayCat["tipoCat"] = $this->getInteger('slDocente');
                $this->_post->agregarCatedratico($arrayCat);
                $this->_post->asignarRolParametro(ROL_DOCENTE,$idUsr);
            }
            elseif($iden == 3){
                $arrayEmp["id"] = $idUsr;
                $arrayEmp["registroEmp"] = $this->getTexto('txtCodigoEmp');
                $arrayEmp["nombreEmp"] = $nombreUsr;
                $arrayEmp["nombreEmp2"] = $this->getTexto('txtNombreEmp2');
                $arrayEmp["apellidoEmp"] = $this->getTexto('txtApellidoEmp1');
                $arrayEmp["apellidoEmp2"] = $this->getTexto('txtApellidoEmp2');
                $arrayEmp["direccionEmp"] = "ciudad";
                $arrayEmp["zonaEmp"] = 0;
                $arrayEmp["municipioEmp"] = 1;
                $arrayEmp["telefonoEmp"] = "22220000";
                $arrayEmp["paisEmp"] = 1;
                $this->_post->agregarEmpleado($arrayEmp);
                $this->_post->asignarRolParametro(ROL_EMPLEADO,$idUsr);
            }
            
            $this->redireccionar('admCrearParametro');
        }
        
        $this->_view->renderizarAdm('agregarParametro', 'admCrearParametro');
    }
    
    public function eliminarParametro($intNuevoEstado,$intIdParametro){
        if($intNuevoEstado == -1 || $intNuevoEstado == 1){
            $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
            $this->redireccionar('admCrearParametro');
        }else{
          $this->_view->cambio = "No reconocio ningun parametro";    
        }
        //$this->redireccionar('admCrearParametro');
        //$this->_view->cambio = $intNuevoEstado;
        $this->_view->titulo = 'Eliminar Parametro - ' . APP_TITULO;
        $this->_view->renderizarAdm('eliminarParametro', 'admCrearParametro');
    }
    
    public function actualizarParametro(){
        
    }
    
}

?>