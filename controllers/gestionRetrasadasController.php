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
                $idPeriodo = $periodo[0]['periodo'];
                //Sino continuar
                //Mostrar cursos disponibles para asignación
                $this->_view->asignacion = $periodo[0]['periodo'];
                $this->_view->lstAsignaciones = $this->cursosDisponiblesRetrasada($ciclo, $periodo[0]['periodo']);
                if(isset($this->_view->lstAsignaciones[0]['nombreestudiante']))
                {
                    $this->_view->lstAsignaciones[0]['nombreestudiante'] = preg_replace('/\s+/', '_',$this->_view->lstAsignaciones[0]['nombreestudiante']);
                }
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
                //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                //exit;
                //Si no hay de primera retrasada, buscar de segunda
                $periodo = $this->_post->getPeriodo($ciclo, PERIODO_ASIGNACION_2RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
                if(is_array($periodo)){
                    if(isset($periodo[0]['periodo'])){
                        $idPeriodo = $periodo[0]['periodo'];
                        $this->_view->asignacion = $periodo[0]['periodo'];
                        $this->_view->lstAsignaciones = $this->cursosDisponiblesRetrasada($ciclo);
                        $this->_view->lstAsignaciones[0]['nombreestudiante'] = preg_replace('/\s+/', '_',$this->_view->lstAsignaciones[0]['nombreestudiante']);
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
       
        /* $boleta = $this->_post->getBoletasPago($idUsuario,$idPeriodo,$idCarrera);
        if(is_array($boleta)){
                $this->boleta = isset($boleta[0]['boleta']);
            }else{
                $this->redireccionar("error/sql/" . $boleta);
                exit;
            }
            
        $this->_generaorden = new wsGeneraOrdenPago();
        $prueba = $this->_generaorden->confirmacionPago($this->boleta,200915205);
        $cadena = implode(',', $prueba);
        
        if ($this->_generaorden->parsear_resultado($cadena,"CODIGO_RESP") == "1") {
            $this->_view->existePago = 1;
        }
        else {
            $this->_view->existePago = 2;
        }*/
                
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
        $this->_view->setJs(array('listadoAsignaciones'));
        $this->_view->renderizar('listadoAsignaciones');
       
    }
    
     public function inicio() {
        //$idCarrera = $this->getInteger('slCarreras'); 
        //$idEstudiante = $this->getInteger('slEstudiantes');
        //$idUsuario = $_SESSION['usuario'];
        //$idCarrera = $_SESSION['carrera'];
               
        $this->_view->titulo = 'Gestión de retrasadas - ' . APP_TITULO;
        //$this->_view->setJs(array('listadoAsignaciones'));
        //$this->_view->setJs(array('jquery.dataTables.min'), "public");
        //$this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('inicio');
        
    }
    
    public function generarOrdenPago($carnet,$nombre,$carrera){
                        
        $nombre = str_replace("_", " ",$nombre);
        $idCarrera = $_SESSION['carrera'];
        $idPeriodo = 0;
        $multiplicadorMonto = 0;
        if($_SESSION["rol"] == ROL_ESTUDIANTE){
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
                $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
        }
        
        if ($this->getInteger('hdCiclo') && $this->getTexto('hdCursos')) {
            $listadoCursos = explode(";", $this->getTexto('hdCursos'));
            if(count($listadoCursos)){
                for($i=0;$i<count($listadoCursos);$i++){
                    if($listadoCursos[$i] <> ""){
                        $multiplicadorMonto++;
                    
                        $slcurso = explode("-", $listadoCursos[0]);
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
                                $idPeriodo = $periodo[0]['periodo'];
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
                                        $idPeriodo = $periodo[0]['periodo'];
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
                        
                        $arreglo[$i]['anio'] = $anio;
                        $arreglo[$i]['rubro'] = $rubro;
                        $arreglo[$i]['varianterubro'] = VARIANTERUBRO_RETRASADAS;
                        $arreglo[$i]['tipocurso'] = TIPOCURSO_ESCUELAHISTORIA;
                        $arreglo[$i]['curso'] = $curso;
                        $arreglo[$i]['seccion'] = $seccion;
                        $arreglo[$i]['subtotal'] = $monto;
                    }
                }
                
            }
        }
        
        
        /**Datos de prueba
            $carnet=200610816;
            $carrera=1;
            $nombre='TRINIDAD PINEDA JORGE';
            $anio=2014;
            $rubro=4;
            $varianterubro=VARIANTERUBRO_RETRASADAS;
            $tipocurso=TIPOCURSO_ESCUELAHISTORIA;
            $curso=83;
            $seccion='B';
            $extension=EXTENSION_ESCUELAHISTORIA;
         **/
        
        $unidad=UNIDAD_ESCUELAHISTORIA;
             
        $extension = $this->_post->getextensionporcarrera($idCarrera);
        if(is_array($extension)){
                $extensionobtenida = (isset($extension[0]['extension']) ? $extension[0]['extension'] : '01');
            }else{
                $this->redireccionar("error/sql/" . $extension);
                exit;
            }
    
        $nombre2 = strtoupper($nombre);
        $montoTotal=$monto*$multiplicadorMonto;
        
       
        unset($arreglo);
        for($i=0;$i<$multiplicadorMonto;$i++){
            $arreglo[$i]['anio'] = $anio;
            $arreglo[$i]['rubro'] = $rubro;
            $arreglo[$i]['varianterubro'] = VARIANTERUBRO_RETRASADAS;
            $arreglo[$i]['tipocurso'] = TIPOCURSO_ESCUELAHISTORIA;
            $arreglo[$i]['curso'] = '0'.strval($curso+$i);
            $arreglo[$i]['seccion'] = $seccion;
            $arreglo[$i]['subtotal'] = $monto;
        }
        
        $this->_generaorden = new wsGeneraOrdenPago();
        $prueba = $this->_generaorden->generaOrdenPago($carnet,$unidad,$extensionobtenida,$carrera,$nombre2,$montoTotal,$arreglo);
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
            
            $this->_post->crearPago($this->_view->orden,$this->estudiante,$idPeriodo,$idCarrera);
       
        }
        
        else if($this->_generaorden->parsear_resultado($cadena,"CODIGO_RESP") == "0") {
            print_r("No se puede generar la orden de pago porque la temporada acad&eacute;mica no est&aacute; habilitada.");
        }
    }
    
    public function cursosDisponiblesRetrasada($ciclo, $periodo){
        $lsCursosDisponibles = $this->_post->getCursosDisponiblesRetrasada($ciclo, $this->carrera, $this->estudiante, $periodo);
        if(is_array($lsCursosDisponibles)){

        }else{
            $this->redireccionar("error/sql/" . $lsCursosDisponibles);
            exit;
        }
        return $lsCursosDisponibles;
    }
    
    public function consultarOrdenPago($idPago,$carnet){
        
    }
    
    public function gestionCursoArchivo() {
        
            $idCentroUnidad = $_SESSION["centrounidad"];
            $idCarrera = $_SESSION['carrera'];
            $this->_view->carrera = $idCarrera;
            $this->_view->titulo = 'Cat&aacute;logo de cursos - ' . APP_TITULO;
            $this->_view->id = $idCentroUnidad;
            $extension= $this->_ajax->extensionCarrera($idCarrera);
            
            if(is_array($extension)){
                $this->_view->extension = $extension;
            }else{
                $this->redireccionar("error/sql/" . $extension);
                exit;
            }
            
            $lstCur = $this->_post->informacionCursoActivo($idCentroUnidad, $idCarrera);
            if(is_array($lstCur)){
                $this->_view->lstCur = $lstCur;
            }else{
                $this->redireccionar("error/sql/" . $lstCur);
                exit;
            }
            
            
            
            $this->_view->setJs(array('gestionCursoArchivo'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));

            $this->_view->renderizar('gestionCursoArchivo');
        
    }
    
    public function crearArchivo() {    
        if($this->getTexto('_texto'))
        {
            $texto_archivo = str_replace("%%", PHP_EOL, $this->getTexto('_texto'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");

            $this->_view->setCSS(array('jquery.dataTables.min'));
            //$this->_view->renderizar('crearArchivo');
            
            $filename = "TemporadaCursos.txt";
            $fileurl = DIRECCION_ARCHIVOTEMPORADAS ."TemporadaCursos.txt";
            /*
            file_put_contents($fileurl, $texto_archivo);
            echo file_get_contents($fileurl);*/
            
            $file = fopen(DIRECCION_ARCHIVOTEMPORADAS . $filename, "w+");
                fwrite($file, $texto_archivo . PHP_EOL);
                fclose($file);
           
            header("Content-disposition: attachment; filename=" . $filename);
            header("Content-type: text/plain");
            readfile($fileurl);            

        }
        else
        {
            $this->redireccionar("gestionRetrasadas/gestionCursoArchivo/");
        }        
    }
}