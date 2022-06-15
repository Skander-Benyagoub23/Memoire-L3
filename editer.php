<?php
require "connect.php";
session_start();

$id=$_GET['id_ligne'];
$stmtl = $connection->prepare("SELECT * FROM ligne WHERE `id_ligne`=$id");
$stmtl->execute();
$tmtl_data=$stmtl->fetchAll();
foreach($tmtl_data as $row){
    $dpr=$row["depart"];
    $arv=$row["arrive"];
   $dur=$row["duree"];
   
}
if(isset($_POST["submit"])){
    
    $depart = $_POST["depart"];
    $arrive = $_POST["arrive"];
    $durée = $_POST["duree"];
    $user=$_SESSION["idadmin"];
        $stmt = $connection->prepare("UPDATE `ligne` SET  `depart`='$depart', `arrive`='$arrive', `duree`='$durée', `id_utilisateur`='$user' WHERE `id_ligne`='$id' ");
        $stmt->execute();    
   
header('location:table.php') ;  
}





?>

<link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <div id='edit_table' class='update_background'>
    <title>Ligne</title>

<div id='edit_table' class='update_background'>
<div  class='form_update' style="height: 300px;">
        <form action="" class='edit_form' method='post'>
        <div class='input_popup_container'>
        <div>Depart</br>
            <input type="text" name="depart"  placeholder="Départ" value='<?php echo $dpr;?>'  ></div>
                <div>Arrivé</br>
                <input type="text" name="arrive" placeholder="Arrivé" value='<?php echo $arv;?>' ></div>
                <div>Durée</br>
                <input type="time" name="duree" placeholder="Durée" value='<?php echo $dur;?>'></div>
               
                </div>
                <button  type='submit' class='confirm' name='submit'>Confirmer <i class="fas fa-check"></i></button>
                </div>
                
        </form>
        </div>
    </div>
