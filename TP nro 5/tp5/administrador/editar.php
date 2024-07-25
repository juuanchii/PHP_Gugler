<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

$idUsuario = $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$pdo = DataBase::getInstance()->getConexion();

$oUsuario = ActiveRecordFactory::getUsuario();
$oUsuario->fetch($idUsuario);

$oPersona = ActiveRecordFactory::getPersona();
$oPersona->fetch($oUsuario->get()->idpersona);

$aTipoUsuario = ActiveRecordFactory::getTipoUsuario()->fetchAll();

$aTipoDocumento = ActiveRecordFactory::getTipoDocumento()->fetchAll();

$aProvincia = array('Buenos Aries', 'Sante Fe', 'Cordoba', 'Entre Ríos', 'La Pampa', 'Mendoza');

var_dump($oPersona->get()->provincia);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Editar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php' ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu-admin.php' ?>
	
	<form action="editar_usuario.php" method="post">
		
		<input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

		<fieldset>
			<legend>Informaci&oacute;n Personal:</legend>

			<ul>
				<li><label>Nombre de Usuario:</label></li>
				<li><input type="text" name="nombre_usuario" value="<?= $oUsuario->get()->nombre ?>"></li>

				<li><label>Tipo de Usuario:</label></li>
				<li>
					<select name="tipo_usuario">
						<?php foreach ( $aTipoUsuario as $oTipoUsuario ) { ?>
							<option value="<?= $oTipoUsuario->idtipousuario ?>" <?= ( $oUsuario->get()->idtipousuario == $oTipoUsuario->idtipousuario ) ? 'selected="selected"' : ''  ?>><?= $oTipoUsuario->nombre ?></option>
						<?php } ?>
					</select>
				</li>

				<li><label>Contrase&ntilde;a:</label></li>
				<li><input type="password" name="contrasenia" value="<?= $oUsuario->get()->contrasenia ?>"></li>

				<li><label>Apellido:</label></li>
				<li><input type="text" name="apellido" value="<?= $oPersona->get()->apellidos ?>"></li>

				<li><label>Nombre:</label></li>
				<li><input type="text" name="nombre" value="<?= $oPersona->get()->nombre ?>"></li>

				<li><label>Tipo de Documento:</label></li>
				<li>
					<select name="tipo_documento">
						<?php foreach ( $aTipoDocumento as $oTipoDocumento ) { ?>
							<option value="<?= $oTipoDocumento->idtipodocumento ?>" <?= ( $oPersona->get()->idtipodocumento == $oTipoDocumento->idtipodocumento ) ? 'selected="selected"' : ''  ?>><?= $oTipoDocumento->descripcion ?></option>
						<?php } ?>
					</select>
				</li>

				<li><label>N&uacute;mero de Documento:</label></li>
				<li><input type="text" name="numero_documento" value="<?= $oPersona->get()->numerodocumento ?>"></li>

				<li><label>Sexo:</label></li>
				<li>
					<label class="radio"><input type="radio" name="sexo" value="M" <?= ( $oPersona->get()->sexo == 'M' ) ? 'checked="checked"' : ''  ?>> Masculino</label>
					<label class="radio"><input type="radio" name="sexo" value="F" <?= ( $oPersona->get()->sexo == 'F' ) ? 'checked="checked"' : ''  ?>> Femenino</label>
				</li>

				<li><label>Nacionalidad:</label></li>
				<li><input type="text" name="nacionalidad" value="<?=  $oPersona->get()->nacionalidad ?>"></li>
			</ul>

		</fieldset>
		
		<fieldset>
			<legend>Informaci&oacute;n de Contacto:</legend>

			<ul>
				<li><label>Correo electr&oacute;nico:</label></li>
				<li><input type="text" name="email" value="<?= $oPersona->get()->email ?>"></li>

				<li><label>Celular:</label></li>
				<li><input type="text" name="celular" value="<?= $oPersona->get()->celular ?>"></li>

				<li><label>Provincia:</label></li>
				<li>
					<select name="provincia">
						<?php foreach ( $aProvincia as $provincia ) { ?>
							<option value="<?= $provincia ?>" <?= ( $oPersona->get()->provincia == $provincia ) ? 'selected="selected"' : ''  ?>>
								<?= $provincia ?>
							</option>
						<?php } ?>
					</select>
				</li>

				<li><label>Localidad:</label></li>
				<li><input type="text" name="localidad" value="<?= $oPersona->get()->localidad ?>"></li>
			</ul>

		</fieldset>

		<fieldset>
			<div class="buttons">
				<input type="submit" name="bt_guardar" value="Guardar">
				<input type="button" value="Cancelar" onclick="document.location='/tp5/administrador'">
			</div>
		</fieldset>

	</form>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>