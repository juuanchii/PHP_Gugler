<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/conexion.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Persona.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/php/objetos.php';

    $validaciones = array(
        'validarTipoDocumento' => false,
        'validarSexo' => false,
        'validarContrasenia' => false,
        'validarProvincia' => false,
        'validarEmail' => false,
        'validarCelular' => false,
    );

    $oPersona = new Persona();

    if ( isset($_POST['bt_guardar']) == true )
    {   

        $idUsuario = (int)$_POST['idUsuario'];
        $idTipoUsuario = (int)$_POST["tipo_usuario"];

        $usuario = ( isset($_POST['nombre_usuario']) == true ) ? $_POST['nombre_usuario'] : '';
        $contrasenia = ( isset($_POST['contrasenia']) == true ) ? $_POST['contrasenia'] : '';
        $apellido = ( isset($_POST['apellido']) == true ) ? $_POST['apellido'] : '';
        $nombre = ( isset($_POST['nombre']) == true ) ? $_POST['nombre'] : '';
        $tipoDocumento = ( isset($_POST['tipo_documento']) == true ) ? $_POST['tipo_documento'] : '';
        $documento = ( isset($_POST['numero_documento']) == true ) ? $_POST['numero_documento'] : '';
        $sexo = ( isset($_POST['sexo']) == true ) ? $_POST['sexo'] : '';
        $nacionalidad = ( isset($_POST['nacionalidad']) == true ) ? $_POST['nacionalidad'] : '';
        
        $email = ( isset($_POST['email']) == true ) ? $_POST['email'] : '';
        $celular = ( isset($_POST['celular']) == true ) ? $_POST['celular'] : '';
        $domicilio = ( isset($_POST['domicilio']) == true ) ? $_POST['domicilio'] : '';
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
                $validaciones['validarSexo'] = true;
                $oPersona->setSexo($oSexo);
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
        $oPersona->setDomicilio($domicilio);
        $oPersona->setLocalidad($localidad);

    }
    
    $validacionesCorrectas = true;

    // Validar que todas las validaciones sean correctas para insertar los datos en la base de datos.
    // Si hay alguna validación incorrecta, se cancela la transacción y se muestra el error.
    // En caso contrario, se realiza la transacción y se muestra un mensaje de éxito.
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
        
        try {
            $conexion->beginTransaction();

            $query = "SELECT idpersona FROM usuario WHERE idusuario = :idUsuario";
            $stmt = $conexion->prepare($query);
            $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $idPersona = $stmt->fetchColumn();

            $query = "UPDATE persona SET
                     apellidos = :apellido,
                     nombre = :nombre,
                     idtipodocumento = :idtipodocumento,
                     numerodocumento = :numeroDocumento,
                     sexo = :sexo,
                     provincia = :provincia,
                     nacionalidad = :nacionalidad,
                     localidad = :localidad, 
                     email = :email,
                     celular = :celular
                     WHERE idpersona = :idPersona";

            $stmt = $conexion->prepare($query);
            $stmt->bindValue(':apellido', $oPersona->getApellido(), PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $oPersona->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':idtipodocumento', $oPersona->getTipoDocumento()->getIdTipoDocumento(), PDO::PARAM_INT);
            $stmt->bindValue(':numeroDocumento', $oPersona->getNumeroDocumento(), PDO::PARAM_STR);
            $stmt->bindValue(':sexo', $oPersona->getSexo()->getIdSexo(), PDO::PARAM_STR);
            $stmt->bindValue(':nacionalidad', $oPersona->getNacionalidad(), PDO::PARAM_STR);
            $stmt->bindValue(':provincia', $oPersona->getProvincia()->getDescripcion(), PDO::PARAM_STR);
            $stmt->bindValue(':localidad', $oPersona->getLocalidad(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $oPersona->getEmail()->getValor(), PDO::PARAM_STR);
            $stmt->bindValue(':celular', $oPersona->getCelular()->getValor(), PDO::PARAM_STR);
            $stmt->bindValue(':idPersona', $idPersona, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $query = "UPDATE usuario SET
				idtipousuario = :idTipoUsuario,
				nombre = :usuario,
				contrasenia = :contrasenia
			    WHERE idusuario = :idUsuario";

            $stmt = $conexion->prepare($query);

            $stmt->bindValue(':idUsuario',$idUsuario,PDO::PARAM_INT);
            $stmt->bindValue(':idTipoUsuario',$idTipoUsuario,PDO::PARAM_INT);
            $stmt->bindValue(':usuario',$oPersona->getUsuario()->getNombre(),PDO::PARAM_STR);
            $stmt->bindValue(':contrasenia',$oPersona->getUsuario()->getContrasenia(),PDO::PARAM_STR);

            $stmt->execute();

            $conexion->commit();

        } catch ( \Exception $e ) {
            $conexion->rollback();
            echo "Error al insertar datos: " . $e->getMessage();
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

	<?php if ( $validacionesCorrectas == false ) { ?>

		<div class="mensaje">
			<h3>Existen algunos errores al procesar la información ingresada</h3>
			<ul>
				<?php if ( $validaciones['validarContrasenia'] == false ) { ?>
				<li>La contraseña no es válida. Debe contener al menos 6 caracteres y al menos 1 letra y 1 número</li>
				<?php } if ( $validaciones['validarTipoDocumento'] == false ) { ?>
				<li>El tipo de documento ingresado no se encuentra registrado</li>
				<?php } if ( $validaciones['validarSexo'] == false ) { ?>
				<li>El sexo ingresado no se encuentra registrado</li>
				<?php } ?>
                <?php if ( $validaciones['validarProvincia'] == false ) { ?>
					<li>La provincia ingresada no se encuentra registrada</li>
				<?php } if ( $validaciones['validarEmail'] == false ) { ?>
					<li>El correo electrónico no es válido. Debe contener un símbolo "@"</li>
				<?php } if ( $validaciones['validarCelular'] == false ) { ?>
					<li>El celular no es válido. Debe contener al menos 10 dígitos y estar separado por un "-"</li>
				<?php } ?>
			</ul>
			<div class="buttons">
                <a href="/tp4/administrador/editar.php?id=<?= (int)$_POST['idUsuario']?>" title="Editar"><img alt="Volver" src="/tp5/includes/img/back.png"></a>
			</div>
		</div>

	<?php }  else {?>
        <div class="mensaje">
            <h3>Los datos se han guardado correctamente</h3>
            
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
