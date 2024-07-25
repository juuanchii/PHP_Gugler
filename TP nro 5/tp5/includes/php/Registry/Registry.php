<?php

class Registry {

    private $_data = array();

	public function add($key, $data)
	{
		$this->_data[$key] = $data;
	}

	public function get($key)
	{
		return $this->_data[$key];
	}

	public function delete($key)
	{
		unset($this->_data[$key]);
	}

	public function exists($key)
	{
		if(isset($this->_data[$key])){
            return true;
        } else {
            return false;
        }
	}
}

?>