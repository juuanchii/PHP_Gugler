<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';

session_start();

$oPersona = ( isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Formulario de Inscripc&oacute;n</title>
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu.php'; ?>

	<form action="Paso2.php" method="post">
		<fieldset>
			<legend>Informaci&oacute;n Personal:</legend>
			
			<ul>
				<li><label>Nombre de Usuario:</label></li>
				<li><input type="text" name="nombre_usuario" value="<?= $oPersona->getUsuario()->getNombre() ?>"></li>
				
				<li><label>Contrase&ntilde;a:</label></li>
				<li><input type="password" name="contrasenia" value="<?= $oPersona->getUsuario()->getContrasenia() ?>"></li>
				
				<li><label>Apellido:</label></li>
				<li><input type="text" name="apellido" value="<?= $oPersona->getApellido() ?>"></li>
				
				<li><label>Nombre:</label></li>
				<li><input type="text" name="nombre" value="<?= $oPersona->getNombre() ?>"></li>
				
				<li><label>Tipo de Documento:</label></li>
				<li>
					<select name="tipo_documento">
						<?php foreach ( $aTipoDocumento as $oTipoDocumento ) { ?>
						<option value="<?= $oTipoDocumento->getIdTipoDocumento() ?>" <?= ( $oPersona->getTipoDocumento()->getIdTipoDocumento() == $oTipoDocumento->getIdTipoDocumento() ) ? 'selected="selected"' : ''  ?>><?= $oTipoDocumento->getDescripcion() ?></option>
						<?php } ?>
					</select>
				</li>
				
				<li><label>N&uacute;mero de Documento:</label></li>
				<li><input type="text" name="numero_documento" value="<?= $oPersona->getNumeroDocumento() ?>"></li>
				
				<li><label>Sexo:</label></li>
				<li>
					<?php foreach ( $aSexo as $oSexo ) { ?>
					<label class="radio"><input type="radio" name="sexo" value="<?= $oSexo->getIdSexo() ?>" <?= ( $oPersona->getSexo()->getIdSexo() == $oSexo->getIdSexo() ) ? 'checked="checked"' : ''  ?>> <?= $oSexo->getDescripcion() ?></label>
					<?php } ?>
				</li>
				
				<li><label>Nacionalidad:</label></li>
				<li><input type="text" name="nacionalidad" value="<?= $oPersona->getNacionalidad() ?>"></li>
			</ul>
			
			<div class="buttons">
				<input type="submit" name="bt_paso1" value="Siguiente">
			</div>
		</fieldset>
	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>