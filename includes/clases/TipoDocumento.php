<?php

class TipoDocumento
{
	private $_idTipoDocumento;
	private $_descripcion;

	public function __construct($idTipoDocumento = null, $descripcion = null)
	{
		$this->_idTipoDocumento = $idTipoDocumento;
		$this->_descripcion = $descripcion;
	}

	public function getIdTipoDocumento()
	{
		return $this->_idTipoDocumento;
	}

	public function getDescripcion()
	{
		return $this->_descripcion;
	}
}