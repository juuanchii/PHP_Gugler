<?php

class Usuario
{
	private $_nombre;
	private $_contrasenia;

	public function __construct($nombre = null, $contrasenia = null)
	{
		$this->_nombre = $nombre;
		$this->_contrasenia = $contrasenia;
	}

	public function getNombre()
	{
		return $this->_nombre;
	}

	public function getContrasenia()
	{
		return $this->_contrasenia;
	}

	public function validarContrasenia()
	{
		if ( strlen($this->_contrasenia) < 6 )
		{
			return false;
		}

		$regExp = '/([a-z][0-9]|[0-9][a-z])+/i';

		if ( preg_match($regExp, $this->_contrasenia) == false )
		{
			return false;
		}

		return true;
	}

	public function getContraseniaEnmascadara()
	{
		return preg_replace(array('/./'), '*', $this->_contrasenia);
	}
}