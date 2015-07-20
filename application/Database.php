<?php

class Database extends PDO{
    
    public function __construct() {
        parent::__construct(
                'pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                array(
                    PDO::PGSQL_ATTR_DISABLE_NATIVE_PREPARED_STATEMENT=> 'SET_NAMES ' . DB_CHAR
                )
                );
    }
        
    
}
?>