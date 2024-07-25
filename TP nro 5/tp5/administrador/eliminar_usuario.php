<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';


if ( isset($_POST['bt_eliminar']) == true )
{
	$idUsuario = ( isset($_POST['idUsuario']) == true ) ? $_POST['idUsuario'] : 0;
	$pdo = DataBase::getInstance()->getConexion();
	
	$oUsuario = ActiveRecordFactory::getUsuario();
	$oPersona = ActiveRecordFactory::getPersona();
	
	$oUsuario->fetch($idUsuario);
	$oPersona->fetch($oUsuario->get()->idpersona);
	
	$idPersona = $oUsuario->get()->idpersona;

	$pdo->beginTransaction();

	try
	{
		$oUsuario->delete($idUsuario);
		$oPersona->delete($idPersona);

		$pdo->commit();

		header('location: /tp5/administrador/index.php');
	}
	catch (Exception $e)
	{
		$pdo->rollBack();
		echo "Error al eliminar datos: ". $e->getMessage();
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Eliminar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu-admin.php'; ?>

	<div class="mensaje">

		<h3>Error al registrar el usuario</h3>
		<p>
			Ha ocurrido un error al intentar registrar el usuario. Por favor intentelo nuevamente.
		</p>

		<div class="buttons">
			<input type="button" value="Anterior" onclick="document.location='/tp5/administrador'">
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>