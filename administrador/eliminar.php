<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

    $idUsuario = $_GET['id'];

    $query = "SELECT u.idusuario, u.nombre as usuario, p.nombre, p.apellidos
            FROM usuario u 
            INNER JOIN persona p USING(idpersona)
            WHERE idusuario = :idUsuario";

    $stmt = $conexion->prepare($query);
    $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    $objetoResult = $stmt->fetchObject();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Eliminar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp4/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/header.php' ?>
	
	<form action="eliminar_usuario.php" method="post">
		
		<input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

		<div class="mensaje">

			<h3>Eliminar usuario</h3>
			<p>
				¿Estas seguro que desea eliminar el usuario <b><?= $objetoResult->usuario ?></b> perteneciente a <b><?= $objetoResult->apellidos ?>, <?= $objetoResult->nombre ?></b>?
			</p>

			<div class="buttons">
				<input type="button" value="No" onclick="document.location='/tp4/administrador/listar.php'">
				<input type="submit" name="bt_eliminar" value="Si">
			</div>
		</div>

	</form>
	
	<div class="push"></div>
	
</div>