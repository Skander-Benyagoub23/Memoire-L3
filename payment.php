<?php
require "connect.php";
session_start();
$idclient=$_SESSION["idclient"];
$seats=$_SESSION["travel_place"];
$montant=$_SESSION["total_price"];
$bookdate=date("Y-m-d H:i:s");
//  $booktransform = new Datetime($bookdate);
//  $datetonumber=$booktransform->format("ymd");
//  $timetonumber=$booktransform->format("His");
 $booknumber="$idclient".idate("m").idate("d").idate("H").idate("i").idate("s");

if(isset($_POST["pay"])){
if($_SESSION["travel_type"]==1){
    $directpgm=$_SESSION["voyage_direct"];

    $sqlreserve=$connection->prepare("INSERT INTO reservation 
    (`num_reservation`,`nb_place`,`montant_total`,`id_client`,`date_reservation`,`id_org`,`id_org_corr1`,`id_org_corr2`)
     VALUES ('$booknumber','$seats','$montant','$idclient','$bookdate','$directpgm',NULL,NULL)");
     $sqlreserve->execute();
     $sqlupdateseat=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$directpgm'");
     $sqlupdateseat->execute();
}
elseif($_SESSION["travel_type"]==2){
    $onecorrfirst=$_SESSION["corr1_first"];
    $onecorrsec=$_SESSION["corr1_sec"];

    $sqlreservecorr=$connection->prepare("INSERT INTO reservation 
    (`num_reservation`,`nb_place`,`montant_total`,`id_client`,`date_reservation`,`id_org`,`id_org_corr1`,`id_org_corr2`)
     VALUES ('$booknumber','$seats','$montant','$idclient','$bookdate','$onecorrfirst','$onecorrsec',NULL)");
     $sqlreservecorr->execute();

     $sqlupdateseatcorr=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$onecorrfirst'");
     $sqlupdateseatcorr->execute();

     $sqlupdateseatcorr1=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$onecorrsec'");
     $sqlupdateseatcorr1->execute();
     

}
elseif($_SESSION["travel_type"]==3){
    $twocorrfirst=$_SESSION["corr2_first"];
    $twocorrsec=$_SESSION["corr2_sec"];
    $twocorrthird=$_SESSION["corr2_third"];

    $sqlreservecorr2=$connection->prepare("INSERT INTO reservation 
    (`num_reservation`,`nb_place`,`montant_total`,`id_client`,`date_reservation`,`id_org`,`id_org_corr1`,`id_org_corr2`)
     VALUES ('$booknumber','$seats','$montant','$idclient','$bookdate','$twocorrfirst','$twocorrsec','$twocorrthird')");
     $sqlreservecorr2->execute();

     $sqlupdateseatcorr2_1=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$twocorrfirst'");
     $sqlupdateseatcorr2_1->execute();

     $sqlupdateseatcorr2_2=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$twocorrsec'");
     $sqlupdateseatcorr2_2->execute();

     $sqlupdateseatcorr2_3=$connection->prepare("UPDATE pgm_voyage_org SET `place_disp`=(`place_disp`-'$seats') WHERE id_org='$twocorrthird'");
     $sqlupdateseatcorr2_3->execute();
}
$_SESSION["success_message"]="<div style='background-color:#92ffbc;opacity:0.7;color:#009639;border:solid 2px #fff; display :flex;
justify-content:center;align-items:center;position:relative;padding:10px 0;'><h3>Votre réservation a été effectuée avec succès</h3></Div>";
header('location:client.php');
}
?>





<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>CrossBus</title>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
<link rel="stylesheet" href="payment.css">
</head>
<body oncontextmenu='return false' class='snippet-body'>
                            <div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
        
            <h5 class="total-amount">Montant total</h5>
            <div class="amount-container"><span class="amount-text"><?php echo $montant;?> DA</span></div>
        </div><form action="" method="POST">
        <div class="pt-4"> <label class="d-flex justify-content-between"> 
            <span class="label-text label-text-cc-number">Numero de la carte</span>
            <img src="https://img.icons8.com/dusk/64/000000/paypal.png" width="30" class="visa-icon" /></label>
             <input type="tel" name="credit-number" class="form-control credit-card-number" maxlength="19" placeholder="Numero de la carte" required> 
            </div>
        <div class="d-flex justify-content-between pt-4">
            <div> <label><span class="label-text">EXPIRATION</span> </label> <input type="date" name="expiry-date" class="form-control expiry-class" placeholder="MM / YY" required> </div>
            <div> <label><span class="label-text">CVV</span></label> <input type="tel" name="cvv-number" class="form-control cvv-class" maxlength="4" pattern="\d*" required> </div>
        </div>
        <div class="d-flex justify-content-between pt-5 align-items-center"> 
            <button onclick="window.location.href='search.php'" type="button" class="btn cancel-btn">Annuler</button> 
     <button type="input" name='pay' class="btn payment-btn">Valider</button></form>
     </div>
    </div>
</div>
                            <script type='text/javascript'></script>
                            </body>
                            </html>