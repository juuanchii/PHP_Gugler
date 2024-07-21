<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/TipoDocumento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/TipoUsuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Sexo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Contacto.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp4/includes/clases/Provincia.php';

$aTipoDocumento = array(
	new TipoDocumento(1, 'DNI'),
	new TipoDocumento(2, 'LC'),
	new TipoDocumento(3, 'LE'),
);

$aSexo = array(
	new Sexo('M', 'Masculino'),
	new Sexo('F', 'Femenino'),
);

$aProvincia = array(
	new Provincia(1,'Entre Ríos'),
	new Provincia(2,'Santa Fé'),
	new Provincia(3,'Córdoba'),
	new Provincia(4,'Buenos Aires'),
	new Provincia(5,'Catamarca'),
	new Provincia(6,'Corrientes'),
);

$aTipoUsuario = array(
	new TipoUsuario(1, 'Administrador'),
    new TipoUsuario(2, 'Normal'),
);