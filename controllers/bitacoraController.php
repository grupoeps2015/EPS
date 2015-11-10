<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bitacoraController
 *
 * @author Rickardo
 */
class bitacoraController extends Controller{
    
    private $_bitacora;
    
    public function __construct() {
        $this->_bitacora = $this->loadModel('bitacora');
    }
    
    public function index(){
        
    }
    
    public function insertarBitacoraNota(){
        if($this->getInteger('registro')){
            session_start();
            $bitacoraNotas = array();
            $bitacoraNotas[":usuario"] = $_SESSION["usuario"];
            $bitacoraNotas[":nombreusuario"] = $_SESSION["nombre"];
            $bitacoraNotas[":funcion"] = CONS_FUNC_CUR_MODIFICARNOTA;
            $bitacoraNotas[":ip"] = $this->get_ip_address();
            $bitacoraNotas[":registro"] = $this->getInteger('registro');
            $insert = $this->_bitacora->insertarBitacoraNota($bitacoraNotas);
            if(!is_array($insert)){
                $this->redireccionar("error/sql/" . $insert);
                exit;
            }
            echo true;
        }else{
            echo false;
        }
    }
    
    private function get_ip_address() {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (validate_ip($ip))
                        return $ip;
                }
            } else {
                if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];

        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }
}
