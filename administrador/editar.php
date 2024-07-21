<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$idUsuario = $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

$sql = "SELECT
		u.idusuario
		,u.nombre AS usuario
		,u.idtipousuario
		,u.contrasenia 
		,p.*
		FROM usuario u
		inner join persona p using(idpersona)
		WHERE u.idusuario = :idusuario";

$stmt = $conexion->prepare($sql);
$stmt->bindValue(':idusuario',$idUsuario, PDO::PARAM_INT);
$stmt->execute();
$resultado = $stmt->fetchObject();
var_dump($resultado);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Editar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp4/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/header.php'; ?>
	
	<form action="editar_usuario.php" method="post">
		
		<input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

		<fieldset>
			<legend>Informaci&oacute;n Personal:</legend>

			<ul>
				<li><label>Nombre de Usuario:</label></li>
				<li><input type="text" name="nombre_usuario" value="<?= $resultado->usuario ?>"></li>

				<li><label>Tipo de Usuario:</label></li>
				<li>
				<select name="tipo_usuario">
						<?php foreach ( $aTipoUsuario as $id) { ?>
							<option value="<?= $id->getIdTipoUsuario() ?>" <?= ( $resultado->idtipousuario == $id->getIdTipoUsuario() ) ? 'selected="selected"' : ''  ?>>
							<?= $id->getDescripcion() ?>
							</option>
						<?php } ?>
					</select>
				</li>
				<li><label>Contrase&ntilde;a:</label></li>
				<li><input type="password" name="contrasenia" value="<?= $resultado->contrasenia ?>"></li>

				<li><label>Apellido:</label></li>
				<li><input type="text" name="apellido" value="<?= $resultado->apellidos ?>"></li>

				<li><label>Nombre:</label></li>
				<li><input type="text" name="nombre" value="<?= $resultado->nombre ?>"></li>

				<li><label>Tipo de Documento:</label></li>
				<li>
					<select name="tipo_documento">
						<?php foreach ( $aTipoDocumento as $oTipoDocumento ) { ?>
							<option value="<?= $oTipoDocumento->getIdTipoDocumento() ?>" 
							<?= ( $resultado->idtipodocumento == $oTipoDocumento->getIdTipoDocumento() ) ? 'selected="selected"' : ''  ?>>
							<?= $oTipoDocumento->getDescripcion() ?></option>
						<?php } ?>
					</select>
				</li>
				<li><label>N&uacute;mero de Documento:</label></li>
				<li><input type="text" name="numero_documento" value="<?= $resultado->numerodocumento ?>"></li>
				<li><label>Sexo:</label></li>
				<li>
					<?php foreach ( $aSexo as $oSexo ) { ?>
						<label class="radio"><input type="radio" name="sexo" value="<?= $oSexo->getIdSexo() ?>" <?= ( $resultado->sexo == $oSexo->getIdSexo() ) ? 'checked="checked"' : ''  ?>> <?= $oSexo->getDescripcion() ?></label>
					<?php } ?>
				</li>
				<li><label>Nacionalidad:</label></li>
				<li><input type="text" name="nacionalidad" value="<?= $resultado->nacionalidad ?>"></li>
			</ul>

		</fieldset>
		
		<fieldset>
			<legend>Informaci&oacute;n de Contacto:</legend>

			<ul>
				<li><label>Correo electr&oacute;nico:</label></li>
				<li><input type="text" name="email" value="<?= $resultado->email ?>"></li>

				<li><label>Celular:</label></li>
				<li><input type="text" name="celular" value="<?= $resultado->celular ?>"></li>
				<li><label>Provincia:</label></li>
				<li>
					<select name="provincia">
						<?php foreach ( $aProvincia as $oProvincia ) { ?>
							<option value="<?= $oProvincia->getIdProvincia() ?>" <?= ( $resultado->provincia == $oProvincia->getIdProvincia() ) ? 'selected="selected"' : ''  ?>><?= $oProvincia->getDescripcion() ?></option>
						<?php } ?>
					</select>
				</li>
				<li><label>Localidad:</label></li>
				<li><input type="text" name="localidad" value="<?= $resultado->localidad ?>"></li>
			</ul>
		</fieldset>
		<fieldset>
			<div class="buttons">
				<input type="submit" name="bt_guardar" value="Guardar">
				<input type="button" value="Cancelar" onclick="document.location='/tp4/administrador/listar.php'">
			</div>
		</fieldset>
	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/footer.php'; ?>
</body>
</html>