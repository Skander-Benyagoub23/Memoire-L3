<?php
require "connect.php";
$id=$_POST['id_proprietaire'];
if(isset($_POST['delete'])){
    
$supp = $connection->prepare("DELETE FROM propriétaire where `id_proprietaire`='$id'");
$supp->execute();
header('location:pro.php');
}


?>