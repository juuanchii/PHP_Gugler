<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Factory/ActiveRecordFactory.php';

$oPersona = ActiveRecordFactory::getPersona();
$oUsuario = ActiveRecordFactory::getUsuario();
$aTipoDocumento = ActiveRecordFactory::getTipoDocumento()->fetchAll();

$aProvincia = array('Buenos Aries', 'Sante Fe', 'Cordoba', 'Entre Ríos', 'La Pampa', 'Mendoza');

$validaciones = array(
	'validarTipoDocumento' => false,
	'validarSexo' => false,
	'validarContrasenia' => false,
	'validarProvincia' => false,
	'validarEmail' => false,
	'validarCelular' => false,
);

if ( isset($_POST['bt_guardar']) == true )
{
	$oUsuario->fetch($_POST['idUsuario']);
	$oPersona->fetch($oUsuario->get()->idpersona);

	$oUsuarioVO = $oUsuario->get();
	$oPersonaVO = $oPersona->get();

	$oUsuarioVO->idtipousuario = ( isset($_POST['tipo_usuario']) == true ) ? (int)$_POST['tipo_usuario'] : 2;
	$oUsuarioVO->nombre = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
	$oUsuarioVO->contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';
	$oPersonaVO->apellidos = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
	$oPersonaVO->nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
	$oPersonaVO->idtipodocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
	$oPersonaVO->numerodocumento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
	$oPersonaVO->sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
	$oPersonaVO->nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';

	$oPersonaVO->email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
	$oPersonaVO->celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
	$oPersonaVO->provincia = ( isset($_POST['provincia']) == true ) ? $_POST['provincia'] : '';
	$oPersonaVO->localidad = ( isset($_POST['localidad']) == true ) ? $_POST['localidad'] : '';
	
	$oUsuario->set($oUsuarioVO); 
	$oPersona->set($oPersonaVO);

	if ( $oUsuario->validarContrasenia() == true )
	{
		$validaciones['validarContrasenia'] = true;
	}

	foreach ( $aTipoDocumento as $oTipoDocumento )
	{
		if ( $oPersonaVO->idtipodocumento == $oTipoDocumento->idtipodocumento )
		{
			$validaciones['validarTipoDocumento'] = true;
		}
	}

	if ( $oPersonaVO->sexo == 'M' || $oPersonaVO->sexo  == 'F' )
	{
		$validaciones['validarSexo'] = true;
	}
	

	foreach ( $aProvincia as $provincia )
	{
		if ( $provincia == $oPersonaVO->provincia )
		{
			$validaciones['validarProvincia'] = true;
		}
	}

	$validar = $oPersona->validar();
	if ( $validar[0] == true )
	{
		$validaciones['validarCelular'] = true;
	}

	if($validar[1] == true)
	{
		$validaciones['validarEmail'] = true;
	}
	var_dump($oUsuario);
}

$validacionesCorrectas = true;

foreach ( $validaciones as $validacion )
{
	if ( $validacion == false )
	{
		$validacionesCorrectas = false;
		break;
	}
}

if ( $validacionesCorrectas == true )
{
	$pdo = DataBase::getInstance()->getConexion();
	$pdo->beginTransaction();

	try
	{
		$oUsuario->update();
		$oPersona->update();

		$pdo->commit();

		session_destroy();
		header('location: /tp5/administrador/index.php');
	}
	catch (Exception $e)
	{
		$pdo->rollBack();
		echo "Error al insertar datos: ". $e->getMessage();
	}
}

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

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/menu-admin.php'; ?>

	<div class="mensaje">

		<?php if ( $validacionesCorrectas == true ) { ?>
			<h3>Error al registrar el usuario</h3>
			<p>
				Ha ocurrido un error al intentar registrar el usuario. Por favor intentelo nuevamente.
			</p>
		<?php } else { ?>
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validaciones['validarContrasenia'] == false ) { ?>
					<li>La contraseña no es válida. Debe contener al menos 6 caracteres y al menos 1 letra y 1 número</li>
				<?php } if ( $validaciones['validarTipoDocumento'] == false ) { ?>
					<li>El tipo de documento ingresado no se encuentra registrado</li>
				<?php } if ( $validaciones['validarSexo'] == false ) { ?>
					<li>El sexo ingresado no se encuentra registrado</li>
				<?php } if ( $validaciones['validarProvincia'] == false ) { ?>
					<li>La provincia ingresada no se encuentra registrada</li>
				<?php } if ( $validaciones['validarEmail'] == false ) { ?>
					<li>El correo electrónico no es válido. Debe contener un símbolo "@"</li>
				<?php } if ( $validaciones['validarCelular'] == false ) { ?>
					<li>El celular no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } ?>
			</ul>
		<?php } ?>

		<div class="buttons">
    	    <a href="/tp5/administrador/editar.php?id=<?= (int)$_POST['idUsuario']?>" title="Editar"><img alt="Volver" src="/tp5/includes/img/back.png"></a>
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>