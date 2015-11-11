<?php
include("ParseXml.php");

class verifica_usuario{
    
    private $_parser;
    
    public function __construct() {
        $this->_parser = new ParseXml();
    }
    	
    function consultar_usuario($uzuario,$clave){
        require_once("nusoap/nusoap.php");
        $xml_consulta_usuario = ''.
            '<AUTENTICACION>'.
                '<TIPO_USUARIO>TRABAJADOR</TIPO_USUARIO>'.
                '<USUARIO>'.$uzuario.'</USUARIO>'.
                '<PASSWORD>'.$clave.'</PASSWORD>'.
            '</AUTENTICACION>';
		
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno
   	
        $siif_url = 'http://www2.usac.edu.gt/webservices/WSAutenticacionSIIFSoapHttpPort';
        $oSoapClient = new nusoap_client($siif_url, true);
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("pxml" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("validarAutenticacion", $aParametros);
	
        if ($oSoapClient->fault) { 
            // Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;AutenticarUsuario&quot;-->';
            if ($sError = $oSoapClient->getError()) {
                $v_msg_error .= " [ Error: " . $sError . "]";
            }
            $v_resultado_invoke = 0;
            echo $v_msg_error.'<br>';
            return;
        } 
        else { 
            // No hay fallas
            $sError = $oSoapClient->getError();
            if ($sError) {
                // Hay algun error
                    $v_msg_error = 'Error: ' . $sError;
                    $v_resultado_invoke = 0;
                    echo $v_msg_error.'<br>';
                    return;
            }
            else {
                // Sin errores
                $v_resultado_invoke = 1;
                $v_xml_retorno = $aRespuesta["result"];
            }
        }
		
        $v_xml_retorno1="<WEB>".$v_xml_retorno."</WEB>";
        $v_datos_boleta = xml2array($v_xml_retorno1);
        extract($v_datos_boleta["WEB"]);
        $t=$respuesta[0]['mensaje']['value'] ;
        $busca1="CODIGO_RESP";
        $esta=parsear_resultado($v_xml_retorno1,$busca1);
        $busca1="DESCRIPCION";
        $descri=parsear_resultado($v_xml_retorno1,$busca1); 
        return $esta.$descri;
    }

    function consultar_estudiante($uzuario,$clave){
        require_once("nusoap/nusoap.php");
        $xml_consulta_usuario = "".
                "<autenticar>".
                    "<dependencia>DPD</dependencia>".
                    "<usuario>autenticacion</usuario>".
                    "<clave>$3GuR!d@d</clave>".
                    "<carnet>".$uzuario."</carnet>".
                    "<pin>".$clave."</pin>".
                "</autenticar>";
        $v_msg_error='';
        $v_xml_retorno='';
        $v_resultado_invoke='';	
        // 0 indica que ha ocurrido algun error, el error quedara en $v_msg_error
        // 1 indica que hubo exito en la transaccion, el xml resultante esta en $v_xml_retorno

        $rye_url = 'http://registro.usac.edu.gt/WS/autenticacionRyE.php?wsdl';
        $oSoapClient = new nusoap_client($rye_url, 'wsdl');
        if ($sError = $oSoapClient->getError()) {
            $v_msg_error = "No se pudo realizar la operacion [" . $sError . "]";
            $v_resultado_invoke = 0;
            return;
        }
        
        $aParametros = array("xmlDatos" => $xml_consulta_usuario);
        $aRespuesta = $oSoapClient->call("autenticarse", $aParametros);
    
        if ($oSoapClient->fault) {
            //Existe alguna falla en el servicio
            $v_msg_error = 'Existe una falla en el servicio &quot;AutenticarUsuario&quot;-->';
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
            }
        }
        
        $v_xml_retorno1="<WEB>".$v_xml_retorno."</WEB>";
        $v_datos_boleta = $this->_parser->xml2array($v_xml_retorno1);
        extract($v_datos_boleta["WEB"]);
        $busca1="status";
        $esta=$this->parsear_resultado($v_xml_retorno1,$busca1);
        if ($esta==1) {
            $busca1="nombre";
                    $nombre=$this->parsear_resultado($v_xml_retorno1,$busca1); 
            $busca1="carnet";
                    $carnet=$this->parsear_resultado($v_xml_retorno1,$busca1);
            $busca1="codigo_unidad_academica";
                    $codua=$this->parsear_resultado($v_xml_retorno1,$busca1);
            $busca1="nombre_unidad_academica";
                    $ua=$this->parsear_resultado($v_xml_retorno1,$busca1);
            $busca1="codigo_extension";
                    $ext=$this->parsear_resultado($v_xml_retorno1,$busca1);
            $busca1="codigo_carrera";
                    $car=$this->parsear_resultado($v_xml_retorno1,$busca1);
            $esta = 'Estado: ' . $esta . '<br/>';
            $esta .= 'Nombre: ' . $nombre . '<br/>';
            $esta .= 'Carnet: ' . $carnet . '<br/>';
            $esta .= 'Codigo Unidad Academica: ' . $codua . '<br/>';
            $esta .= 'Nombre Unidad Academica: ' . $ua . '<br/>';
            $esta .= 'Codigo Extencion: ' . $ext . '<br/>';
            $esta .= 'Codigo Carrera: ' . $car;
        } else {
                $esta=$esta.'|Usuario o contrase&ntilde;a no habilitado';
        }
        return $esta;
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
