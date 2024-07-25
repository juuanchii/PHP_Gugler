<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tp5/includes/php/ValueObject/ValueObject.php';

class TipoUsuarioVO extends ValueObject
{
	public $idtipousuario;
	public $nombre;
	public $descripcion;
}