<?php 

$idUsuario = $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/conexion.php';

$pdo = conectarDB();

$query = "select
		u.idusuario
		,u.nombre as usuario
		,p.apellido
		,p.nombre
	from usuario u
	inner join persona p using(idpersona)
	where u.idusuario = :idUsuario";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$resultado = $stmt->fetchObject();

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
				¿Realmente desea eliminar el usuario <b><?= $resultado->usuario ?></b> perteneciente a <b><?= $resultado->apellido ?>, <?= $resultado->nombre ?></b>?
			</p>

			<div class="buttons">
				<input type="button" value="No" onclick="document.location='/tp5/administrador'">
				<input type="submit" name="bt_eliminar" value="Si">
			</div>
		</div>

	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp3-viejo/includes/php/footer.php'; ?>
</body>
</html>