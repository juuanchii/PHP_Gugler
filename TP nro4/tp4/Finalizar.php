<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

session_start();

$oPersona = ( isset($_SESSION['Persona']) == false ) ? new Persona() : $_SESSION['Persona'];

	$idTipoDocumento = $oPersona->getTipoDocumento()->getIdTipoDocumento();
	$apellidos = $oPersona->getApellido();
	$nombre = $oPersona->getNombre();
	$numerodocumento = $oPersona->getNumeroDocumento();
	$sexo = $oPersona->getSexo()->getIdSexo();
	$nacionalidad = $oPersona->getNacionalidad();
	$email = $oPersona->getEmail()->getValor();
	$celular = $oPersona->getCelular()->getValor();
	$provincia = $oPersona->getProvincia()->getDescripcion();
	$localidad = $oPersona->getLocalidad();
    $usuario = $oPersona->getUsuario()->getNombre();
    $contrasenia = $oPersona->getUsuario()->getContrasenia();

    try {

    $conexion->beginTransaction();

    $stmt = $conexion->prepare("INSERT INTO persona (idtipodocumento, apellidos, nombre, numerodocumento, sexo, nacionalidad, email, celular, provincia, localidad) VALUES (:idTipoDocumento, :apellidos, :nombre, :numerodocumento, :sexo, :nacionalidad, :email, :celular, :provincia, :localidad)");
    
    $stmt->bindParam(':idTipoDocumento', $idTipoDocumento);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':numerodocumento', $numerodocumento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':nacionalidad', $nacionalidad);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':provincia', $provincia);
    $stmt->bindParam(':localidad', $localidad);
    
    $stmt->execute();

    $ultimo_id = $conexion ->lastInsertId();
    
    // $aTipoUsuario[1] = "Usuario normal"
    $idtipousuario = $aTipoUsuario[1]->getIdTipoUsuario();

    $stmt1 = $conexion->prepare("INSERT INTO usuario (idpersona, idtipousuario, nombre, contrasenia) VALUES (:ultimo_id, :idtipousuario, :nombre, :contrasenia)");

    $stmt1->bindParam(':ultimo_id', $ultimo_id);
    $stmt1->bindParam(':idtipousuario', $idtipousuario);
    $stmt1->bindParam(':nombre', $usuario);
    $stmt1->bindParam(':contrasenia', $contrasenia);

    $stmt1->execute();

    $conexion->commit();
    echo "Datos insertados correctamente.";
    
            
    //$ultimo_id = $conexion ->lastInsertId();

    //session_destroy();

    } catch(PDOException $e) {
        $conexion->rollback();
        echo "Error al insertar datos: " . $e->getMessage();
    }
    
?>
            <fieldset>
                    <div class="buttons">
                    <input type="button" value="Mostrar Informacion" onclick="document.location='administrador/listar.php'">
                </div>

            </fieldset>
