<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/UsuarioVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/TipoUsuarioVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ActiveRecord/ActiveRecord.php';

class TipoUsuario extends ActiveRecord
{
    private $_tuVO;

    public function get()
    {
        return $this->_tuVO;
    }

    public function set(ValueObject $value)
    {
        $this->_tuVO = $value;
    }

    public function fetch($id)
    {
        $vo = null;
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM tipousuario WHERE idtipousuario = $id";
        $result = $pdo->query($query);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vo = new TipoUsuarioVO();
            $vo->idtipousuario = $row['idtipousuario'];
            $vo->nombre = $row['nombre'];
            $vo->descripcion = $row['descripcion'];
        }

        $this->_tuVO = $vo;
    }

    public function insert()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "INSERT INTO tipousuario (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $this->_tuVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->_tuVO->descripcion, PDO::PARAM_STR);
        $stmt->execute();

        $this->_tuVO->idtipousuario = $pdo->lastInsertId();

    }

    public function update()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "UPDATE tipousuario SET nombre = :nombre, descripcion = :descripcion WHERE idtipousuario = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $this->_tuVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->_tuVO->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->_tuVO->idtipousuario, PDO::PARAM_INT);
        $stmt->execute();

    }

    public function delete($id)
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "DELETE FROM tipousuario WHERE idtipousuario = $id";
        $pdo->query($query);
    }

    public function fetchAll()
    {
        $results = array();
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM tipousuario";
        $result = $pdo->query($query);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $vo = new TipoUsuarioVO();
            $vo->idtipousuario = $row['idtipousuario'];
            $vo->nombre = $row['nombre'];
            $vo->descripcion = $row['descripcion'];
            $results[] = $vo;
        }

        return $results;

    }
}