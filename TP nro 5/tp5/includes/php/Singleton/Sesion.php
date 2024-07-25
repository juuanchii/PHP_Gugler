<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Registry/Registry.php';

class Sesion
{
    private static $_instancia;

    private function __construct()
    {
        session_start();
    
        if (isset($_SESSION['registry']) == false || $_SESSION['registry'] == null) {
            $_SESSION['registry'] = new Registry();
        } 
    }

    public static function getInstance()
    {
        if (is_null(self::$_instancia))
        {
            self::$_instancia = new Sesion();
        }
        
        return self::$_instancia;
        
    }

    public function getRegistry()
    {
        return $_SESSION['registry'];
    }

    public function destruir()
    {
        unset($_SESSION['registry']);
        session_destroy();
    }
}