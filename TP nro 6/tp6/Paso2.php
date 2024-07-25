<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Factory/ActiveRecordFactory.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Singleton/Sesion.php';

$oRegistry = Sesion::getInstancia()->getRegistry();

$oPersonaVO = ( $oRegistry->exists('persona') == false ) ? new PersonaVO() : $oRegistry->get('persona');
$oUsuarioVO = ( $oRegistry->exists('usuario') == false ) ? new UsuarioVO() : $oRegistry->get('usuario');

$aProvincias = array('Entre Rios', 'Sante Fe', 'Cordoba', 'Buenos Aires');

$validarTipoDocumento = false;
$validarSexo = false;
$validarContrasenia = false;

if ( isset($_POST['bt_paso1']) == true )
{
	$oUsuarioVO->idTipoUsuario = 2;
	$oUsuarioVO->nombre = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
	$oUsuarioVO->contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';
	$oPersonaVO->apellido = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
	$oPersonaVO->nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
	$oPersonaVO->idTipoDocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
	$oPersonaVO->numeroDocumento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
	$oPersonaVO->sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
	$oPersonaVO->nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';


	$oUsuario = ActiveRecordFactory::getUsuario();
	$oUsuario->set($oUsuarioVO);

	if ( $oUsuario->validarContrasenia() == true )
	{
		$validarContrasenia = true;
	}

	foreach ( ActiveRecordFactory::getTipoDocumento()->fetchAll() as $oTipoDocumento )
	{
		if ( $oPersonaVO->idTipoDocumento == $oTipoDocumento->idTipoDocumento )
		{
			$validarTipoDocumento = true;
		}
	}

	$sexos = array('M','F');
	if ( in_array($oPersonaVO->sexo, $sexos) == true )
	{
		$validarSexo = true;
	}

	$oRegistry->add('persona', $oPersonaVO);
	$oRegistry->add('usuario', $oUsuarioVO);
}
else
{
	$validarContrasenia = true;
	$validarSexo = true;
	$validarTipoDocumento = true;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Formulario de Inscripc&oacute;n</title>
	<link type="text/css" rel="stylesheet" href="/tp6/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/header.php' ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/menu.php'; ?>

	<?php if ( $validarContrasenia == false || $validarSexo == false || $validarTipoDocumento == false ) { ?>

		<div class="mensaje">
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validarContrasenia == false ) { ?>
				<li>La contraseña no es válida. Debe contener al menos 6 caracteres y al menos 1 letra y 1 número</li>
				<?php } if ( $validarTipoDocumento == false ) { ?>
				<li>El tipo de documento ingresado no se encuentra registrado</li>
				<?php } if ( $validarSexo == false ) { ?>
				<li>El sexo ingresado no se encuentra registrado</li>
				<?php } ?>
			</ul>
			<div class="buttons">
				<input type="button" value="Anterior" onclick="document.location='Paso1.php'">
			</div>
		</div>

	<?php } else { ?>

		<form action="Paso3.php" method="post">
			<fieldset>
				<legend>Informaci&oacute;n de Contacto:</legend>

				<ul>
					<li><label>Correo electr&oacute;nico:</label></li>
					<li><input type="text" name="email" value="<?= $oPersonaVO->email ?>"></li>

					<li><label>Tel&eacute;fono:</label></li>
					<li><input type="text" name="telefono" value="<?= $oPersonaVO->telefono ?>"></li>

					<li><label>Celular:</label></li>
					<li><input type="text" name="celular" value="<?= $oPersonaVO->celular ?>"></li>

					<li><label>Provincia:</label></li>
					<li>
						<select name="provincia">
							<?php foreach ($aProvincias as $provincia ) { ?>
							<option value="<?= $provincia ?>" <?= ( $oPersonaVO->provincia == $provincia ) ? 'selected="selected"' : ''  ?>><?= $provincia ?></option>
							<?php } ?>
						</select>
					</li>

					<li><label>Localidad:</label></li>
					<li><input type="text" name="localidad" value="<?= $oPersonaVO->localidad ?>"></li>
				</ul>

				<div class="buttons">
					<input type="submit" name="bt_paso2" value="Siguiente">
					<input type="button" value="Anterior" onclick="document.location='Paso1.php'">
				</div>
			</fieldset>
		</form>

	<?php } ?>

	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/footer.php'; ?>
</body>
</html>