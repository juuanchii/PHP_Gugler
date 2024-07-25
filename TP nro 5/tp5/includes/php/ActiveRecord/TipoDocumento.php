<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/TipoDocumentoVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ActiveRecord/ActiveRecord.php';


class TipoDocumento
{
    private $_tdVO;

    public function get()
    {
        return $this->_tdVO;
    }

    public function set(ValueObject $value)
    {
        $this->_tdVO = $value;
    }

    public function fetch($id)
    {
        $vo = null;
        $pdo = DataBase::getInstance()->getConexion();
        $sql = "SELECT * FROM tipodocumento WHERE idtipodocumento = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vo = new TipoDocumentoVO();
            $vo->idtipodocumento = $row['idtipodocumento'];
            $vo->nombre = $row['nombre'];
            $vo->descripcion = $row['descripcion'];
        }

        $this->_tdVO = $vo;
    }

    public function insert()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $sql = "INSERT INTO tipo_documento (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $this->_tdVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->_tdVO->descripcion, PDO::PARAM_STR);
        $stmt->execute();

        $this->_tdVO->idtipodocumento = $pdo->lastInsertId();

    }

    public function update()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $sql = "UPDATE tipodocumento SET nombre = :nombre, descripcion = :descripcion WHERE idtipodocumento = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $this->_tdVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->_tdVO->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->_tdVO->idtipodocumento, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $sql = "DELETE FROM tipodocumento WHERE idtipodocumento = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->_tdVO->idtipodocumento, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function fetchAll()
    {
        $results = [];
        $pdo = DataBase::getInstance()->getConexion();
        $sql = "SELECT * FROM tipodocumento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vo = new TipoDocumentoVO();
            $vo->idtipodocumento = $row['idtipodocumento'];
            $vo->nombre = $row['nombre'];
            $vo->descripcion = $row['descripcion'];
            $results[] = $vo;
        }

        return $results;
    }
}