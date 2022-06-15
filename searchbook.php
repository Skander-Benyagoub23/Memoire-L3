<?php
require "connect.php";
$dep=$_POST['depart_id'];
if(isset($dep)){
    $search=$connection->prepare("SELECT DISTINCT arrive FROM ligne WHERE `arrive`!='$dep'");
    $search->execute();
    $datasearch=$search->fetchAll();
        foreach($datasearch as $row){
        $arrivé=$row["arrive"];
        echo "<option name='' value='$arrivé' >$arrivé</option>";
    }
    
    }
?>