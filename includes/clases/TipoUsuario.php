<?php 

class TipoUsuario 
{

    private $_idTipoUsuario;
    private $_descripcion;

    public function __construct($idTipoUsuario = null, $descripcion = null){
        $this->_idTipoUsuario = $idTipoUsuario;
        $this->_descripcion = $descripcion;
    }

    public function getIdTipoUsuario(){
        return $this->_idTipoUsuario;
    }
    
    public function getDescripcion(){
        return $this->_descripcion;
    }

}

?>