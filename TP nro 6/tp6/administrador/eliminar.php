<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Factory/ActiveRecordFactory.php';

$idUsuario = $_GET['id'];

$oUsuario = ActiveRecordFactory::getUsuario();
$oPersona = ActiveRecordFactory::getPersona();

$oUsuario->fetch($idUsuario);
$oPersona->fetch($oUsuario->get()->idPersona);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Eliminar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp6/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/header.php' ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/menu-admin.php' ?>
	
	<form action="eliminar_usuario.php" method="post">
		
		<input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

		<div class="mensaje">

			<h3>Eliminar usuario</h3>
			<p>
				¿Realmente desea eliminar el usuario <b><?= $oUsuario->get()->nombre ?></b> perteneciente a <b><?= $oPersona->get()->apellido ?>, <?= $oPersona->get()->nombre ?></b>?
			</p>

			<div class="buttons">
				<input type="button" value="No" onclick="document.location='/tp6/administrador'">
				<input type="submit" name="bt_eliminar" value="Si">
			</div>
		</div>

	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp3-viejo/includes/php/footer.php'; ?>
</body>
</html>