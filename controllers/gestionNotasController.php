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
        $rolValidoGestionActividades = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONACTIVIDADES);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];        
        $this->_view->permisoGestionActividades = $rolValidoGestionActividades[0]["valido"];
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
    
    public function cursosXDocente($idUsuario, $UnidadCentro, $Tipo = 0){
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        $this->_view->tipo = $Tipo;
        
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
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
        
        //if(!isset($_SESSION["carrera"])){
            //$_SESSION["carrera"]=1;
        //}
        $notaAprobado = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAPROMOCION, -1, $_SESSION["centrounidad"]);
        $this->_view->notaAprobado = $notaAprobado[0]['valorparametro'];
        
        $zonaMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTATOTALZONA, -1, $_SESSION["centrounidad"]);
        $this->_view->zonaTotal = $zonaMaxima[0]['valorparametro'];
        
        $notaFinalMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAEXAMENFINAL, -1, $_SESSION["centrounidad"]);
        $this->_view->finalTotal = $notaFinalMaxima[0]['valorparametro'];
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('cursosXDocente'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setJs(array('jquery.csv'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('cursosXDocente','gestionNotas');
    }
    
    public function getEstadoCicloNotas(){
        $datos = new stdClass();
        $datos->estado = 0;
        if($this->getInteger('cicloaver')){
            $arr = $this->_notas->getEstadoCicloNotas($this->getInteger('cicloaver'),PERIODO_INGRESO_NOTAS,$this->getInteger('tipoAs'),$this->getInteger('centrounidad'));
            if(is_array($arr)){
                if(isset($arr[0]['periodo'])){
                    $datos->estado = 1;
                }else{
                    $datos->estado = -3;
                }
            }else{
                $datos->estado = -2;
            }
        }
        echo json_encode($datos);
    }
    
    public function getEstadoCicloRetra(){
        $datos = new stdClass();
        $datos->estado = 0;
        if($this->getInteger('retra') == 1){
            $arr = $this->_notas->getEstadoCicloNotas($this->getInteger('cicloaver'),PERIODO_INGRESO_1RETRASADA,$this->getInteger('tipoAs'),$this->getInteger('centrounidad'));
        }else if($this->getInteger('retra') == 2){
            $arr = $this->_notas->getEstadoCicloNotas($this->getInteger('cicloaver'),PERIODO_INGRESO_2RETRASADA,$this->getInteger('tipoAs'),$this->getInteger('centrounidad'));
        }
        if(isset($arr) && is_array($arr)){
            if(isset($arr[0]['periodo'])){
                $datos->estado = 1;
            }else{
                $datos->estado = -3;
            }
        }else{
            $datos->estado = -2;
        }
        echo json_encode($datos);
    }
    
    public function actividades($idUsuario, $UnidadCentro){
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONACTIVIDADES);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        
        if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
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
        
        $lsTipoActividad = $this->_notas->getTipoActividad();
        if(is_array($lsTipoActividad)){
            $this->_view->lsTipoActividad = $lsTipoActividad;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoActividad);
            exit;
        }
        
        //if(!isset($_SESSION["carrera"])){
            //$_SESSION["carrera"]=1;
        //}
        
        $zonaMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTATOTALZONA, -1, $_SESSION["centrounidad"]);
        $this->_view->zonaTotal = $zonaMaxima[0]['valorparametro'];
        
        $notaFinalMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAEXAMENFINAL, -1, $_SESSION["centrounidad"]);
        $this->_view->finalTotal = $notaFinalMaxima[0]['valorparametro'];
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('jquery.validate'),"public");
        $this->_view->setJs(array('jquery.confirm'),"public");
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
        
    }
    
    public function guardarNota(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $zona = floatval($this->getTexto('zonaN'));
        $final = floatval($this->getTexto('finalN'));
        if($this->getInteger('idAs')){
            $nota=$this->_notas->guardarNota($zona,$final,$this->getInteger('idAs'));
            if(is_array($nota)){
                $respuesta->total = $zona + $final;
                $respuesta->mensaje = "Procesado: Las notas seran guardadas con valores enteros";
            }else{
                $respuesta->mensaje = "Ocurrio un error inesperado, notifique a control academico";
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function guardarRetrasada(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $zona = floatval($this->getTexto('zonaN'));
        $final = floatval($this->getTexto('finalN'));
        if($this->getInteger('idAs')){
            $nota=$this->_notas->guardarRetra($final,$this->getInteger('idAs'));
            if(is_array($nota)){
                $respuesta->total = $zona + $final;
                $respuesta->mensaje = "Procesado: Las notas seran guardadas con valores enteros";
            }else{
                $respuesta->mensaje = "Ocurrio un error inesperado, notifique a control academico";
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function notasCSV(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $respuesta->info = array();
        $fileName=$_FILES['csvFile']['name'];
        $fileExt = explode(".",$fileName);
        if(strtolower(end($fileExt)) == "csv"){
            $fileName=$_FILES['csvFile']['tmp_name'];
            $handle = fopen($fileName, "r");
            $i = 0;
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $carnet = trim($data[0]);
                $zona = trim($data[1]);
                $final = trim($data[2]);
                $respuesta->info[$i]['carnet'] = $carnet;
                $respuesta->info[$i]['zona'] =  $zona;
                $respuesta->info[$i]['final'] = $final;
                $i=$i+1;
            }
            fclose($handle);
            $respuesta->mensaje = "Todos los registros han sido cargados, verifique que la informacion sea la correcta y guarde los cambios";
        }else{
            $respuesta->mensaje = "La información no se pudo leer debido a que solo se admiten archivos .csv";
        }
        echo json_encode($respuesta);
    }
    
    public function notasCSV2($acts){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $respuesta->info = array();
        $fileName=$_FILES['csvFile']['name'];
        $fileExt = explode(".",$fileName);
        if(strtolower(end($fileExt)) == "csv"){
            $fileName=$_FILES['csvFile']['tmp_name'];
            $handle = fopen($fileName, "r");
            $i = 0;
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $contador = 1;
                $carnet = trim($data[0]);
                for($c = 1; $c <= intval($acts); $c++){
                    $respuesta->info[$i][$c] = trim($data[$c]);
                    $contador = $c;
                }
                $zona = trim($data[$contador+1]);
                $final = trim($data[$contador+2]);
                $respuesta->info[$i]['carnet'] = $carnet;
                $respuesta->info[$i]['zona'] =  $zona;
                $respuesta->info[$i]['final'] = $final;
                $i=$i+1;
            }
            fclose($handle);
            $respuesta->mensaje = "Todos los registros han sido cargados, verifique que la informacion sea la correcta, especialmente respecto a la nota de actividades y guarde los cambios.";
        }else{
            $respuesta->mensaje = "La información no se pudo leer debido a que solo se admiten archivos .csv";
        }
        echo json_encode($respuesta);
    }
    
    public function getEstadoCicloActividades(){
//        if($this->getInteger('cicloaver')){
//            echo json_encode($this->_notas->estadoCicloActividades($this->getInteger('cicloaver')));
//        }
        $datos = new stdClass();
        $datos->estado = 0;
        if($this->getInteger('cicloaver')){
            $arr = $this->_notas->getEstadoCicloNotas($this->getInteger('cicloaver'),PERIODO_INGRESO_ACTIVIDADES,$this->getInteger('tipoAs'),$this->getInteger('centrounidad'));
            if(is_array($arr)){
                if(isset($arr[0]['periodo'])){
                    $datos->estado = 1;
                }else{
                    $datos->estado = -3;
                }
            }else{
                $datos->estado = -2;
            }
        }
        echo json_encode($datos);
    }
    
    public function guardarActividad(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $respuesta->id = 0;
        
        $idPadre = $this->getInteger('idPadre');
        $idTipo = $this->getInteger('idTipo');
        $txtNombre = $this->getTexto('txtNombre');
        $valor = floatval($this->getTexto('flValor'));
        $desc = $this->getTexto('txtDesc');
        
        if($idPadre > 0 && $idTipo > 0 && $valor > 0){
            $act = $this->_notas->guardarActividad($idPadre,$idTipo,$txtNombre,$valor,$desc);
            if(is_array($act)){
                $respuesta->mensaje = "Procesado: Actividad " . $txtNombre . " guardadas exitosamente";
                $respuesta->id = $act[0][0];
            }else{
                $respuesta->mensaje = "error creando: " . $txtNombre;
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function setActividadAsignado(){
        if($this->getInteger('asignado') && $this->getInteger('actividad')){
            $this->_notas->asociarActividad($this->getInteger('asignado'),$this->getInteger('actividad'));
        }
    }
    
    public function contarActividades(){
        $respuesta = new stdClass();
        $respuesta->total = 0;
        if($this->getInteger('trama')){
            $act = $this->_notas->contarActividades($this->getInteger('trama'));
            $respuesta->total = $act[0][0];
        }else{
            $respuesta->total = -2;
        }
        echo json_encode($respuesta);
    }
    
    public function aprobarNota(){
        $respuesta = new stdClass();
        $respuesta->aprobado = 0;
        if($this->getInteger('idAs')){
            $this->_notas->aprobarNota($this->getInteger('idAs'));
            $respuesta->aprobado = 1;
        }
        echo json_encode($respuesta);
    }
    
    public function aprobarRetra(){
        $respuesta = new stdClass();
        $respuesta->aprobado = 0;
        $respuesta->msg = "";
        if($this->getInteger('idAs')){
            $this->_notas->aprobarRetra($this->getInteger('idAs'));
            $respuesta->aprobado = 1;
            $respuesta->msg = "aprobo sin problema";
        }
        echo json_encode($respuesta);
    }
    
    public function reprobarNota(){
        $respuesta = new stdClass();
        $respuesta->reprobado = 0;
        if($this->getInteger('idAs')){
            $this->_notas->reprobarNota($this->getInteger('idAs'));
            $respuesta->reprobado = 1;
        }
        echo json_encode($respuesta);
    }
    
    public function reprobarRetra(){
        $respuesta = new stdClass();
        $respuesta->reprobado = 0;
        if($this->getInteger('idAs')){
            $this->_notas->reprobarRetra($this->getInteger('idAs'));
            $respuesta->reprobado = 1;
        }
        echo json_encode($respuesta);
    }
    
    public function listarActividades(){
        if($this->getInteger('asig')){
            $respuesta = $this->_notas->listarActividades($this->getInteger('asig'));
            echo json_encode($respuesta);
        }
    }
    
    public function getListaAsignados(){
        if($this->getInteger('trama') && $this->getInteger('ciclo')){
            echo json_encode($this->_notas->getListaAsignados($this->getInteger('trama'),$this->getInteger('ciclo')));
        }
    }
    
    public function getListaAsignadosRetra(){
        if($this->getInteger('trama') && $this->getInteger('ciclo') && $this->getInteger('retra')){
            echo json_encode($this->_notas->getListaAsignadosRetra($this->getInteger('trama'),$this->getInteger('ciclo'),$this->getInteger('retra')));
        }
    }
    
    public function getActividadesPadre(){
        $respuesta = $this->_notas->getActividadesPadre();
        echo json_encode($respuesta);
    }
    
    public function actualizarActividad(){
        $respuesta = new stdClass();
        $respuesta->actualizado = "";
        if($this->getInteger('id') && $this->getInteger('idTipo')){
            $this->_notas->actualizarActividad($this->getInteger('id'),$this->getInteger('idTipo'),$this->getTexto('flValor'),$this->getTexto('txtNombre'));
            $respuesta->actualizado = $this->getTexto('txtNombre') . " Actualizado";
        }
        echo json_encode($respuesta);
    }
    
    public function getNotaActividad(){
        if($this->getInteger('id')){
            $respuesta = $this->_notas->getNotaActividad($this->getInteger('id'));
            echo json_encode($respuesta);
        }
    }
    
    public function setNotaActividad(){
        $respuesta = new stdClass();
        $respuesta->actualizado = "";
        if($this->getInteger('idAsg') && $this->getInteger('idAct')){
            $this->_notas->setNotaActividad($this->getInteger('idAsg'),
                                            $this->getInteger('idAct'),
                                            $this->getTexto('flValor'));
        }
        echo json_encode($respuesta);
    }

    public function imprimirActa($parametros){
        $fecha = getdate();
        list($cat,$zona, $final, $promocion, $usr, $ciclo, $sec, $cur) = split('RmGm', $parametros);
        $this->getLibrary('fpdf');
        $trama = $this->_ajax->getIdTrama($cat,$ciclo,$sec,$cur);
        
        $this->_pdf = new FPDF('P', 'mm', 'legal');
        $this->_pdf->AddPage();
        $this->_pdf->SetFont('Times','',8);
        $this->_pdf->Ln(35);
        
        $nomSec = $this->_notas->getNombreSeccion($sec);
        $nomCiclo = $this->_notas->getCategoriaCiclo($ciclo);
        $nomCurso = $this->_notas->getNombreCursoImpartido($cur);
        //Datos generales del acta
        $this->_pdf->SetLeftMargin(30);
        $this->_pdf->Cell(120,7,'Carrera:          <query para buscar carrera>');
        $this->_pdf->Cell(40,7,'Ciclo:       <query para buscar ciclo>');
        $this->_pdf->Ln(4);
        $this->_pdf->Cell(120,7,'Zona: '.$zona);
        $this->_pdf->Cell(40,7,'Seccion: '.$nomSec[0]['nombre']);
        $this->_pdf->Ln(4);
        $this->_pdf->Cell(60,7,'Promocion: '.$promocion);
        $this->_pdf->Cell(60,7,'Examen Final: '.$final);
        $this->_pdf->Cell(40,7,'Categoria:  '.$this->numCiclo($nomCiclo[0]['numerociclo']).$nomCiclo[0]['nombre']);
        $this->_pdf->Ln(4);
        $this->_pdf->Cell(120,7,'Curso: '.$nomCurso[0]['nombre']);
        $this->_pdf->Cell(40,7,$fecha["mday"]." de ".$this->nombreMes($fecha["mon"])." de ".$fecha["year"]);
        $this->_pdf->SetLeftMargin(10);
        $this->_pdf->Ln(5);
        
        //Encabezados de la tabla
        $this->_pdf->Cell(5,7,'No.',1,0,"C");
        $this->_pdf->Cell(30,7,'Carnet',1,0,"C");
        $this->_pdf->Cell(80,7,'Nombre',1,0,"C");
        $this->_pdf->Cell(8,7,'Ex.',1,0,"C");
        $this->_pdf->Cell(8,7,'Ca.',1,0,"C");
        $this->_pdf->Cell(10,7,'Zona',1,0,"C");
        $this->_pdf->Cell(14,7,'Ex.Final',1,0,"C");
        $this->_pdf->Cell(10,7,'Nota',1,0,"C");
        $this->_pdf->Cell(30,7,'Observaciones',1,0,"C");
        
        //cuerpo de la tabla
        $this->_pdf->Ln(10);
        $datos = $this->_notas->getListaAsignados($trama[0]['spidtrama'],$ciclo);
        for($i=0;$i<count($datos);$i++){
            $this->_pdf->Cell(7,3,$i+1);
            $this->_pdf->Cell(30,3,$datos[$i]['carnet']);
            $this->_pdf->Cell(80,3,$datos[$i]['nombre']);
            $this->_pdf->Cell(8,3,"01");
            $this->_pdf->Cell(8,3,"01");
            $this->_pdf->Cell(10,3,$datos[$i]['zona'].".00");
            $this->_pdf->Cell(14,3,$datos[$i]['final'].".00");
            $this->_pdf->Cell(10,3,$datos[$i]['total'].".00");
            if(intval($datos[$i]['zona'])+$final < $promocion){
                $this->_pdf->Cell(30,3,"Sin derecho a examen",0,1);
            }elseif(intval($datos[$i]['final']) == 0){
                $this->_pdf->Cell(30,3,"No se presento",0,1);
            }elseif(intval($datos[$i]['total']) <  intval($promocion)){
                $this->_pdf->Cell(30,3,"Reprobado",0,1);
            }elseif(intval($datos[$i]['total']) >= intval($promocion)){
                $this->_pdf->Cell(30,3,"Aprobado",0,1);
            }else{
                $this->_pdf->Cell(30,3,"----------------",0,1);
            }
            
        }
        
        //Pie de pagina con firmas
        $datosCat = $this->_notas->getDocenteEspecifico($usr);
        $this->_pdf->SetY(-50);
        $this->_pdf->Cell(100,7,'________________________________________________',0,0,"C");
        $this->_pdf->Cell(100,7,'________________________________________________',0,0,"C");
        $this->_pdf->Ln(4);
        $this->_pdf->Cell(100,7,'Licda. Olga Perez Molina',0,0,"C");
        $this->_pdf->Cell(100,7,$datosCat[0]['nombrecompleto'],0,0,"C");
        $this->_pdf->Ln(4);
        $this->_pdf->Cell(100,7,'Secretaria Academica Trama',0,0,"C");
        $this->_pdf->Cell(100,7,'Catedratico',0,0,"C");
        
        //Imprimir PDF en navegador
        $this->_pdf->Output();
    }
    
    private function nombreMes($id){
        switch ($id){
            case 1: return "enero";
            case 2: return "febrero";
            case 3: return "marzo";
            case 4: return "abril";
            case 5: return "mayo";
            case 6: return "junio";
            case 7: return "julio";
            case 8: return "agosto";
            case 9: return "septiembre";
            case 10: return "octubre";
            case 11: return "noviembre";
            case 12: return "diciembre";
        }
        
    }

    private function numCiclo($num){
        switch($num){
            case 1: return "1r. ";
            case 2: return "2do. ";
            case 3: return "3ro. ";
            case 4: return "4to. ";
            case 5: return "5to. ";
            case 6: return "6to. ";
        }
    }
}
 