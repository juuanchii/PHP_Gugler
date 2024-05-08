<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

session_start();
$oPersona = ( isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

echo "hola";
var_dump($oPersona);

