<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/Sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$oRegistry = Sesion::getInstance()->getRegistry();

$oPersonaVO = ( $oRegistry->exists('Persona') ? $oRegistry->get('Persona') :  new PersonaVO());
$aTipoDocumento = ActiveRecordFactory::getTipoDocumento()->fetchAll();

$oUsuarioVO = ($oRegistry->exists('Usuario') ? $oRegistry->get('Usuario') : new UsuarioVO());

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
				<li><input type="text" name="nombre_usuario" value="<?= $oUsuarioVO->nombre ?>"></li>
				
				<li><label>Contrase&ntilde;a:</label></li>
				<li><input type="password" name="contrasenia" value="<?= $oUsuarioVO->contrasenia ?>"></li>
				
				<li><label>Apellido:</label></li>
				<li><input type="text" name="apellido" value="<?= $oPersonaVO->apellidos ?>"></li>
				
				<li><label>Nombre:</label></li>
				<li><input type="text" name="nombre" value="<?= $oPersonaVO->nombre ?>"></li>
				
				<li><label>Tipo de Documento:</label></li>
				<li>
					<select name="tipo_documento">
						<?php foreach ( $aTipoDocumento as $oTipoDocumento ) { ?>
						<option value="<?= $oTipoDocumento->idtipodocumento ?>"
							<?= ( $oPersonaVO->idtipodocumento == $oTipoDocumento->idtipodocumento ) ? 'selected="selected"' : ''  ?>>
							<?= $oTipoDocumento->descripcion ?>
						</option>
						<?php } ?>
					</select>
				</li>
				
				<li><label>N&uacute;mero de Documento:</label></li>
				<li><input type="text" name="numero_documento" value="<?= $oPersonaVO->numerodocumento ?>"></li>
				
				<li><label>Sexo:</label></li>
				<li>
					<label class="radio"><input type="radio" name="sexo" value="M" <?= ( $oPersonaVO->sexo == 'M' ) ? 'checked="checked"' : ''  ?>> Masculino</label>
					<label class="radio"><input type="radio" name="sexo" value="F" <?= ( $oPersonaVO->sexo == 'F' ) ? 'checked="checked"' : ''  ?>> Femenino</label>
				</li>
				
				<li><label>Nacionalidad:</label></li>
				<li><input type="text" name="nacionalidad" value="<?= $oPersonaVO->nacionalidad ?>"></li>
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