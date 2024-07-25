<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/Sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$oRegistry = Sesion::getInstance()->getRegistry();

$oPersonaVO = ($oRegistry->exists('Persona') == true) ? $oRegistry->get('Persona') : new PersonaVO();
$oUsuarioVO = ($oRegistry->exists('Usuario') == true) ? $oRegistry->get('Usuario') : new UsuarioVO();

$aProvincia = array('Buenos Aries', 'Sante Fe', 'Cordoba', 'Entre Ríos', 'La Pampa', 'Mendoza');

$validarProvincia = false;
$validarEmail = false;
$validarCelular = false;

if ( isset($_POST['bt_paso2']) == true )
{
	$oPersonaVO->email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
	$oPersonaVO->celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
	$oPersonaVO->provincia = ( isset($_POST['provincia']) == true ) ? $_POST['provincia'] : '';
	$oPersonaVO->localidad = ( isset($_POST['localidad']) == true ) ? $_POST['localidad'] : '';

	foreach ( $aProvincia as $provincia )
	{
		if ($oPersonaVO->provincia == $provincia)
		{
			$validarProvincia = true;
		}
	}

	$oPersona = ActiveRecordFactory::getPersona();
	$oPersona->set($oPersonaVO);
	$validar = $oPersona->validar();
	if ( $validar[0] == true )
	{
		$validarCelular = true;
	}

	if($validar[1] == true)
	{
		$validarEmail = true;
	}

	$oRegistry->add('Persona', $oPersonaVO);
}
else
{
	$validarProvincia = true;
	$validarEmail = true;
	$validarCelular = true;
}

$oPersona = ActiveRecordFactory::getPersona();
$oPersona->set($oPersonaVO);
$oUsuario = ActiveRecordFactory::getUsuario();
$oUsuario->set($oUsuarioVO);
$oTipoDocumento = ActiveRecordFactory::getTipoDocumento();
$oTipoDocumento->fetch($oPersonaVO->idtipodocumento);
var_dump($oTipoDocumento);

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

	<?php if ( $validarProvincia == false || $validarEmail == false || $validarCelular == false ) { ?>

		<div class="mensaje">
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validarProvincia == false ) { ?>
					<li>La provincia ingresada no se encuentra registrada</li>
				<?php } if ( $validarEmail == false ) { ?>
					<li>El correo electrónico no es válido. Debe contener un símbolo "@"</li>
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
					<li><?= $oUsuarioVO->nombre ?><br></li>

					<li><label>Contrase&ntilde;a:</label></li>
					<li><?= $oUsuario->getContraseniaEnmascadara() ?><br></li>

					<li><label>Apellido:</label></li>
					<li><?= $oPersonaVO->apellidos ?></li>

					<li><label>Nombre:</label></li>
					<li><?= $oPersonaVO->nombre ?></li>

					<li><label>Tipo de Documento:</label></li>
					<li><?= $oTipoDocumento->get()->nombre ?></li>

					<li><label>N&uacute;mero de Documento:</label></li>
					<li><?= $oPersonaVO->numerodocumento ?></li>

					<li><label>Sexo:</label></li>
					<li><?= $oPersonaVO->sexo ?></li>

					<li><label>Nacionalidad:</label></li>
					<li><?= $oPersonaVO->nacionalidad ?></li>
				</ul>

			</fieldset>

			<fieldset>
				<legend>Informaci&oacute;n de Contacto:</legend>

				<ul>
					<li><label>Correo electr&oacute;nico:</label></li>
					<li><?= $oPersonaVO->email ?></li>

					<li><label>Celular:</label></li>
					<li><?= $oPersonaVO->celular ?></li>

					<li><label>Provincia:</label></li>
					<li><?= $oPersonaVO->provincia ?></li>

					<li><label>Localidad:</label></li>
					<li><?= $oPersonaVO->localidad ?></li>
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