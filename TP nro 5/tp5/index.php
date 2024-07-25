<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);


require_once '/Applications/XAMPP/xamppfiles/htdocs/tp5/includes/php/Singleton/DataBase.php';

class Index
{
    public function ejecutar(){
        $oDataBase = DataBase::getInstance()->getConexion();
        echo "Estamos conectados a la base de datos.";
        header('location: Paso1.php');

    }
}

$oIndex = new Index();
$oIndex->ejecutar();

