<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/conexion.php';

if ( isset($_POST['bt_eliminar']) == true )
{
	$pdo = conectarDB();
	$idUsuario = ( isset($_POST['idUsuario']) == true ) ? $_POST['idUsuario'] : 0;

	$pdo->beginTransaction();

	try
	{
		$query = "select idpersona from usuario where idusuario = :idUsuario";
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		$idPersona = $stmt->fetchColumn();

		$query = "delete from usuario where idusuario = :idUsuario";

		$stmt = $pdo->prepare($query);

		$stmt->bindValue(':idUsuario', $idUsuario,PDO::PARAM_INT);

		$stmt->execute();

		$query = "delete from persona where idpersona = :idPersona";

		$stmt = $pdo->prepare($query);

		$stmt->bindValue(':idPersona',$idUsuario,PDO::PARAM_INT);

		$stmt->execute();

		$pdo->commit();

		session_destroy();
		header('location: /tp5/administrador');
	}
	catch (Exception $e)
	{
		$pdo->rollBack();
	}
}

$validacionesCorrectas = true;

foreach ( $validaciones as $validacion )
{
	if ( $validacion == false )
	{
		$validacionesCorrectas = false;
		break;
	}
}

if ( $validacionesCorrectas == true )
{

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