<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/ActiveRecord/ActiveRecord.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/ValueObject/UsuarioVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp6/includes/php/Singleton/BaseDeDatos.php';

class Usuario extends ActiveRecord
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

		$query = "select * from usuario where idusuario = $id";

		$stmt = $pdo->query($query);

		$vo = null;
		$resultado = $stmt->fetchObject();

		if ( $resultado != null )
		{
			$vo = new UsuarioVO();
			$vo->idUsuario = $resultado->idusuario;
			$vo->idPersona = $resultado->idpersona;
			$vo->idTipoUsuario = $resultado->idtipousuario;
			$vo->nombre = $resultado->nombre;
			$vo->contrasenia = $resultado->contrasenia;
		}

		$this->_vo = $vo;
	}

	public function insert()
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "insert into usuario (idpersona,idtipousuario,nombre,contrasenia)
				values ({$this->_vo->idPersona},{$this->_vo->idTipoUsuario},'{$this->_vo->nombre}','{$this->_vo->contrasenia}')";

		$pdo->query($query);

		$this->_vo->idUsuario = $pdo->lastInsertId();
	}

	public function update()
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "update usuario set
				idpersona = {$this->_vo->idPersona},
				idtipousuario = {$this->_vo->idTipoUsuario},
				nombre = '{$this->_vo->nombre}',
				contrasenia = '{$this->_vo->contrasenia}'
			where idusuario = {$this->_vo->idUsuario}";

		$pdo->query($query);
	}

	public function delete($id)
	{
		$pdo = BaseDeDatos::getInstancia()->getConexion();

		$query = "delete from usuario where idusuario = $id";

		$pdo->query($query);
	}

	public function validarContrasenia()
	{
		if ( strlen($this->_vo->contrasenia) < 6 )
		{
			return false;
		}

		$regExp = '/([a-z][0-9]|[0-9][a-z])+/i';

		if ( preg_match($regExp, $this->_vo->contrasenia) == false )
		{
			return false;
		}

		return true;
	}

	public function getContraseniaEnmascadara()
	{
		return preg_replace(array('/./'), '*', $this->_vo->contrasenia);
	}
}