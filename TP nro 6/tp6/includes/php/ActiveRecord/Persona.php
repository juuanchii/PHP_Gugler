<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/ActiveRecord/ActiveRecord.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/ValueObject/PersonaVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Singleton/BaseDeDatos.php';

class Persona extends ActiveRecord
{
	private $_vo;

	public function get()
	{
		return $this->_vo;
	}

	public function set(ValueObject $value)
	{
		$this->_vo = $value;
	}

	public function fetch($id)
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "select * from persona where idpersona = $id";

		$stmt = $pdo->query($query);

		$vo = null;
		$resultado = $stmt->fetchObject();

		if ( $resultado != null )
		{
			$vo = new PersonaVO();
			$vo->idPersona = $resultado->idpersona;
			$vo->idTipoDocumento = $resultado->idtipodocumento;
			$vo->apellido = $resultado->apellido;
			$vo->nombre = $resultado->nombre;
			$vo->numeroDocumento = $resultado->numerodocumento;
			$vo->sexo = $resultado->sexo;
			$vo->nacionalidad = $resultado->nacionalidad;
			$vo->email = $resultado->email;
			$vo->telefono = $resultado->telefono;
			$vo->celular = $resultado->celular;
			$vo->provincia = $resultado->provincia;
			$vo->localidad = $resultado->localidad;
		}

		$this->_vo = $vo;
	}

	public function insert()
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "insert into persona (idtipodocumento,apellido,nombre,numerodocumento,sexo,nacionalidad,email,telefono,celular,provincia,localidad)
				values ({$this->_vo->idTipoDocumento},'{$this->_vo->apellido}','{$this->_vo->nombre}',{$this->_vo->numeroDocumento},'{$this->_vo->sexo}',
				'{$this->_vo->nacionalidad}','{$this->_vo->email}','{$this->_vo->telefono}','{$this->_vo->celular}','{$this->_vo->provincia}','{$this->_vo->localidad}')";

		$pdo->query($query);

		$this->_vo->idPersona = $pdo->lastInsertId();
	}

	public function update()
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "update persona set
				idtipodocumento = {$this->_vo->idTipoDocumento},
				apellido = '{$this->_vo->apellido}',
				nombre = '{$this->_vo->nombre}',
				numerodocumento = {$this->_vo->numeroDocumento},
				sexo = '{$this->_vo->sexo}',
				nacionalidad = '{$this->_vo->nacionalidad}',
				email = '{$this->_vo->email}',
				telefono = '{$this->_vo->telefono}',
				celular = '{$this->_vo->celular}',
				provincia = '{$this->_vo->provincia}',
				localidad = '{$this->_vo->localidad}'
			where idpersona = {$this->_vo->idPersona}";

		$pdo->query($query);
	}

	public function delete($id)
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "delete from persona where idpersona = $id";

		$pdo->query($query);
	}

	private function _validarTelefono($valor)
	{
		$telefono = explode('-', $valor);

		if ( count($telefono) != 2 )
		{
			return false;
		}

		if ( is_numeric($telefono[0]) == false || is_numeric($telefono[1]) == false)
		{
			return false;
		}

		if ( ( strlen($telefono[0]) + strlen($telefono[1]) ) < 10 )
		{
			return false;
		}

		return true;
	}

	private function _validarEmail($valor)
	{
		$email = explode('@', $valor);

		return ( count($email) == 2 );
	}

	public function validarContactos()
	{
		$telefono = ($this->_vo->telefono != null) ? $this->_validarTelefono($this->_vo->telefono) : true;
		$celular = ($this->_vo->celular != null) ? $this->_validarTelefono($this->_vo->celular) : true;
		$email = ($this->_vo->email != null) ? $this->_validarEmail($this->_vo->email) : true;

		return $telefono && $celular && $email;
	}
}