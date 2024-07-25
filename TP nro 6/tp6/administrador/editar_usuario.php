<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Factory/ActiveRecordFactory.php';

$oPersona = ActiveRecordFactory::getPersona();
$oUsuario = ActiveRecordFactory::getUsuario();

$aProvincias = array('Entre Rios', 'Sante Fe', 'Cordoba', 'Buenos Aires');

$validarTipoDocumento = false;
$validarSexo = false;
$validarContrasenia = false;
$validarProvincia = false;
$validarContacto = false;

if ( isset($_POST['bt_guardar']) == true )
{
	$oUsuario->fetch($_POST['idUsuario']);
	$oPersona->fetch($oUsuario->get()->idPersona);

	$oUsuarioVO = $oUsuario->get();
	$oPersonaVO = $oPersona->get();

	$oUsuarioVO->idTipoUsuario = ( isset($_POST['tipo_usuario']) == true ) ? $_POST['tipo_usuario'] : 2;
	$oUsuarioVO->nombre = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
	$oUsuarioVO->contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';

	$oPersonaVO->apellido = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
	$oPersonaVO->nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
	$oPersonaVO->idTipoDocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
	$oPersonaVO->numeroDocumento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
	$oPersonaVO->sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
	$oPersonaVO->nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';
	$oPersonaVO->email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
	$oPersonaVO->telefono = ( isset($_POST['telefono']) == true ) ? $_POST['telefono'] : '';
	$oPersonaVO->celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
	$oPersonaVO->provincia = ( isset($_POST['provincia']) == true ) ? $_POST['provincia'] : '';
	$oPersonaVO->localidad = ( isset($_POST['localidad']) == true ) ? $_POST['localidad'] : '';

	$oUsuario->set($oUsuarioVO);
	$oPersona->set($oPersonaVO);

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

	foreach ($aProvincias as $provincia )
	{
		if ( $oPersonaVO->provincia == $provincia )
		{
			$validarProvincia = true;
		}
	}

	if ( $oPersona->validarContactos() == true )
	{
		$validarContacto = true;
	}

	$validaciones = $validarContrasenia && $validarContacto && $validarProvincia && $validarSexo && $validarTipoDocumento;

	if ( $validaciones )
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$pdo->beginTransaction();

		try
		{
			$oUsuario->update();
			$oPersona->update();

			$pdo->commit();

			header('location: /tp6/administrador/');
		}
		catch(Exception $e)
		{
			$pdo->rollBack();
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Editar Usuario</title>
	<link type="text/css" rel="stylesheet" href="/tp6/includes/css/estilos.css">
</head>
<body>

<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/menu-admin.php'; ?>

	<div class="mensaje">

		<?php if ( $validaciones == true ) { ?>
			<h3>Error al registrar el usuario</h3>
			<p>
				Ha ocurrido un error al intentar registrar el usuario. Por favor intentelo nuevamente.
			</p>
		<?php } else { ?>
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validarContrasenia == false ) { ?>
					<li>La contraseña no es válida. Debe contener al menos 6 caracteres y al menos 1 letra y 1 número</li>
				<?php } if ( $validarTipoDocumento == false ) { ?>
					<li>El tipo de documento ingresado no se encuentra registrado</li>
				<?php } if ( $validarSexo == false ) { ?>
					<li>El sexo ingresado no se encuentra registrado</li>
				<?php } if ( $validarProvincia == false ) { ?>
					<li>La provincia ingresada no se encuentra registrada</li>
				<?php } if ( $validarContacto == false ) { ?>
					<li>Alguna de las forma de contacto no se ha ingresado correctamento, recuerde que el correo electrónico debe contener un símbolo "@" y para teléfono y celular debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } ?>
			</ul>
		<?php } ?>

		<div class="buttons">
			<input type="button" value="Anterior" onclick="document.location='/tp6/administrador'">
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/footer.php'; ?>
</body>
</html>