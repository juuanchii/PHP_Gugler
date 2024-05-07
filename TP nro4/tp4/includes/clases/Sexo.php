<?php

class Sexo
{
	private $_idSexo;
	private $_descripcion;

	public function __construct($idSexo = null, $descripcion = null)
	{
		$this->_idSexo = $idSexo;
		$this->_descripcion = $descripcion;
	}

	public function getIdSexo()
	{
		return $this->_idSexo;
	}

	public function getDescripcion()
	{
		return $this->_descripcion;
	}
}