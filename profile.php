<?php
require "connect.php";
session_start();
$idclient=$_SESSION["idclient"];
$sqlinfouser=$connection->prepare("SELECT * FROM client WHERE id_client=$idclient");
$sqlinfouser->execute();
$infodata=$sqlinfouser->fetchAll();
foreach($infodata as $row){
    $username=$row["nom_util_client"];
    $email=$row["email_client"];
    $password=$row["password_client"];
    $nom=$row["nom_client"];
    $prenom=$row["prenom_client"];
    $contact=$row["contact_client"];
}

if(isset($_POST["save_info"])){
    $inputusername=$_POST["username"];
    $inputemail=$_POST["email"];
    $inputnom=$_POST["nom"];
    $inputprenom=$_POST["prenom"];
    $inputcontact=$_POST["contact"];

    $sqlverify=$connection->prepare("SELECT id_client FROM client WHERE nom_util_client='$inputusername' AND id_client!=$idclient");
    $sqlverify->execute();
    if($sqlverify->rowCount()!=0){
        $_SESSION["existmessage"]="<p style='color:#f00; margin:0;'>le nom $inputusername existe déja</p>";
    }
    else{
        $sqlupdateclient=$connection->prepare("UPDATE client SET 
        `nom_util_client`='$inputusername',`email_client`='$inputemail',`nom_client`='$nom',`prenom_client`='$prenom',`contact_client`='$contact' WHERE id_client='$idclient' ");
        $sqlupdateclient->execute();
    }
}
if(isset($_POST["save_pass"])){
    $inputnewpass=$_POST["newpass"];
    $inputconfirmpass=$_POST["confirmpass"];
    $inputcurrentpass=$_POST["currentpass"];
    
    if(($inputnewpass==$inputconfirmpass) && ($inputcurrentpass==$password)){
        $sqlupdatepass=$connection->prepare("UPDATE client SET `password_client`='$inputnewpass' WHERE id_client='$idclient'");
        $sqlupdatepass->execute();
    }else{
        $_SESSION["wrongpass"]="<p style='color:#f00; margin:0;'>le mot de passe que vous avez saisie est incorrect</p>";
    }
}
if(isset($_POST["cancel"])){
  $thisbooking=$_POST["idbooking"];
  $thispgmorg=$_POST["pgm_org"];
  $bookedseat=$_POST["seat"];
  $sqlcancel=$connection->prepare("DELETE FROM reservation WHERE id_reservation=$thisbooking");
  $sqlcancel->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorg");
  $seatupdate->execute();
  
}

if(isset($_POST["cancelcorr1"])){
  $thisbooking=$_POST["idbooking"];
  $thispgmorgcorr1_1=$_POST["pgm_org_corr1_1"];
  $thispgmorgcorr1_2=$_POST["pgm_org_corr1_2"];
  $bookedseat=$_POST["seat"];
  $sqlcancel=$connection->prepare("DELETE FROM reservation WHERE id_reservation=$thisbooking");
  $sqlcancel->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorgcorr1_1");
  $seatupdate->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorgcorr1_2");
  $seatupdate->execute();
  
}

if(isset($_POST["cancelcorr2"])){
  $thisbooking=$_POST["idbooking"];
  $thispgmorgcorr2_1=$_POST["pgm_org_corr2_1"];
  $thispgmorgcorr2_2=$_POST["pgm_org_corr2_2"];
  $thispgmorgcorr2_3=$_POST["pgm_org_corr2_3"];
  $bookedseat=$_POST["seat"];
  $sqlcancel=$connection->prepare("DELETE FROM reservation WHERE id_reservation=$thisbooking");
  $sqlcancel->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorgcorr2_1");
  $seatupdate->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorgcorr2_2");
  $seatupdate->execute();
  $seatupdate=$connection->prepare("UPDATE pgm_voyage_org SET place_disp=place_disp+$bookedseat WHERE id_org=$thispgmorgcorr2_3");
  $seatupdate->execute();
  
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crossbus</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="account.css">
    <link rel="stylesheet" href="style22.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar" style="background:black;padding:0;">
        <div class="max-width">
            <div class="logo"><a href="client.php">Cross<span>Bus</span></a></div>

            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="menu">
                <li><a href="client.php" class="menu-btn">Accueil</a></li>
                <li><a href="#reservation" class="menu-btn">Réservations</a></li>
                <li><a href="#info" class="menu-btn">Utilisateur</a></li>
                <li><a href='#' class='menu-btn'>Mon compte</a></li>
                <li><a href='logout.php' class='menu-btn'>Se déconnecter</a></li>          
            </ul>
        </div>
    </nav>

    <section >
    <div class="max-width" >

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <div class="main-content">
    <div class="container mt-7">
      <!-- Table -->
      <div class="row">
        <div class="col-xl-8 m-auto order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div  class="row align-items-center">
                <div id="info" class="col-8">
                  <h3 class="mb-0">Mon compte</h3>
                </div>
    
              </div>
            </div>
            <div class="card-body">
              <form action="" method="POST">
                <h6 class="heading-small text-muted mb-4">Information de l'utilisateur</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <?php
                        if(isset($_SESSION["existmessage"])){
                            echo $_SESSION["existmessage"];
                            unset($_SESSION["existmessage"]);
                        }
                        ?>
                    </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Nom d'utilisateur</label>
                        <input type="text" name="username" class="form-control form-control-alternative" placeholder="Nom d'utilisateur" value="<?php echo $username;?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-alternative" placeholder="jesse@example.com" value="<?php echo $email;?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Nom</label>
                        <input type="text" name="nom" class="form-control form-control-alternative" placeholder="Nom" value="<?php echo $nom;?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Prénom</label>
                        <input type="text" name="prenom"  class="form-control form-control-alternative" placeholder="Prénom" value="<?php echo $prenom;?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Contact</label>
                        <input type="number" name="contact" class="form-control form-control-alternative" placeholder="Contact" value="<?php echo $contact;?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <button type="submit" name="save_info" class='save_info_btn'>Enregistrer</button> 
                  </div>
                </div>
                    </form>
                <hr class="my-4">
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Mot de passe</h6>
                <div class="pl-lg-4">
                <div class="row">
                        <?php
                        if(isset($_SESSION["wrongpass"])){
                            echo $_SESSION["wrongpass"];
                            unset($_SESSION["wrongpass"]);
                        }
                        ?>
                    </div>
                  <div class="row">
                    <div class="col-lg-4">
                    <form action="" method="POST">
                      <div class="form-group focused">
                        <label class="form-control-label" >Nouveau mot de passe</label>
                        <input type="password"  name="newpass" class="form-control form-control-alternative" required >
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" >Confirmer mot de passe</label>
                        <input type="password"  name="confirmpass" class="form-control form-control-alternative" required>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" >Mot de passe actuel</label>
                        <input type="password" name="currentpass"  class="form-control form-control-alternative" >
                      </div>
                    </div>
                  </div>
                  <div id="reservation" class="row">
                    <button type="submit" name="save_pass" class='save_info_btn'>Enregistrer</button> 
                  </div>
                </div>
                <hr class="my-4">
              </form>
              <h6 class="heading-small text-muted mb-4">Mes réservations</h6>
              <!-- Voyage direct -->
              <?php
              $sqlresrvation=$connection->prepare("SELECT id_reservation,num_reservation,nb_place,montant_total,date_reservation,id_org,id_org_corr1,id_org_corr2 FROM reservation WHERE id_client=$idclient");
              $sqlresrvation->execute();
              $reservation_data=$sqlresrvation->fetchAll();
              if($sqlresrvation->rowCount()==0){
                echo "<div class='row'>
                <div class='no_booking'>
                <span><h4>aucune réservation éffectuée</h4></span>
                </div>
                </div>";
              }
              else{
              function minustime($t1,$t2){
                $t11=strtotime($t1);
                $t12=strtotime($t2)-strtotime("00:00:00");
                $t13=$t11-$t12;
                return date('Y-m-d H:i:s',$t13);

              }
              function subdatetime($t1,$t2){
                $time1=new Datetime($t1);
                $time2=new Datetime($t2);
                $t3=$time1->diff($time2);
               if( $t3->format("%d")>0)
                return $t3->format("%H h %i min +%d jour");
                else
                return $t3->format("%H h %i min");
            }
              foreach($reservation_data as $reserve){
                $idbooking=$reserve["id_reservation"];
                $booking_number=$reserve["num_reservation"];
                $booking_seat=$reserve["nb_place"];
                $booking_amount=$reserve["montant_total"];
                $booking_date=$reserve["date_reservation"];
                $booking_pgm=$reserve["id_org"];
                $booking_pgmcorr1=$reserve["id_org_corr1"];
                $booking_pgmcorr2=$reserve["id_org_corr2"];
                $current_date=date('Y-m-d H:i:s');
                $minus_30=minustime($current_date,"00:30:00");

                if((empty($booking_pgmcorr1))&&(empty($booking_pgmcorr2))){
                  $normaltravel=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                   INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                  INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgm ");
                  $normaltravel->execute();
                  $datanormal=$normaltravel->fetchAll();
                  foreach($datanormal as $normal){
                    $departure=$normal["depart"];
                    $arrival=$normal["arrive"];
                    $departure_date=$normal["date"];
                    $format_dep=date('d-m-Y H:i:s',strtotime($departure_date));
                    $arrival_date=$normal["date_arrivé"];
                    $format_arv=date('d-m-Y H:i:s',strtotime($arrival_date));
                  }

                  echo"<div class='row'>
                  <div class='booking_box'>
                      <div class='up_part_box'>
                      <span><i class='fa fa-bus'></i> <b>$departure - $arrival</b></span>
                      <span>numero-reservation:<b> $booking_number</b></span>
                  </div>
                  <div class='date_box'>
                      <span>Départ: $format_dep</span></br>
                      <span>Arrivé: $format_arv</span>
                  </div>
                  <div>
                     <span>Prix payé: <b>$booking_amount DA</b></span>
                  </div>
                  <div class='bottom_part_box'>
                     <span>Place(s) réservée(s): <b>$booking_seat</b></span>";
                     if($departure_date > $minus_30){
                    echo "<form action='' method='POST'>
                    <input type='hidden' name='pgm_org' value='$booking_pgm'>
                    <input type='hidden' name='seat' value='$booking_seat'>
                    <input type='hidden' name='idbooking' value='$idbooking'>
                    <button  type='submit' name='cancel' class='cancel'>Annuler la réservation</button>
                    </form>";
                    }elseif($departure_date <= $minus_30){
                      echo "<div>
                      <span>réservation terminé</span>
                            </div>";
                    }
                 echo "</div>
              </div>
              </div>
              <hr class='my-4'>";
                }
               
                // 1correspondance

                elseif(empty($booking_pgmcorr2)){

                  $corr1_1=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                   INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                  INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgm ");
                  $corr1_1->execute();
                  $datacorr1_1=$corr1_1->fetchAll();
                  foreach($datacorr1_1 as $correspondance1_1){
                    $corr1_1_departure=$correspondance1_1["depart"];
                    $corr1_1_arrival=$correspondance1_1["arrive"];
                    $corr1_1_departure_date=$correspondance1_1["date"];
                    $corr1_1_format_dep=date('d-m-Y H:i:s',strtotime($corr1_1_departure_date));
                    $corr1_1_arrival_date=$correspondance1_1["date_arrivé"];
                    $corr1_1_format_arv=date('d-m-Y H:i:s',strtotime($corr1_1_arrival_date));
                  }

                  $corr1_2=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                  INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                 INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgmcorr1 ");
                 $corr1_2->execute();
                 $datacorr1_2=$corr1_2->fetchAll();
                 foreach($datacorr1_2 as $correspondance1_2){
                   $corr1_2_departure=$correspondance1_2["depart"];
                   $corr1_2_arrival=$correspondance1_2["arrive"];
                   $corr1_2_departure_date=$correspondance1_2["date"];
                   $corr1_2_format_dep=date('d-m-Y H:i:s',strtotime($corr1_2_departure_date));
                   $corr1_2_arrival_date=$correspondance1_2["date_arrivé"];
                   $corr1_2_format_arv=date('d-m-Y H:i:s',strtotime($corr1_2_arrival_date));
                   $durée_corr=subdatetime($corr1_2_departure_date,$corr1_1_arrival_date);
                 }
                 echo"<div class='row'>
                 <div class='booking_box'>
                     <div class='up_part_box'>
                     <span><i class='fa fa-bus'></i> <b>$corr1_1_departure - $corr1_2_arrival</b></span>
                     <span>numero-reservation:<b> $booking_number</b></span>
                 </div>
                 <div class='date_box'>
                     <span>Départ: $corr1_1_format_dep</span></br>
                     <span>Arrivé: $corr1_2_format_arv</span>
                 </div>
                 <div>
                    <span>Prix payé: <b>$booking_amount DA</b></span>
                 </div>
                 <div class='bottom_part_box'>
                    <span>Place(s) réservée(s): <b>$booking_seat</b></span>";
                    if($corr1_1_departure_date > $minus_30){
                      echo "<form action='' method='POST'>
                      <input type='hidden' name='pgm_org_corr1_1' value='$booking_pgm'>
                      <input type='hidden' name='seat' value='$booking_seat'>
                      <input type='hidden' name='pgm_org_corr1_2' value='$booking_pgmcorr1'>
                      <input type='hidden' name='idbooking' value='$idbooking'>
                      <button  type='submit' name='cancelcorr1' class='cancel'>Annuler la réservation</button>
                      </form>";
                      }elseif($corr1_1_departure_date <= $minus_30){
                        echo "<div>
                        <span>réservation terminé</span>
                              </div>";
                      }
  
              echo" </div>
                 <div>
                     <button class='display_corr'>Correspondance <i class='fas fa-angle-down'></i></button>
                 </div>
                 <div class='corr1'>
                     <div>
                 <span><i class='fa fa-bus'></i> <b>$corr1_1_departure - $corr1_1_arrival</b></span>
                 </div>
                 <div class='date_box'>
                     <span>Départ:$corr1_1_format_dep</span></br>
                     <span>Arrivé:$corr1_1_format_arv</span>
                 </div>
                 <div class='corr_time'>
                     <span>Durée de la correspondance:<b> $durée_corr</b></span></br>
                 </div>
                 <div>
                 <span><i class='fa fa-bus'></i> <b>$corr1_2_departure - $corr1_2_arrival</b></span>
                 </div>
                 <div class='date_box'>
                     <span>Départ:$corr1_2_format_dep</span></br>
                     <span>Arrivé:$corr1_2_format_arv</span>
                 </div>
             </div>
             </div>
             </div>
             <hr class='my-4'> ";
                }
                else{
                  // 2correspondance
                  $corr2_1=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                  INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                 INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgm ");
                 $corr2_1->execute();
                 $datacorr2_1=$corr2_1->fetchAll();
                 foreach($datacorr2_1 as $correspondance2_1){
                   $corr2_1_departure=$correspondance2_1["depart"];
                   $corr2_1_arrival=$correspondance2_1["arrive"];
                   $corr2_1_departure_date=$correspondance2_1["date"];
                   $corr2_1_format_dep=date('d-m-Y H:i:s',strtotime($corr2_1_departure_date));
                   $corr2_1_arrival_date=$correspondance2_1["date_arrivé"];
                   $corr2_1_format_arv=date('d-m-Y H:i:s',strtotime($corr2_1_arrival_date));
                 }

                 $corr2_2=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                 INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgmcorr1 ");
                $corr2_2->execute();
                $datacorr2_2=$corr2_2->fetchAll();
                foreach($datacorr2_2 as $correspondance2_2){
                  $corr2_2_departure=$correspondance2_2["depart"];
                  $corr2_2_arrival=$correspondance2_2["arrive"];
                  $corr2_2_departure_date=$correspondance2_2["date"];
                  $corr2_2_format_dep=date('d-m-Y H:i:s',strtotime($corr2_2_departure_date));
                  $corr2_2_arrival_date=$correspondance2_2["date_arrivé"];
                  $corr2_2_format_arv=date('d-m-Y H:i:s',strtotime($corr2_2_arrival_date));
                  $durée_corr2_2=subdatetime($corr2_2_departure_date,$corr2_1_arrival_date);
                }

                $corr2_3=$connection->prepare("SELECT ligne.depart,ligne.arrive,`date`,`date_arrivé` FROM pgm_voyage_org
                 INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne WHERE id_org=$booking_pgmcorr2 ");
                $corr2_3->execute();
                $datacorr2_3=$corr2_3->fetchAll();
                foreach($datacorr2_3 as $correspondance2_3){
                  $corr2_3_departure=$correspondance2_3["depart"];
                  $corr2_3_arrival=$correspondance2_3["arrive"];
                  $corr2_3_departure_date=$correspondance2_3["date"];
                  $corr2_3_format_dep=date('d-m-Y H:i:s',strtotime($corr2_3_departure_date));
                  $corr2_3_arrival_date=$correspondance2_3["date_arrivé"];
                  $corr2_3_format_arv=date('d-m-Y H:i:s',strtotime($corr2_3_arrival_date));
                  $durée_corr2_3=subdatetime($corr2_3_departure_date,$corr2_2_arrival_date);
                }

                echo "<div class='row'>
                <div class='booking_box'>
                    <div class='up_part_box'>
                    <span><i class='fa fa-bus'></i> <b>$corr2_1_departure - $corr2_3_arrival</b></span>
                    <span>numero-ticket:<b> $booking_number</b></span>
                </div>
                <div class='date_box'>
                    <span>Départ: $corr2_1_format_dep</span></br>
                    <span>Arrivé: $corr2_3_format_arv</span>
                </div>
                <div>
                   <span>Prix payé: <b>$booking_amount DA</b></span>
                </div>
                <div class='bottom_part_box'>
                   <span>Place(s) réservée(s): <b>$booking_seat</b></span>";
                   if($corr2_1_departure_date > $minus_30){
                    echo "<form action='' method='POST'>
                    <input type='hidden' name='pgm_org_corr2_1' value='$booking_pgm'>
                    <input type='hidden' name='seat' value='$booking_seat'>
                    <input type='hidden' name='pgm_org_corr2_2' value='$booking_pgmcorr1'>
                    <input type='hidden' name='pgm_org_corr2_3' value='$booking_pgmcorr2'>
                    <input type='hidden' name='idbooking' value='$idbooking'>
                    <button  type='submit' name='cancelcorr2' class='cancel'>Annuler la réservation</button>
                    </form>";
                    }elseif($corr2_1_departure_date <= $minus_30){
                      echo "<div>
                      <span>réservation terminé</span>
                            </div>";
                    }  
              echo"  </div>
                <div>
                    <button class='display_corr'>Correspondance <i class='fas fa-angle-down'></i></button>
                </div>
                <div class='corr1'>
                    <div>
                <span><i class='fa fa-bus'></i> <b>$corr2_1_departure - $corr2_1_arrival</b></span>
                </div>
                <div class='date_box'>
                    <span>Départ:$corr2_1_format_dep</span></br>
                    <span>Arrivé:$corr2_1_format_arv</span>
                </div>
                <div class='corr_time'>
                    <span>Durée de la correspondance:<b> $durée_corr2_2</b></span></br>
                </div>
                <div>
                <span><i class='fa fa-bus'></i> <b>$corr2_2_departure - $corr2_2_arrival</b></span>
                </div>
                <div class='date_box'>
                    <span>Départ:$corr2_2_format_dep</span></br>
                    <span>Arrivé:$corr2_2_format_arv</span>
                </div>
                <div class='corr_time'>
                    <span>Durée de la correspondance:<b> $durée_corr2_3</b></span></br>
                </div>
                <div>
                <span><i class='fa fa-bus'></i> <b>$corr2_3_departure - $corr2_3_arrival</b></span>
                </div>
                <div class='date_box'>
                    <span>Départ:$corr2_3_format_dep</span></br>
                    <span>Arrivé:$corr2_3_format_arv</span>
                </div>
            </div>
            </div>
            </div>
            <hr class='my-4'>";
                }
              }
              }
              ?>
            
            
          </div>
        </div>
      </div>
      
    </div>
  </div>

    </div>
    </section>
    <script src="script.js"></script>
    <script>
        $(document).ready(function(){
            
    $('.display_corr').click(function(){
        
        $(this).parent().parent().find('.corr1').slideToggle('displayed');
        $('.display_corr').not(this).parent().parent().find('.corr1').slideUp();
        $(this).find('.fa-angle-down').toggleClass('fa-angle-up');
        $('.display_corr').not(this).find('.fa-angle-down').removeClass('fa-angle-up');

        
    });

    
});
    </script>