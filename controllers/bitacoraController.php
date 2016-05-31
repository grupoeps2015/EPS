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
    
    public function insertarBitacoraRetra(){
        if($this->getInteger('registro')){
            session_start();
            $bitacoraNotas = array();
            $bitacoraNotas[":usuario"] = $_SESSION["usuario"];
            $bitacoraNotas[":nombreusuario"] = $_SESSION["nombre"];
            //falta agregar una fncion para retrasada
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
    
}
