<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';



$sql = "SELECT
		u.idusuario
		,u.nombre AS usuario
		,p.apellidos
		,p.nombre
		,p.numerodocumento
		,p.email
		,td.nombre AS tipodocumento
		,tu.nombre AS tipousuario
		FROM persona p
		inner join tipodocumento td using(idtipodocumento)
		inner join usuario u using(idpersona)
		inner join tipousuario tu using(idtipousuario)";

$result = $conexion->query($sql);

$rows = $result->fetchAll(PDO::FETCH_ASSOC);

// $editar_url = "/tp4/administrador/editar.php?id=".$idusuario;
// $eliminar_url = "/tp4/administrador/eliminar.php?id=".$idusuario;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Formulario de Inscripc&oacute;n</title>
	<link type="text/css" rel="stylesheet" href="/tp4/includes/css/estilos.css">
</head>
<body>


<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/header.php'; ?>

	<div class="ultimo_paso">
			<fieldset>
			<legend>Listado de Usuarios:</legend>

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
			
			<?php foreach ( $rows as $row ) { ?>
			<tr>
				<td class="text-right"><?= $row['idusuario'] ?></td>
				<td><?= $row['usuario'] ?></td>
				<td class="text-center"><?= $row["tipousuario"] ?></td>
				<td><?= $row["apellidos"] ?>, <?= $row["nombre"] ?></td>
				<td class="text-right">(<?= $row["tipodocumento"] ?>) <?= $row["numerodocumento"] ?></td>
				<td><?= $row ["email"] ?></td>
				<td class="text-center">
					<a href="/tp4/administrador/editar.php?id=<?= $row['idusuario']?>" title="Editar"><img alt="Modificar" src="/tp5/includes/img/edit.png"></a>
					<a href="/tp4/administrador/eliminar.php?id=<?= $row['idusuario'] ?>" title="Eliminar"><img alt="Eliminar" src="/tp5/includes/img/delete.png"></a>
				</td>
			</tr>
			<?php } ?>
			
		</table>
			</fieldset>
			
	</div>

	<div class="push"></div>
	
</div>

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/footer.php'; ?>
</body>
</html>