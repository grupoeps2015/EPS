<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais(){
        try{
            $paises = $this->_db->query("select * from spconsultageneral('pais,nombre','adm_pais');");
            return $paises->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getDeptos(){
        try{
            $departamentos = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
            return $departamentos->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getMunicipio($depto){
        try{
            $municipios = $this->_db->query("select * from spMunicipioXDepto({$depto})");
            $municipios->setFetchMode(PDO::FETCH_ASSOC);
            return $municipios->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getCentro(){
        try{
            $centros = $this->_db->query("select * from spconsultageneral('centro,nombre','adm_centro');");
            return $centros->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getUnidades(){
        try{
            $unidades = $this->_db->query("select * from spconsultageneral('unidadAcademica,nombre','adm_unidadAcademica');");
            return $unidades->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getTipoCiclo(){
        try{
            $ciclos = $this->_db->query("select * from spconsultageneral('tipociclo,nombre','cur_tipociclo');");
            return $ciclos->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getUnidadesAjax($centro){
        try{
            $unidades = $this->_db->query("select * from spUnidadxCentro({$centro})");
            $unidades->setFetchMode(PDO::FETCH_ASSOC);
            return $unidades->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getCiclosAjax($tipo){
        try{
            $ciclos = $this->_db->query("select * from spCicloxTipo({$tipo})");
            $ciclos->setFetchMode(PDO::FETCH_ASSOC);
            return $ciclos->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getCentroUnidadAjax($centro, $unidad){
        try{
            $post = $this->_db->query("select * from spCentroUnidad({$centro},{$unidad}) as id");
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getCarreras($unidad){
        try{
            $carreras = $this->_db->query("select * from spcarreraxunidad({$unidad})");
            $carreras->setFetchMode(PDO::FETCH_ASSOC);
            return $carreras->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getSecuencia($campo, $tabla){
        try{
            $secuencia = $this->_db->query("select * from spcarreraxunidad({$unidad})");
            $secuencia->setFetchMode(PDO::FETCH_ASSOC);
            return $secuencia->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getInfoCarreras($centro_unidadacademica){
        try{
            $post = $this->_db->query("select * from spinformacioncarrera({$centro_unidadacademica})");
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchAll();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
}