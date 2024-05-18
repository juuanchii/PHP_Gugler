<?php

class Contacto
{
	const TIPO_TELEFONO = 1;
	const TIPO_EMAIL = 2;

	private $_tipo;
	private $_valor;

	public function __construct($idContacto = null, $descripcion = null)
	{
		$this->_tipo = $idContacto;
		$this->_valor = $descripcion;
	}

	public function getTipo()
	{
		return $this->_tipo;
	}

	public function getValor()
	{
		return $this->_valor;
	}

	private function _validarTelefono($valor)
	{
		$telefono = $valor;

		return true;
	}

	private function _validarEmail($valor)
	{
		$email = explode('@', $valor);

		return ( count($email) == 2 );
	}

	public function validar()
	{
		switch ($this->_tipo)
		{
			case self::TIPO_TELEFONO:
				return $this->_validarTelefono($this->_valor);
				break;

			case self::TIPO_EMAIL:
				return $this->_validarEmail($this->_valor);
				break;

			default:
				return false;
		}
	}
}