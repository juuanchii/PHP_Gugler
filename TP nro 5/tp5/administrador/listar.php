<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';

$pdo = DataBase::getInstance()->getConexion();

$query = "select
		u.idusuario
		,u.nombre as usuario
		,p.apellidos
		,p.nombre
		,p.numerodocumento
		,p.email
		,td.nombre as tipodocumento
		,tu.nombre as tipousuario
	from persona p
	inner join tipodocumento td using(idtipodocumento)
	inner join usuario u using(idpersona)
	inner join tipousuario tu using(idtipousuario)";

$stmt = $pdo->query($query);
$filas = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Lista de Usuarios</title>
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu-admin.php'; ?>

	<fieldset>
		<legend>Lista de Usuarios</legend>
		
		<table>
			
			<tr>
				<th>ID</th>
				<th>USUARIO</th>
				<th>TIPO</th>
				<th>APELLIDO Y NOMBRE</th>
				<th>DOC</th>
				<th>EMAIL</th>
				<th>ACCIONES</th>
			</tr>
			
			<?php foreach ( $filas as $fila ) { ?>
			<tr>
				<td class="text-right"><?= $fila->idusuario ?></td>
				<td><?= $fila->usuario ?></td>
				<td class="text-center"><?= $fila->tipousuario ?></td>
				<td><?= $fila->apellidos ?>, <?= $fila->nombre ?></td>
				<td class="text-right">(<?= $fila->tipodocumento ?>) <?= $fila->numerodocumento ?></td>
				<td><?= $fila->email ?></td>
				<td class="text-center">
					<a href="/tp5/administrador/editar.php?id=<?= $fila->idusuario ?>" title="Editar"><img alt="Modificar" src="/tp5/includes/img/edit.png"></a>
					<a href="/tp5/administrador/eliminar.php?id=<?= $fila->idusuario ?>" title="Eliminar"><img alt="Eliminar" src="/tp5/includes/img/delete.png"></a>
				</td>
			</tr>
			<?php } ?>
			
		</table>
		
	</fieldset>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>