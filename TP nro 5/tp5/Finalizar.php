<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/Sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$oSesion = Sesion::getInstance();
$oRegistry = $oSesion->getRegistry();

$pdo = DataBase::getInstance()->getConexion();

$oPersonaVO = ( $oRegistry->exists('Persona') == false ) ? new PersonaVO() : $oRegistry->get('Persona');
$oUsuarioVO = ( $oRegistry->exists('Usuario') == false ) ? new UsuarioVO() : $oRegistry->get('Usuario');

$oPersona = ActiveRecordFactory::getPersona();
$oUsuario = ActiveRecordFactory::getUsuario();
try
{
	$pdo->beginTransaction();
	
	$oPersona->set($oPersonaVO);
	$oUsuario->set($oUsuarioVO);

	$oPersona->insert();

	$oUsuario->get()->idpersona = $oPersona->get()->idpersona;

	$oUsuario->insert();

	$pdo->commit();

	$oSesion->destruir();
	header('location: index.php');
}
catch (Exception $e)
{
	$pdo->rollBack();
	echo "Error al insertar datos: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Formulario de Inscripc&oacute;n</title>
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu.php'; ?>

	<div class="mensaje">
		<h3>Error al registrar el usuario</h3>
		<p>
			Ha ocurrido un error al intentar registrar el usuario. Por favor intentelo nuevamente.
		</p>
		<div class="buttons">
			<input type="button" value="Anterior" onclick="document.location='Paso3.php'">
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>