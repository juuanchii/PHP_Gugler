<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

$idUsuario = $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$oUsuario = ActiveRecordFactory::getUsuario();
$oPersona = ActiveRecordFactory::getPersona();

$oUsuario->fetch($idUsuario);
$oPersona->fetch($oUsuario->get()->idpersona);


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

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php' ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu-admin.php' ?>
	
	<form action="eliminar_usuario.php" method="post">
		
		<input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

		<div class="mensaje">

			<h3>Eliminar usuario</h3>
			<p>
				¿Realmente desea eliminar el usuario <b><?= $oUsuario->get()->nombre ?></b> perteneciente a <b><?= $oPersona->get()->apellidos ?>, <?= $oPersona->get()->nombre ?></b>?
			</p>

			<div class="buttons">
				<input type="button" value="No" onclick="document.location='/tp5/administrador'">
				<input type="submit" name="bt_eliminar" value="Si">
			</div>
		</div>

	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>