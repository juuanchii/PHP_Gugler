<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/tp5/includes/php/ValueObject/ValueObject.php';


class UsuarioVO extends ValueObject
{
	public $idusuario;
	public $idpersona;
	public $idtipousuario;
	public $nombre;
	public $contrasenia;
}