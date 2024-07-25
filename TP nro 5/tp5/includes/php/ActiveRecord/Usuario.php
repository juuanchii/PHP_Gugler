<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/ValueObject.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/UsuarioVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';


class Usuario extends ActiveRecord
{
    private $_uVO;

    public function get()
    {
        return $this->_uVO;
    }

    public function set(ValueObject $value)
    {
        $this->_uVO = $value;
    }

    public function fetch($id)
    {
        $vo = null;
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM usuario WHERE idusuario = $id";
        $result = $pdo->query($query);

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vo = new UsuarioVO();
            $vo->idusuario = $row['idusuario'];
            $vo->idpersona = $row['idpersona'];
            $vo->idtipousuario = $row['idtipousuario'];
            $vo->nombre = $row['nombre'];
            $vo->contrasenia = $row['contrasenia'];
        }

        $this->_uVO = $vo;
    }

    public function insert()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "INSERT INTO usuario (idpersona, idtipousuario, nombre, contrasenia) VALUES (:idpersona, :idtipousuario, :nombre, :contrasenia)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idpersona', $this->_uVO->idpersona, PDO::PARAM_INT);
        $stmt->bindParam(':idtipousuario', $this->_uVO->idtipousuario, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $this->_uVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenia', $this->_uVO->contrasenia, PDO::PARAM_STR);
        $stmt->execute();

        $this->_uVO->idusuario = $pdo->lastInsertId();
    }

    public function update()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "UPDATE usuario SET idpersona = :idpersona, idtipousuario = :idtipousuario, nombre = :nombre, contrasenia = :contrasenia WHERE idusuario = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idpersona', $this->_uVO->idpersona, PDO::PARAM_INT);
        $stmt->bindParam(':idtipousuario', $this->_uVO->idtipousuario, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $this->_uVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenia', $this->_uVO->contrasenia, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->_uVO->idusuario, PDO::PARAM_INT);
        
        $stmt->execute();

    }

    public function delete($id)
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "DELETE FROM usuario WHERE idusuario = $id";
        $pdo->query($query);
    }

    public function fetchAll()
    {
        $results = array();
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM usuario";
        $result = $pdo->query($query);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $vo = new UsuarioVO();
            $vo->idusuario = $row['idusuario'];
            $vo->idpersona = $row['idpersona'];
            $vo->idtipousuario = $row['idtipousuario'];
            $vo->nombre = $row['nombre'];
            $vo->contrasenia = $row['contrasenia'];

            $results[] = $vo;
        }

        return $results;
    }

    public function validarContrasenia()
	{
		if ( strlen($this->_uVO->contrasenia) < 6 )
		{
			return false;
		}

		$regExp = '/([a-z][0-9]|[0-9][a-z])+/i';

		if ( preg_match($regExp, $this->_uVO->contrasenia) == false )
		{
			return false;
		}

		return true;
	}

    public function getContraseniaEnmascadara()
	{
		return preg_replace(array('/./'), '*', $this->_uVO->contrasenia);
	}
}