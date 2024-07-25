<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/tp5/includes/php/ValueObject/ValueObject.php';

class TipoDocumentoVO extends ValueObject
{
	public $idtipodocumento;
	public $nombre;
	public $descripcion;
}