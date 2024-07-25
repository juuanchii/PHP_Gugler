<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/tp5/includes/php/ValueObject/ValueObject.php';

abstract class ActiveRecord
{
	abstract public function get();
	abstract public function set(ValueObject $value);
	abstract public function fetch($id);
	abstract public function insert();
	abstract public function update();
	abstract public function delete($id);
}