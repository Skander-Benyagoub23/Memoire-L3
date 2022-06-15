<?php

$user = "root";
$host = "localhost";
$password = "";
$db = "reservation_bus";

try {
    $connection=new PDO("mysql:host=$host;dbname=$db", $user , $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOExceptation $err) {
    die("Erreur :" . $err->getMessage());
}

?>