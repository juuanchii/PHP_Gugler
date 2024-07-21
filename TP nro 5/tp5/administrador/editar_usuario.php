<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/objetos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/conexion.php';

$oPersona = new Persona();

$validaciones = array(
	'validarTipoDocumento' => false,
	'validarSexo' => false,
	'validarContrasenia' => false,
	'validarProvincia' => false,
	'validarEmail' => false,
	'validarTelefono' => false,
	'validarCelular' => false,
);

if ( isset($_POST['bt_guardar']) == true )
{
	$idUsuario = ( isset($_POST['idUsuario']) == true ) ? $_POST['idUsuario'] : 0;
	$usuario = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
	$contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';
	$apellido = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
	$nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
	$tipoDocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
	$documento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
	$sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
	$nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';
	$tipoUsuario = ( isset($_POST['tipo_usuario']) == true ) ? $_POST['tipo_usuario'] : 2;

	$email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
	$telefono = ( isset($_POST['telefono']) == true ) ? $_POST['telefono'] : '';
	$celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
	$provincia = ( isset($_POST['provincia']) == true ) ? $_POST['provincia'] : '';
	$localidad = ( isset($_POST['localidad']) == true ) ? $_POST['localidad'] : '';

	$oUsuario = new Usuario($usuario, $contrasenia);

	if ( $oUsuario->validarContrasenia() == true )
	{
		$validaciones['validarContrasenia'] = true;
		$oPersona->setUsuario($oUsuario);
	}

	foreach ( $aTipoDocumento as $oTipoDocumento )
	{
		if ( $tipoDocumento == $oTipoDocumento->getIdTipoDocumento() )
		{
			$oPersona->setTipoDocumento($oTipoDocumento);
			$validaciones['validarTipoDocumento'] = true;
		}
	}

	foreach ( $aSexo as $oSexo )
	{
		if ( $sexo == $oSexo->getIdSexo() )
		{
			$oPersona->setSexo($oSexo);
			$validaciones['validarSexo'] = true;
		}
	}

	foreach ( $aProvincia as $oProvincia )
	{
		if ( $oProvincia->getIdProvincia() == $provincia )
		{
			$validaciones['validarProvincia'] = true;
			$oPersona->setProvincia($oProvincia);
		}
	}

	$oEmail = new Contacto(Contacto::TIPO_EMAIL, $email);
	if ( $oEmail->validar() == true )
	{
		$validaciones['validarEmail'] = true;
		$oPersona->setEmail($oEmail);
	}

	$oTelefono = new Contacto(Contacto::TIPO_TELEFONO, $telefono);
	if ( $oTelefono->validar() == true )
	{
		$validaciones['validarTelefono'] = true;
		$oPersona->setTelefono($oTelefono);
	}

	$oCelular = new Contacto(Contacto::TIPO_TELEFONO, $celular);
	if ( $oCelular->validar() == true )
	{
		$validaciones['validarCelular'] = true;
		$oPersona->setCelular($oCelular);
	}

	$oPersona->setApellido($apellido);
	$oPersona->setNombre($nombre);
	$oPersona->setNumeroDocumento($documento);
	$oPersona->setNacionalidad($nacionalidad);
	$oPersona->setLocalidad($localidad);
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
	$pdo = conectarDB();
	$pdo->beginTransaction();

	try
	{
		$query = "select idpersona from usuario where idusuario = :idUsuario";
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		$idPersona = $stmt->fetchColumn();

		$query = "update persona set
				idtipodocumento = :idTipoDocumento,
				apellido = :apellido,
				nombre = :nombre,
				numerodocumento = :documento,
				sexo = :sexo,
				nacionalidad = :nacionalidad,
				email = :email,
				telefono = :telefono,
				celular = :celular,
				provincia = :provincia,
				localidad = :localidad
			where
				idpersona = :idPersona";

		$stmt = $pdo->prepare($query);

		$stmt->bindValue(':idTipoDocumento', $oPersona->getTipoDocumento()->getIdTipoDocumento(),PDO::PARAM_INT);
		$stmt->bindValue(':apellido', $oPersona->getApellido(),PDO::PARAM_STR);
		$stmt->bindValue(':nombre', $oPersona->getNombre(),PDO::PARAM_STR);
		$stmt->bindValue(':documento', $oPersona->getNumeroDocumento(),PDO::PARAM_INT);
		$stmt->bindValue(':sexo', $oPersona->getSexo()->getIdSexo(),PDO::PARAM_STR);
		$stmt->bindValue(':nacionalidad', $oPersona->getNacionalidad(),PDO::PARAM_STR);
		$stmt->bindValue(':email', $oPersona->getEmail()->getValor(),PDO::PARAM_STR);
		$stmt->bindValue(':telefono', $oPersona->getTelefono()->getValor(),PDO::PARAM_STR);
		$stmt->bindValue(':celular', $oPersona->getCelular()->getValor(),PDO::PARAM_STR);
		$stmt->bindValue(':provincia', $oPersona->getProvincia()->getDescripcion(),PDO::PARAM_STR);
		$stmt->bindValue(':localidad', $oPersona->getLocalidad(),PDO::PARAM_STR);
		$stmt->bindValue(':idPersona', $idPersona,PDO::PARAM_INT);

		$stmt->execute();

		$query = "update usuario set
				idtipousuario = :idTipoUsuario,
				nombre = :usuario,
				contrasenia = :contrasenia
			where
				idusuario = :idUsuario";

		$stmt = $pdo->prepare($query);

		$stmt->bindValue(':idUsuario',$idUsuario,PDO::PARAM_INT);
		$stmt->bindValue(':idTipoUsuario',$tipoUsuario,PDO::PARAM_INT);
		$stmt->bindValue(':usuario',$oPersona->getUsuario()->getNombre(),PDO::PARAM_STR);
		$stmt->bindValue(':contrasenia',$oPersona->getUsuario()->getContrasenia(),PDO::PARAM_STR);

		$stmt->execute();

		$pdo->commit();

		session_destroy();
		header('location: /tp5/administrador');
	}
	catch (Exception $e)
	{
		$pdo->rollBack();
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
				<?php } if ( $validaciones['validarTelefono'] == false ) { ?>
					<li>El teléfono no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } if ( $validaciones['validarCelular'] == false ) { ?>
					<li>El celular no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } ?>
			</ul>
		<?php } ?>

		<div class="buttons">
			<input type="button" value="Anterior" onclick="document.location='/tp5/administrador'">
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>