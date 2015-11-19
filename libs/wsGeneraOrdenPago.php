<?php
include("ParseXml.php");

class wsGeneraOrdenPago{
    private $_parser;
    
    public function __construct() {
        $this->_parser = new ParseXml();
    }
    	
    function generaOrdenPago($carnet,$unidad,$extension,$carrera,$nombre,$monto,$anio,$rubro,$varianterubro,$tipocurso,$curso,$seccion,$subtotal){
        require_once("nusoap/nusoap.php");
        $xml_consulta_usuario = ''.
            '<GENERAR_ORDEN>'.
            '<CARNET>'.$carnet.'</CARNET> '.
            '<UNIDAD>'.$unidad.'</UNIDAD>'.
            '<EXTENSION>'.$extension.'</EXTENSION> '.
            '<CARRERA>'.$carrera.'</CARRERA> '.
            '<NOMBRE>'.$nombre.'</NOMBRE> '.
            '<MONTO>'.$monto.'</MONTO> '.
            '<DETALLE_ORDEN_PAGO> '.
            '<ANIO_TEMPORADA>'.$anio.'</ANIO_TEMPORADA> '.
            '<ID_RUBRO>'.$rubro.'</ID_RUBRO> '.
            '<ID_VARIANTE_RUBRO>'.$varianterubro.'</ID_VARIANTE_RUBRO> '.
            '<TIPO_CURSO>'.$tipocurso.'</TIPO_CURSO>'.
            '<CURSO>'.$curso.'</CURSO> '.
            '<SECCION>'.$seccion.'</SECCION> '.
            '<SUBTOTAL>'.$subtotal.'</SUBTOTAL> '.
            '</DETALLE_ORDEN_PAGO> '.
            '</GENERAR_ORDEN>';
 
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno
   	
        $siif_url = 'http://testsiif.usac.edu.gt/WSGeneracionOrdenPagoV2/WSGeneracionOrdenPagoV2SoapHttpPort?wsdl';
        $oSoapClient = new nusoap_client($siif_url, 'wsdl');
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("pxml" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("generarOrdenPago", $aParametros);
    
        if ($oSoapClient->fault) {
            //Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;generarOrdenPago&quot;-->';
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
    
    function confirmacionPago()
    {
        require_once("nusoap/nusoap.php");
        $xml_consulta_pago = ''.
                '<CONSULTA_ORDEN>'.
                '<ID_ORDEN_PAGO>4802128</ID_ORDEN_PAGO>'.
                '<ID_PERSONA>200610816</ID_PERSONA>'.
                '</CONSULTA_ORDEN>';
        
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno
   	
        $siif_url = 'http://testsiif.usac.edu.gt/WSGeneracionOrdenPagoV2/WSGeneracionOrdenPagoV2SoapHttpPort?wsdl';
        $oSoapClient = new nusoap_client($siif_url, 'wsdl');
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("pxml" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("consultaOrdenPago", $aParametros);
    
        if ($oSoapClient->fault) {
            //Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;consultaOrdenPago&quot;-->';
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
