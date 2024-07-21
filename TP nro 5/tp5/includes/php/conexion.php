<?php

function conectarDB()
{
	$pdo = new PDO('mysql:host=127.0.0.1;dbname=sgu', 'root', '1234');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $pdo;
}