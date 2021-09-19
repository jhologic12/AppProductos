<?php

$servidor= "mysql:dbname=bdproductos;host=127.0.0.1";
$usuario="root";
$password="";



try {

    $pdo = new PDO($servidor,$usuario,$password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado..";


} catch (PDOException $e) {


    echo "Conexion mala :(".$e->getMessage();
}

?>