<?php

require_once 'TipoDocumento.php';
require_once 'Sexo.php';
require_once 'Usuario.php';
require_once 'Contacto.php';
require_once 'Provincia.php';

class Persona
{
	/** @var string */
	private $_apellido;
	/** @var string */
	private $_nombre;
	/** @var string */
	private $_numeroDocumento;
	/** @var TipoDocumento */
	private $_tipoDocumento;
	/** @var Sexo */
	private $_sexo;
	/** @var Usuario */
	private $_usuario;
	/** @var string */
	private $_nacionalidad;
	/** @var Contacto */
	private $_email;
	/** @var Contacto */
	private $_telefono;
	/** @var Contacto */
	private $_celular;
	/** @var string */
	private $_domicilio;
	/** @var Provincia */
	private $_provincia;
	/** @var string */
	private $_localidad;

	public function __construct()
	{
		$this->_tipoDocumento = new TipoDocumento();
		$this->_sexo = new Sexo();
		$this->_usuario = new Usuario();
		$this->_email = new Contacto();
		$this->_telefono = new Contacto();
		$this->_celular = new Contacto();
		$this->_provincia = new Provincia();
	}

	/**
	 * @return string
	 */
	public function getApellido()
	{
		return $this->_apellido;
	}

	/**
	 * @param $apellido
	 */
	public function setApellido($apellido)
	{
		$this->_apellido = $apellido;
	}

	/**
	 * @return string
	 */
	public function getNombre()
	{
		return $this->_nombre;
	}

	/**
	 * @param $nombre
	 */
	public function setNombre($nombre)
	{
		$this->_nombre = $nombre;
	}

	/**
	 * @return string
	 */
	public function getNumeroDocumento()
	{
		return $this->_numeroDocumento;
	}

	/**
	 * @param $numeroDocumento
	 */
	public function setNumeroDocumento($numeroDocumento)
	{
		$this->_numeroDocumento = $numeroDocumento;
	}

	/**
	 * @return TipoDocumento
	 */
	public function getTipoDocumento()
	{
		return $this->_tipoDocumento;
	}

	/**
	 * @param TipoDocumento $tipoDocumento
	 */
	public function setTipoDocumento(TipoDocumento $tipoDocumento)
	{
		$this->_tipoDocumento = $tipoDocumento;
	}

	/**
	 * @return Sexo
	 */
	public function getSexo()
	{
		return $this->_sexo;
	}

	/**
	 * @param Sexo $sexo
	 */
	public function setSexo(Sexo $sexo)
	{
		$this->_sexo = $sexo;
	}

	/**
	 * @return Usuario
	 */
	public function getUsuario()
	{
		return $this->_usuario;
	}

	/**
	 * @param Usuario $usuario
	 */
	public function setUsuario(Usuario $usuario)
	{
		$this->_usuario = $usuario;
	}

	/**
	 * @return string
	 */
	public function getNacionalidad()
	{
		return $this->_nacionalidad;
	}

	/**
	 * @param $nacionalidad
	 */
	public function setNacionalidad($nacionalidad)
	{
		$this->_nacionalidad = $nacionalidad;
	}

	/**
	 * @return Contacto
	 */
	public function getEmail()
	{
		return $this->_email;
	}

	/**
	 * @param Contacto $email
	 */
	public function setEmail(Contacto $email)
	{
		$this->_email = $email;
	}

	/**
	 * @return Contacto
	 */
	public function getTelefono()
	{
		return $this->_telefono;
	}

	/**
	 * @param Contacto $telefono
	 */
	public function setTelefono(Contacto $telefono)
	{
		$this->_telefono = $telefono;
	}

	/**
	 * @return Contacto
	 */
	public function getCelular()
	{
		return $this->_celular;
	}

	/**
	 * @param Contacto $celular
	 */
	public function setCelular(Contacto $celular)
	{
		$this->_celular = $celular;
	}

	/**
	 * @return string
	 */
	public function getDomicilio()
	{
		return $this->_domicilio;
	}

	/**
	 * @param $domicilio
	 */
	public function setDomicilio($domicilio)
	{
		$this->_domicilio = $domicilio;
	}

	/**
	 * @return Provincia
	 */
	public function getProvincia()
	{
		return $this->_provincia;
	}

	/**
	 * @param Provincia $provincia
	 */
	public function setProvincia(Provincia $provincia)
	{
		$this->_provincia = $provincia;
	}

	/**
	 * @return string
	 */
	public function getLocalidad()
	{
		return $this->_localidad;
	}

	/**
	 * @param $localidad
	 */
	public function setLocalidad($localidad)
	{
		$this->_localidad = $localidad;
	}
}