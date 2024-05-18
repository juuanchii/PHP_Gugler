<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';


session_start();

$oPersona = (isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

$sql = "SELECT u.idusuario FROM usuario u";

$result = $conexion->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
	$idusuario = $row['idusuario'];
}