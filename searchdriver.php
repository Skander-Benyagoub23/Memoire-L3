<?php
require "connect.php";
session_start();

$trajet=$_POST["ligne_id"];
$departtimeonly=$_POST["departure"];



if((isset($trajet)) && (isset($departtimeonly))){

    function transformtime($t1){
        $t2=strtotime($t1);
        return date('1900-01-01 H:i:s',$t2);
    }
    $depart=transformtime($departtimeonly);

    $sqldurée = $connection->prepare("SELECT duree
    FROM ligne WHERE id_ligne=$trajet ");
    $sqldurée->execute();
    
    $durée_data=$sqldurée->fetchAll();
    
    foreach($durée_data as $row){
        $time=$row["duree"];
    }
    
    
    function getdatetime($t1,$t2){//calculate arrival date by additioning departure date and duration:
                
    $t11=strtotime($t1);
    $t22=strtotime($t2);
    $t3=strtotime($t2)-strtotime("00:00:00");
    $t4=$t11+$t3;
    return date('Y-m-d H:i:s',$t4);
}

    $arrivé=getdatetime($depart,$time);

    $driverselect=$connection->prepare("SELECT id_pgm_voyage,chauffeur.id_chauffeur,chauffeur.Nom_chauff,chauffeur.Prenom_chauff FROM 
    pgm_voyage RIGHT JOIN chauffeur ON pgm_voyage.id_chauffeur=chauffeur.id_chauffeur 
    AND(( '$depart' BETWEEN heure_départ AND heure_arrivé)
        OR ( '$arrivé' BETWEEN heure_départ AND heure_arrivé)
        OR ( heure_départ BETWEEN '$depart' AND '$arrivé')
        OR ( heure_arrivé BETWEEN '$depart' AND '$arrivé')
     )");
     $driverselect->execute();
     $datadriver=$driverselect->fetchALL();
     echo "<option value=''>Sélectionner un Chauffeur</option>";
     foreach($datadriver as $row){
         $id_voyage=$row["id_pgm_voyage"];
         $id_chauff=$row["id_chauffeur"];
         $nom_chauff=$row["Nom_chauff"];
         $prenom_chauff=$row["Prenom_chauff"];
         
         if(empty($id_voyage)){
            
            echo "<option value='$id_chauff'>$nom_chauff $prenom_chauff</option>";
        }
        else{
            echo "<option value='$id_chauff' disabled>".$nom_chauff.' '.$prenom_chauff.' '.'occupé'."</option>";
        }
     }
    }


?>