<?php

require "connect.php";
session_start();
$ligneid=$_POST["ligne_id"];
$deptimeonly=$_POST["departure"];





if((isset($ligneid)) && (isset($deptimeonly))){
    
    function transformtime($t1){
    $t2=strtotime($t1);
    return date('1900-01-01 H:i:s',$t2);
}
$deptime=transformtime($deptimeonly);

$sqldurée = $connection->prepare("SELECT duree
FROM ligne WHERE id_ligne=$ligneid ");
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

// function maxtime($t1,$t2){//return the biggest time value
//     $t11=strtotime($t1);
//     $t22=strtotime($t2);
// return date('H:i:s',max($t11,$t22)) ;
// }
$arv=getdatetime($deptime,$time);

$_SESSION["trajet"]=$ligneid;
$_SESSION["departure_time"]=$deptime;
$_SESSION["arrival_time"]=$arv;
    $busselect=$connection->prepare("SELECT id_pgm_voyage,bus.id_bus,bus.matricule,bus.capacité,bus.disp FROM 
    pgm_voyage RIGHT JOIN BUS ON pgm_voyage.id_bus=bus.id_bus 
    AND(( '$deptime' BETWEEN heure_départ AND heure_arrivé)
        OR ( '$arv' BETWEEN heure_départ AND heure_arrivé)
        OR ( heure_départ BETWEEN '$deptime' AND '$arv')
        OR ( heure_arrivé BETWEEN '$deptime' AND '$arv') 
     )AND (bus.disp=1)");
     $busselect->execute();
     $databus=$busselect->fetchALL();
     echo "<option value=''>Sélectionner un Bus</option>";
     foreach($databus as $row){
        $pgmvoy=$row["id_pgm_voyage"];
        $bus=$row["id_bus"];
        $mat=$row["matricule"];
        $disponible=$row["disp"];
        if($disponible==1){

          if(empty($pgmvoy)){
            
            echo "<option value='$bus'>$mat</option>";
        }
        else{
           echo "<option value='$bus' disabled >".$mat.' '.'occupé'."</option>";
        }

        }
       elseif($disponible==0){
        echo "<option value='$bus' disabled >".$mat.' '.'en panne'."</option>";
       }
    
    }




}
// if(maxtime($deptime,$arv)==$arv){ // case when departure and arrival time happen in the same day
//     $busselect=$connection->prepare("SELECT id_pgm_voyage,bus.id_bus,bus.matricule,bus.capacité FROM 
//     pgm_voyage RIGHT JOIN BUS ON pgm_voyage.id_bus=bus.id_bus 
//     AND(( heure_départ BETWEEN '$deptime' AND '$arv')
//      OR (heure_arrivé BETWEEN '$deptime' AND '$arv'))");
//      $busselect->execute();
//      $databus=$busselect->fetchALL();
//      foreach($databus as $row){
//         $pgmvoy=$row["id_pgm_voyage"];
//         $bus=$row["id_bus"];
//         $mat=$row["matricule"];
//         if(empty($pgmvoy)){
            
//             echo "<option value='$bus'>$mat</option>";
//         }
//         else{
//            echo "<option value='$bus' disabled >".$mat.' '.'occupé'."</option>";
//         }
//     }

// }else if(maxtime($deptime,$arv)==$deptime){ // case when arrival time happen in the next day
?>
