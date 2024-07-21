<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';

session_start();

$oPersona = ( isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

$validarTipoDocumento = false;
$validarSexo = false;
$validarContrasenia = false;

if ( isset($_POST['bt_paso1']) == true )
{
	$usuario = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
	$contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';
	$apellido = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
	$nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
	$tipoDocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
	$documento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
	$sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
	$nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';

	$oUsuario = new Usuario($usuario, $contrasenia);

	if ( $oUsuario->validarContrasenia() == true )
	{
		$validarContrasenia = true;
		$oPersona->setUsuario($oUsuario);
	}

	foreach ( $aTipoDocumento as $oTipoDocumento )
	{
		if ( $tipoDocumento == $oTipoDocumento->getIdTipoDocumento() )
		{
			$oPersona->setTipoDocumento($oTipoDocumento);
			$validarTipoDocumento = true;
		}
	}

	foreach ( $aSexo as $oSexo )
	{
		if ( $sexo == $oSexo->getIdSexo() )
		{
			$oPersona->setSexo($oSexo);
			$validarSexo = true;
		}
	}

	$oPersona->setApellido($apellido);
	$oPersona->setNombre($nombre);
	$oPersona->setNumeroDocumento($documento);
	$oPersona->setNacionalidad($nacionalidad);
	$_SESSION['Persona'] = $oPersona;
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
	<link type="text/css" rel="stylesheet" href="/tp5/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php' ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu.php'; ?>

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
					<li><input type="text" name="email" value="<?= $oPersona->getEmail()->getValor() ?>"></li>

					<li><label>Tel&eacute;fono:</label></li>
					<li><input type="text" name="telefono" value="<?= $oPersona->getTelefono()->getValor() ?>"></li>

					<li><label>Celular:</label></li>
					<li><input type="text" name="celular" value="<?= $oPersona->getCelular()->getValor() ?>"></li>

					<li><label>Domicilio:</label></li>
					<li><input type="text" name="domicilio" value="<?= $oPersona->getDomicilio() ?>"></li>

					<li><label>Provincia:</label></li>
					<li>
						<select name="provincia">
							<?php foreach ( $aProvincia as $oProvincia ) { ?>
							<option value="<?= $oProvincia->getIdProvincia() ?>" <?= ( $oPersona->getProvincia()->getIdProvincia() == $oProvincia->getIdProvincia() ) ? 'selected="selected"' : ''  ?>><?= $oProvincia->getDescripcion() ?></option>
							<?php } ?>
						</select>
					</li>

					<li><label>Localidad:</label></li>
					<li><input type="text" name="localidad" value="<?= $oPersona->getLocalidad() ?>"></li>
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

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>