<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

    if (isset($_POST['bt_eliminar']) == true) 
    {
        $idUsuario = (int)$_POST['idUsuario'];

        $conexion->beginTransaction();

        try{

            $sql = "SELECT idpersona FROM usuario WHERE idUsuario = :idUsuario";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $idPersona = $stmt->fetchColumn();

            $sql = "DELETE FROM usuario WHERE idusuario = :idUsuario";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "DELETE FROM persona WHERE idpersona = :idPersona";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idPersona', $idPersona, PDO::PARAM_INT);
            $stmt->execute();

            $conexion->commit();

            $errores = false;

        } catch (\PDOException $e){
            $conexion->rollBack();
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            $errores = true;
        }
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

	<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/header.php' ?>

	<?php if ( $errores == true ) { ?>

		<div class="mensaje">
			<h3>Existen algunos errores al procesar la información </h3>
			
			<div class="buttons">
                <input type="button" value="Listado" onclick="document.location='listar.php'">
			</div>
		</div>

	<?php }  else {?>
        <div class="mensaje">
            <h3>Usuario borrado correctamente!</h3>
            
            <div class="buttons">
                    <input type="button" value="Listado" onclick="document.location='listar.php'">
            </div>
        </div>

        <?php } ?>
	<div class="push"></div>
	
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/footer.php'; ?>
</body>
</html>