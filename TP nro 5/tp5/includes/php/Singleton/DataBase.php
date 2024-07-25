<?php

class DataBase
{
    private static $_singleton;
    private $_conexion;

    private function __construct(){
        $this->_conexion = new PDO('mysql:host=127.0.0.1;dbname=sgu', 'root', '');
        $this->_conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (is_null(self::$_singleton)) {
            self::$_singleton = new DataBase();
        }
        return self::$_singleton;
    }

    public function getConexion() {
        return $this->_conexion;
    }
}