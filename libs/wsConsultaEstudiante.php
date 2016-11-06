<?php
include("ParseXml.php");

class wsConsultaEstudiante{
    private $_parser;
    
    public function __construct() {
        $this->_parser = new ParseXml();
    }
    	
    function verificaEstudiante($carnet){
        
        require_once("nusoap/nusoap.php");
        $xml_consulta_usuario = ''.
            '<SOLICITUD_DATOS_RYE>'.
            '<DEPENDENCIA>DPD</DEPENDENCIA>'.
            '<LOGIN>parnaso</LOGIN>'.
            '<PWD>00:22:19:61:D4:BB</PWD>'.
            '<PIN>79040404</PIN>'.
            '<CARNET>' . $carnet . '</CARNET>'.
            '</SOLICITUD_DATOS_RYE>';
        
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno
   	
        $siif_url = 'http://rye.usac.edu.gt/WS/consultaEstudiante.php';
        $oSoapClient = new nusoap_client($siif_url, false);
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("pxml" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("VerificaEstudiante", $aParametros);
    
        if ($oSoapClient->fault) {
            //Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;VerificaEstudiante&quot;-->';
            if ($sError = $oSoapClient->getError()) {
                    $v_msg_error .= " [ Error: " . $sError . "]";
            }
            $v_resultado_invoke = 0;
            echo $v_msg_error.'<br>';
            return;
        } 
        else {
            //No existe falla en el servicio
            $sError = $oSoapClient->getError();
            if ($sError) {
                //Hubo un error
                $v_msg_error = 'Error: ' . $sError;
                $v_resultado_invoke = 0;
                echo $v_msg_error.'<br>';
                return;
            }
            else {
                $v_resultado_invoke = 1;
                $v_xml_retorno = $aRespuesta;
                //print_r($aRespuesta);
            }
        }
        return $aRespuesta;
    }
    
    function verificaInscripcion($carnet){
        
        require_once("nusoap/nusoap.php");
        $xml_consulta_usuario = ''.
            '<SOLICITUD_DATOS_RYE>'.
            '<DEPENDENCIA>DPD</DEPENDENCIA>'.
            '<LOGIN>parnaso</LOGIN>'.
            '<PWD>00:22:19:61:D4:BB</PWD>'.
            '<PIN>79040404</PIN>'.
            '<CARNET>' . $carnet . '</CARNET>'.
            '</SOLICITUD_DATOS_RYE>';
        
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno
   	
        $siif_url = 'http://rye.usac.edu.gt/WS/consultaEstudiante.php';
        $oSoapClient = new nusoap_client($siif_url, false);
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("pxml" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("VerificaInscripcion", $aParametros);
    
        if ($oSoapClient->fault) {
            //Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;VerificaInscripcion&quot;-->';
            if ($sError = $oSoapClient->getError()) {
                    $v_msg_error .= " [ Error: " . $sError . "]";
            }
            $v_resultado_invoke = 0;
            echo $v_msg_error.'<br>';
            return;
        } 
        else {
            //No existe falla en el servicio
            $sError = $oSoapClient->getError();
            if ($sError) {
                //Hubo un error
                $v_msg_error = 'Error: ' . $sError;
                $v_resultado_invoke = 0;
                echo $v_msg_error.'<br>';
                return;
            }
            else {
                $v_resultado_invoke = 1;
                $v_xml_retorno = $aRespuesta;
                //print_r($aRespuesta);
            }
        }
        return $aRespuesta;
    }
    
    function parsear_resultado($xml,$busca){
        require_once("nusoap/nusoap.php");
        $pipe="|";
        $bus="<".$busca.">";
        $bus1="</".$busca.">";
        $xml = str_replace($bus1, $pipe, $xml);
        $xml = str_replace($bus, $pipe, $xml);
        $pedazo= explode ($pipe,$xml);
        $resultado=$pedazo[1];
        return $resultado;
    }
}
?>
