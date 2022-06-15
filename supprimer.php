<?php
require"connect.php";
if(isset($_POST['delete'])){
    $id=$_POST['id_ligne'];
$supp = $connection->prepare("DELETE FROM ligne where `id_ligne`='$id'");
$supp->execute();
}
header('location:table.php');

?>
