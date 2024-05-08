<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';

session_start();

$oPersona = (isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

$sql = "SELECT u.nombre as usua, p.idpersona, p.nombre, p.idtipodocumento, p.numerodocumento, p.email FROM persona p INNER JOIN usuario u ON p.idpersona = u.idpersona";

$result = $conexion->query($sql);

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	 	echo "<tr>";
        echo "<td>".$row["usua"]."</td><br>";
        echo "<td>".$row["idpersona"]."</td><br>";
        echo "<td>".$row["nombre"]."</td><br>";
        echo "<td>".$row["idtipodocumento"]."</td><br>";
        echo "<td>".$row["numerodocumento"]."</td><br>";
        echo "<td>".$row["email"]."</td><br>";
        echo "</tr>";
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>SGU | Formulario de Inscripc&oacute;n</title>
	<link type="text/css" rel="stylesheet" href="/tp4/includes/css/estilos.css">
</head>
<body>


<div class="wraper">

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/header.php'; ?>

	<div>
		<h2>Listado de Usuarios:</h2>

			<div>
				<table border='1'>

				<tr><th>Identificador</th><th>Usuario</th><th>Apellido y Nombre</th><th>Tipo de Documento</th><th>Número de Documento</th><th>Email</th></tr>
				</table>
			</div>
	</div>

	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/footer.php'; ?>
</body>
</html>