<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';

session_start();

$oPersona = ( isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

$validarProvincia = false;
$validarEmail = false;
$validarTelefono = false;
$validarCelular = false;

if ( isset($_POST['bt_paso2']) == true )
{
	$email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
	$telefono = ( isset($_POST['telefono']) == true ) ? $_POST['telefono'] : '';
	$celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
	$domicilio = ( isset($_POST['domicilio']) == true ) ? $_POST['domicilio'] : '';
	$provincia = ( isset($_POST['provincia']) == true ) ? $_POST['provincia'] : '';
	$localidad = ( isset($_POST['localidad']) == true ) ? $_POST['localidad'] : '';

	foreach ( $aProvincia as $oProvincia )
	{
		if ( $oProvincia->getIdProvincia() == $provincia )
		{
			$validarProvincia = true;
			$oPersona->setProvincia($oProvincia);
		}
	}

	$oEmail = new Contacto(Contacto::TIPO_EMAIL, $email);
	if ( $oEmail->validar() == true )
	{
		$validarEmail = true;
		$oPersona->setEmail($oEmail);
	}

	$oTelefono = new Contacto(Contacto::TIPO_TELEFONO, $telefono);
	if ( $oTelefono->validar() == true )
	{
		$validarTelefono = true;
		$oPersona->setTelefono($oTelefono);
	}

	$oCelular = new Contacto(Contacto::TIPO_TELEFONO, $celular);
	if ( $oCelular->validar() == true )
	{
		$validarCelular = true;
		$oPersona->setCelular($oCelular);
	}

	$oPersona->setDomicilio($domicilio);
	$oPersona->setLocalidad($localidad);
	$_SESSION['Persona'] = $oPersona;
}
else
{
	$validarProvincia = true;
	$validarEmail = true;
	$validarTelefono = true;
	$validarCelular = true;
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

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu.php'; ?>

	<?php if ( $validarProvincia == false || $validarEmail == false || $validarTelefono == false || $validarCelular == false ) { ?>

		<div class="mensaje">
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validarProvincia == false ) { ?>
					<li>La provincia ingresada no se encuentra registrada</li>
				<?php } if ( $validarEmail == false ) { ?>
					<li>El correo electrónico no es válido. Debe contener un símbolo "@"</li>
				<?php } if ( $validarTelefono == false ) { ?>
					<li>El teléfono no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } if ( $validarCelular == false ) { ?>
					<li>El celular no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } ?>
			</ul>
			<div class="buttons">
				<input type="button" value="Anterior" onclick="document.location='Paso2.php'">
			</div>
		</div>

	<?php } else { ?>

		<h2>Informaci&oacute;n de alta de usuario</h2>

		<div class="ultimo_paso">

			<fieldset>
				<legend>Informaci&oacute;n Personal:</legend>

				<ul>
					<li><label>Nombre de Usuario:</label></li>
					<li><?= $oPersona->getUsuario()->getNombre() ?><br></li>

					<li><label>Contrase&ntilde;a:</label></li>
					<li><?= $oPersona->getUsuario()->getContraseniaEnmascadara() ?><br></li>

					<li><label>Apellido:</label></li>
					<li><?= $oPersona->getApellido() ?></li>

					<li><label>Nombre:</label></li>
					<li><?= $oPersona->getNombre() ?></li>

					<li><label>Tipo de Documento:</label></li>
					<li><?= $oPersona->getTipoDocumento()->getDescripcion() ?></li>

					<li><label>N&uacute;mero de Documento:</label></li>
					<li><?= $oPersona->getNumeroDocumento() ?></li>

					<li><label>Sexo:</label></li>
					<li><?= $oPersona->getSexo()->getDescripcion() ?></li>

					<li><label>Nacionalidad:</label></li>
					<li><?= $oPersona->getNacionalidad() ?></li>
				</ul>

			</fieldset>

			<fieldset>
				<legend>Informaci&oacute;n de Contacto:</legend>

				<ul>
					<li><label>Correo electr&oacute;nico:</label></li>
					<li><?= $oPersona->getEmail()->getValor() ?></li>

					<li><label>Tel&eacute;fono:</label></li>
					<li><?= $oPersona->getTelefono()->getValor() ?></li>

					<li><label>Celular:</label></li>
					<li><?= $oPersona->getCelular()->getValor() ?></li>

					<li><label>Domicilio:</label></li>
					<li><?= $oPersona->getDomicilio() ?></li>

					<li><label>Provincia:</label></li>
					<li><?= $oPersona->getProvincia()->getDescripcion() ?></li>

					<li><label>Localidad:</label></li>
					<li><?= $oPersona->getLocalidad() ?></li>
				</ul>

			</fieldset>

			<fieldset>

				<div class="buttons">
					<input type="button" value="Guardar" onclick="document.location='Finalizar.php'">
					<input type="button" value="Anterior" onclick="document.location='Paso2.php'">
				</div>

			</fieldset>

		</div>

	<?php } ?>
	
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>