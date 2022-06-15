<?php
session_start();
$client=$_SESSION["idclient"];

if(isset($client)){

  if(isset($_POST["corr0"])){
    $_SESSION["travel_type"]=1;
    $_SESSION["voyage_direct"]=$_POST["mybook"];
    $_SESSION["total_price"]=$_POST["total_price0"];
    header('location:payment.php');

} 
else if(isset($_POST["corr"])){
    $_SESSION["travel_type"]=2;
    $_SESSION["corr1_first"]=$_POST["correspondance"];
    $_SESSION["corr1_sec"]=$_POST["correspondance2"];
    $_SESSION["total_price"]=$_POST["total_price1"];
    header('location:payment.php');
}
else if(isset($_POST["corr2"])){
    $_SESSION["travel_type"]=3;
    $_SESSION["corr2_first"]=$_POST["correspondance3_1"];
    $_SESSION["corr2_sec"]=$_POST["correspondance3_2"];
    $_SESSION["corr2_third"]=$_POST["correspondance3_3"];
    $_SESSION["total_price"]=$_POST["total_price2"];
    header('location:payment.php');
}
}
else{
    header('location:login.php');
}


?>