<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/tp5/includes/php/ValueObject/ValueObject.php';

class PersonaVO extends ValueObject
{
	public $idpersona;
	public $idtipodocumento;
	public $apellidos;
	public $nombre;
	public $numerodocumento;
	public $sexo;
	public $nacionalidad;
	public $email;
	public $celular;
	public $telefono; 
	public $provincia;
	public $localidad;
	public $domicilio;
}