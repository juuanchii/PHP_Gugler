<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';


session_start();

$oPersona = (isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

$sql = "SELECT u.idusuario FROM usuario u";

$result = $conexion->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
	$idusuario = $row['idusuario'];
}

$editar_url = "/tp4/administrador/editar.php?id=".$idusuario;
$eliminar_url = "/tp4/administrador/eliminar.php?id=".$idusuario;

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
			<legend>Informaci&oacute;n Personal:</legend>

			<div>
				<ul>
					<li><label>ID de usuario</label></li>
					<li><?php echo $idusuario;?></li>
					<li><label>Nombre de usuario</label></li>
					<li><?php echo $oPersona->getUsuario()->getNombre();?></li>
					<li><label>Nombre y apellido</label></li>
					<li><?php echo $oPersona->getNombre(); ?> <?php echo $oPersona->getApellido(); ?></li>
					<li><label>Tipo de Documento</label></li>
					<li><?php echo $oPersona->getTipoDocumento()->getDescripcion(); ?></li>
					<li><label>N&uacute;mero de Documento</label></li>
					<li><?php echo $oPersona->getNumeroDocumento(); ?></li>
					<li><label>Email</label></li>
					<li><?php echo $oPersona->getEmail()->getValor(); ?></li>
					
				</ul>
			</div>
			</fieldset>
			<fieldset>
				<div class="buttons">
					<input type="button" value="Editar informacion" onclick="window.location.href='<?php echo $editar_url; ?>'">
					<input type="button" value="Eliminar usuario" onclick="window.location.href='<?php echo $eliminar_url; ?>'">
				</div>

			</fieldset>
	</div>

	<div class="push"></div>
	
</div>

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/footer.php'; ?>
</body>
</html>