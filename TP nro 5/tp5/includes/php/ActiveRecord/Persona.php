<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/Singleton/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/PersonaVO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ActiveRecord/ActiveRecord.php';

class Persona extends ActiveRecord
{
    private $_pVO;

    public function get()
    {
        return $this->_pVO;
    }

    public function set(ValueObject $value)
    {
        $this->_pVO = $value;
    }

    public function fetch($id)
    {
        $vo = null;
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM persona WHERE idpersona = $id";
        $result = $pdo->query($query);

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vo = new PersonaVO();
            $vo->idpersona = $row['idpersona'];
            $vo->idtipodocumento = $row['idtipodocumento'];
            $vo->apellidos = $row['apellidos'];
            $vo->nombre = $row['nombre'];
            $vo->numerodocumento = $row['numerodocumento'];
            $vo->sexo = $row['sexo'];
            $vo->nacionalidad = $row['nacionalidad'];
            $vo->celular = $row['celular'];
            $vo->email = $row['email'];
            $vo->provincia = $row['provincia'];
            $vo->localidad = $row['localidad'];
        }

        $this->_pVO = $vo;
    }

    public function insert()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "INSERT INTO persona (idtipodocumento, apellidos, nombre, numerodocumento, sexo, nacionalidad, email, celular, provincia, localidad) VALUES (:idtipodocumento, :apellidos, :nombre, :numerodocumento, :sexo, :nacionalidad, :email, :celular, :provincia, :localidad)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idtipodocumento', $this->_pVO->idtipodocumento, PDO::PARAM_INT);
        $stmt->bindParam(':apellidos', $this->_pVO->apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $this->_pVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':numerodocumento', $this->_pVO->numerodocumento, PDO::PARAM_INT);
        $stmt->bindParam(':sexo', $this->_pVO->sexo, PDO::PARAM_STR);
        $stmt->bindParam(':nacionalidad', $this->_pVO->nacionalidad, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->_pVO->email, PDO::PARAM_STR);
        $stmt->bindParam(':celular', $this->_pVO->celular, PDO::PARAM_STR);
        $stmt->bindParam(':provincia', $this->_pVO->provincia, PDO::PARAM_STR);
        $stmt->bindParam(':localidad', $this->_pVO->localidad, PDO::PARAM_STR);
        $stmt->execute();

        $this->_pVO->idpersona = $pdo->lastInsertId();

    }

    public function update()
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "UPDATE persona 
                    SET idtipodocumento = :idtipodocumento,
                    apellidos = :apellidos,
                    nombre = :nombre,
                    numerodocumento = :numerodocumento,
                    sexo = :sexo,
                    nacionalidad = :nacionalidad, 
                    email = :email, 
                    celular = :celular, 
                    provincia = :provincia, 
                    localidad = :localidad 
                    WHERE idpersona = :id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $this->_pVO->idpersona, PDO::PARAM_INT);
        $stmt->bindParam(':idtipodocumento', $this->_pVO->idtipodocumento, PDO::PARAM_INT);
        $stmt->bindParam(':apellidos', $this->_pVO->apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $this->_pVO->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':numerodocumento', $this->_pVO->numerodocumento, PDO::PARAM_INT);
        $stmt->bindParam(':sexo', $this->_pVO->sexo, PDO::PARAM_STR);
        $stmt->bindParam(':nacionalidad', $this->_pVO->nacionalidad, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->_pVO->email, PDO::PARAM_STR);
        $stmt->bindParam(':celular', $this->_pVO->celular, PDO::PARAM_STR);
        $stmt->bindParam(':provincia', $this->_pVO->provincia, PDO::PARAM_STR);
        $stmt->bindParam(':localidad', $this->_pVO->localidad, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function delete($id)
    {
        $pdo = DataBase::getInstance()->getConexion();
        $query = "DELETE FROM persona WHERE idpersona = $id";
        $pdo->query($query);
    }

    public function fetchAll()
    {
        $results = array();
        $pdo = DataBase::getInstance()->getConexion();
        $query = "SELECT * FROM persona";
        $result = $pdo->query($query);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $vo = new PersonaVO();
            $vo->idPersona = $row['idpersona'];
            $vo->idtipodocumento = $row['idtipodocumento'];
            $vo->apellidos = $row['apellidos'];
            $vo->nombre = $row['nombre'];
            $vo->numeroDocumento = $row['numerodocumento'];
            $vo->sexo = $row['sexo'];
            $vo->nacionalidad = $row['nacionalidad'];
            $vo->email = $row['email'];
            $vo->celular = $row['celular'];
            $vo->provincia = $row['provincia'];
            $vo->localidad = $row['localidad'];
            $results[] = $vo;
        }
        return $results;
    }
    private function _validarTelefono($valor)
	{
		$telefono = explode('-', $valor);

		if ( count($telefono) != 2 )
		{
			return false;
		}

		if ( is_numeric((int)$telefono[0]) == false || is_numeric((int)$telefono[1]) == false)
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

	public function validar()
	{
        $celular = ($this->_pVO->celular != null) ? $this->_validarTelefono($this->_pVO->celular) : false;
        $email = ($this->_pVO->email != null) ? $this->_validarEmail($this->_pVO->email) : false;

        $contacto = array($celular, $email);
        return $contacto;
		
	}
}