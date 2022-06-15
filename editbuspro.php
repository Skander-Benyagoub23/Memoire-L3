<?php require "connect.php";
session_start();
$idb=$_GET['id_bus'];
$stmts = $connection->prepare("SELECT * FROM bus WHERE `id_bus`=$idb");
$stmts->execute();
$tmts_data=$stmts->fetchAll();
foreach($tmts_data as $row){
    $nbr=$row["numero"];
    $mat=$row["matricule"];
   $capc=$row["capacité"];
    $clr=$row["couleur"];
}
if(isset($_POST["editb"])){
    
    $num = $_POST["num_bus"];
    $matricule = $_POST["matricule"];
    $cap = $_POST["capacite"];
    $couleur = $_POST["couleur"];
    $disp = $_POST["disp"];
    if(empty($disp)){
        $disp=0;
    }
    else{
        $disp=1;
    }
    
        $stmt = $connection->prepare("UPDATE `bus` SET  `numero`='$num', `matricule`='$matricule', `capacité`='$cap',`couleur`='$couleur',`disp`='$disp' WHERE `id_bus`='$idb' ");
        $stmt->execute();   
        header('location:proppage.php') ;
     
}




?>
<link rel="stylesheet" href="table.css">
<link rel="stylesheet" href="fontawesome/css/all.css">
<title>CrossBus</title>
<div id='edit_table' class='update_background'>
        <div  class='form_update' style="height:350;">
        <form action="" class='edit_form' method='post'>
        <div class='input_popup_container'>
                <div>Numero bus</br>
                <input type='number' min='1' name='num_bus'  placeholder='Num-Bus' value='<?php echo $nbr?>' ></div>
                <div>Matricule</br>
                <input type='text' name='matricule'  placeholder='Matricule' value='<?php echo $mat;?>' ></div>
                <div>Capacité</br>
                <input type='number' min='1' name='capacite' placeholder='Capacité' value='<?php echo $capc;?>'></div>
                <div>Couleur</br>
                <input type='text' name='couleur' placeholder='Couleur' value='<?php echo $clr;?>'></div>
                <div style="margin-top:20px; margin-left:10px;"></br><span  >Disponible
                <input type='checkbox' name='disp' checked></span></div>
                </div>
                <button  type='submit' class='confirm' name='editb'>Confirmer <i class="fas fa-check"></i></button>
        </form>
        </div>
    </div>