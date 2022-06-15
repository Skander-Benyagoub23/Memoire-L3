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
   $propri=$row["id_proprietaire"];
   $user=$row["id_utilisateur"];
}
if(isset($_POST["editb"])){
    
    $num = $_POST["num_bus"];
    $matricule = $_POST["matricule"];
    $cap = $_POST["capacite"];
    $couleur = $_POST["couleur"];
    $disp = $_POST["disp"];
    $prop = $_POST["id_prop"];
    $util = $_SESSION["idadmin"];
    if(empty($disp)){
        $disp=0;
    }
    else{
        $disp=1;
    }
    
        $stmt = $connection->prepare("UPDATE `bus` SET  `numero`='$num', `matricule`='$matricule', `capacité`='$cap',`couleur`='$couleur',`disp`='$disp',`id_proprietaire`=$prop,`id_utilisateur`='$util' WHERE `id_bus`='$idb' ");
        $stmt->execute();   
        header('location:bus.php') ;
     
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
                <div>Propriétaire</br>
                <select name='id_prop' style="margin-top:10px; width:200px;" required>
                <option value=''>Propriétaire</option>
                <?php
                
                $sqlprop=$connection->prepare("SELECT * FROM propriétaire");
                $sqlprop->execute();
                $dataprop=$sqlprop->fetchAll();
                foreach($dataprop as $row){
                    $idprop=$row["id_proprietaire"];
                    $nomprop=$row["nom_prop"];
                    $prenomprop=$row["prenom_prop"];
                    echo "<option value='$idprop'>$nomprop $prenomprop</option>";
                }
                echo "</select>";
                ?>
                </div>
                <div style="margin-top:20px; margin-left:10px;"></br><span  >Disponible
                <input type='checkbox' name='disp' checked></span></div>
                </div>
                <button  type='submit' class='confirm' name='editb'>Confirmer <i class="fas fa-check"></i></button>
        </form>
        </div>
    </div>