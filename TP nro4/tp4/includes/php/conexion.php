
<?php


try {
    $conexion = new PDO('mysql:host=127.0.0.1;dbname=sgu', 'root', '');
    
} catch(PDOException $e) {
    echo $e->getMessage();
    die();
    
}
