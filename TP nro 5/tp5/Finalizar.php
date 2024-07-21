<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/conexion.php';

session_start();

$pdo = conectarDB();
$oPersona = $_SESSION['Persona'];

$pdo->beginTransaction();

try
{
	$query = "insert into persona (idtipodocumento,apellido,nombre,numerodocumento,sexo,nacionalidad,email,telefono,celular,provincia,localidad)
			values (:idTipoDocumento,
			:apellido,
			:nombre,
			:documento,
			:sexo,
			:nacionalidad,
			:email,
			:telefono,
			:celular,
			:provincia,
			:localidad)";

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

	$stmt->execute();

	$idPersona = $pdo->lastInsertId();

	$query = "insert into usuario (idpersona,idtipousuario,nombre,contrasenia)
			values(:idPersona,2,:usuario,:contrasenia)";

	$stmt = $pdo->prepare($query);

	$stmt->bindValue(':idPersona',$idPersona,PDO::PARAM_INT);
	$stmt->bindValue(':usuario',$oPersona->getUsuario()->getNombre(),PDO::PARAM_STR);
	$stmt->bindValue(':contrasenia',$oPersona->getUsuario()->getContrasenia(),PDO::PARAM_STR);

	$stmt->execute();

	$pdo->commit();

	session_destroy();
	header('location: Paso1.php');
}
catch (Exception $e)
{
	$pdo->rollBack();
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

	<div class="mensaje">
		<h3>Error al registrar el usuario</h3>
		<p>
			Ha ocurrido un error al intentar registrar el usuario. Por favor intentelo nuevamente.
		</p>
		<div class="buttons">
			<input type="button" value="Anterior" onclick="document.location='Paso3.php'">
		</div>
	</div>

	<div class="push"></div>

</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/footer.php'; ?>
</body>
</html>