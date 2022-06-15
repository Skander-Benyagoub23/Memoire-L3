<?php
require "connect.php";
session_start();
$depart=$_SESSION["point_depart"];
$arrive=$_SESSION["point_arrive"];
$traveldate=$_SESSION["travel_date"];
$places=$_SESSION["travel_place"];
$sqlduréeligne=$connection->prepare("SELECT DISTINCT duree FROM ligne WHERE depart='$depart' AND arrive='$arrive'");
$sqlduréeligne->execute();
$datadurée=$sqlduréeligne->fetchAll();
foreach($datadurée as $duree){
    $duréeligne=$duree["duree"];
}

$maxdurée=gettime($duréeligne,"06:00:00");
function subdatetime($t1,$t2){
    $time1=new Datetime($t1);
    $time2=new Datetime($t2);
    $t3=$time1->diff($time2);
   if( $t3->format("%d")>0)
    return $t3->format("%H h %i min +%d jour");
    else
    return $t3->format("%H h %i min");
}

function minustime($t1,$t2){
    $t11=strtotime($t1);
    $t12=strtotime($t2)-strtotime("00:00:00");
    $t13=$t11-$t12;
    return date('Y-m-d H:i:s',$t13);

  }
  
  function gettime($t1,$t2){//calculate arrival date by additioning departure date and duration:
                
    $t11=strtotime($t1);
    $t22=strtotime($t2);
    $t3=strtotime($t2)-strtotime("00:00:00");
    $t4=$t11+$t3;
    return date('Y-m-d H:i:s',$t4);
}?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crossbus</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="search.css">
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
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar" style="background:black;padding:0;">
        <div class="max-width">
            <div class="logo"><a href="client.php">Cross<span>Bus</span></a></div>
            <ul class="menu">
                <li><a href="client.php" class="menu-btn">Accueil</a></li>
                <?php
                if(isset($_SESSION["userclient"])){
                    echo "<li><a href='profile.php' class='menu-btn'>Mon compte</a></li>
                    <li><a href='logout.php' class='menu-btn'>Se déconnecter</a></li>
                    ";
                }else {
                    echo "<li><a href='login.php' class='menu-btn'>Se connecter</a></li>
                <li><a href='signup.php' class='menu-btn'>S'inscrire</a></li>";
                }
                ?>
                <!-- <li><a href="#" class="menu-btn">Conexion</a> </li>   -->
        </div>
    </nav>
    
    <section >
    <div class="max-width" style="margin-top: 50px;">
    <?php
    echo "<div class='search_result'>
        <span>Résultats de recherche: <b>$depart - $arrive</b></span>
    </div>";

    
    $cpt=0;
    $search1=$connection->prepare(
    "SELECT id_org,ligne.depart,ligne.arrive,ligne.duree,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
     FROM pgm_voyage_org 
     INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
     INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
     AND( `date`>='$traveldate'AND`date`<='$traveldate 23:59:59') 
     AND(ligne.Depart='$depart' AND ligne.arrive='$arrive')AND (`place_disp`>=$places)");
    $search1->execute();
    $datasearch1=$search1->fetchAll();
    // $cpt0=$search1->rowCount();
    // echo $cpt0;
    foreach($datasearch1 as $row1){
        $idorg=$row1["id_org"];
        $dep=$row1["depart"];
        $arv= $row1["arrive"];
        $datedep= $row1["date"];
        $timedep=date('H:i',strtotime("$datedep"));
        $date=$row1["date_arrivé"];
        $timearrival=date('H:i',strtotime("$date"));
        $durée= subdatetime($date,$datedep);
        $prixvoyage=($row1["prix"]*$places);
        $cpt=$cpt+1;


        $rev= "               
         <div class='result_container'>
                <div class='up_container'>
                
                    <div class='time_container'>
                        <div class='depart'>
                        <b>$timedep</b>
                        <b>$depart</b>
                        </div>
                        <span><h6>$durée</h6></span>
                        <div class='arrival'>
                        <b>$timearrival</b>
                        <b>$arrive</b>
                        </div>
                   
                    </div>
                 <h4><b>$prixvoyage DA</b></h4>
             </div>

             <div class='buttom_container'>
                <button class='showd1'><i class='fas fa-bus'></i>Voyage direct </button>
                <form action='continue.php' method='post'>
                <input type='hidden' name='mybook' value='$idorg'>
                <input type='hidden' name='total_price0'  value='$prixvoyage'>
                <button type='submit' name='corr0' class='book'>Réserver</button>
                </form>
                
              </div>  
             </div>
        <div>    ";
        echo $rev;
    }
    ?>
        <!-- -------------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------- -->
        <!-- -----------------------------1 correspondance----------------------------- -->
        <!-- -------------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------- -->
<?php
$search=$connection->prepare(
    "SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
     FROM pgm_voyage_org 
     INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
     INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
     AND( `date`>='$traveldate'AND`date`<='$traveldate 23:59:59')
     AND(ligne.Depart='$depart' AND ligne.arrive!='$arrive') AND (`place_disp`>=$places)
     ");
    $search->execute();
    $datasearch=$search->fetchAll();
    // $select="<form action='' method='post'>";
    foreach($datasearch as $row){
        $first=$row["id_org"];
        $firstdep=$row["depart"];
        $firstarv= $row["arrive"];
        $firstdatedep= $row["date"];
        $firsttimedep=date('H:i',strtotime("$firstdatedep"));
        $date=$row["date_arrivé"];
        $firsttimearv=date('H:i',strtotime("$date"));
        $prixvoyage1_1=($row["prix"]*$places);

        $maxdatearv= gettime($firstdatedep,$maxdurée);
        $search2=$connection->prepare(
            "SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
             FROM pgm_voyage_org 
             INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
             INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
             AND(ligne.Depart='$firstarv' AND ligne.arrive='$arrive')
             AND( `date`>=ADDTIME('$date','01:00:00')) AND (`place_disp`>=$places)
              AND( `date_arrivé` <= '$maxdatearv')");
            $search2->execute();
            $datasearch2=$search2->fetchAll();
            // $cpt1=$search2->rowCount();
            
            foreach($datasearch2 as $key){
                $prixvoyage1_2=($key["prix"]*$places);
               $sec=$key["id_org"];
                $secdep=$key["depart"];
                $secarv=$key["arrive"];
                $secdatedep=$key["date"];
                $sectimedep=date('H:i',strtotime("$secdatedep"));
                $secdatearv=$key["date_arrivé"];
                $sectimearv=date('H:i',strtotime("$secdatearv"));
                $duréecorr=subdatetime($secdatedep,$date);
                $prixtotalecorr=$prixvoyage1_1+$prixvoyage1_2;
                $duréevoyage2=subdatetime($firstdatedep,$secdatearv);
               
                
                // if(minustime($secdatedep,$date)<"05:00:00"){
                //     echo minustime($secdatedep,$date);
                $cpt=$cpt+1;
                

                $select="
        
            <div class='result_container'>
                <div class='up_container'>
                
                    <div class='time_container'>
                        <div class='depart'>
                        <b>$firsttimedep</b>
                        <b>$depart</b>
                        </div>
                        <span><h6>$duréevoyage2</h6></span>
                        <div class='arrival'>
                        <b>$sectimearv</b>
                        <b>$arrive</b>
                        </div>
                   
                    </div>
                 <h4><b>$prixtotalecorr DA</b></h4>
             </div>
             <div class='buttom_container'>
                <button class='showd1'><i class='fas fa-bus'></i><i class='fas fa-arrow-right'></i><i class='fas fa-bus'></i>1 Correspondance<i class='fas fa-angle-down'></i></button>
                <form action='continue.php' method='post'>
<input type='hidden' name='correspondance' value='$first'>
<input type='hidden' name='correspondance2' value='$sec'>
<input type='hidden' name='total_price1'  value='$prixtotalecorr'>
<button type='submit' name='corr' class='book'>Réserver</button>
</form>
                
            </div>
            
            <div class='detail hidden'>
                <hr>
                <div class='travel_corr'>
                    <div class='travel_corr_cord'><h6>$firsttimedep</h6><h6><b>$firstdep</b></h6></div>
                    <div class='vertical'></div>
                    <div class='travel_corr_cord'><h6>$firsttimearv</h6><h6><b>$firstarv</b></h6></div>
                </div>
                <hr>
                <div class='corr_time'><h5><i class='fas fa-clock'></i> Durée de la correspondance: $duréecorr</h5></div>
                <hr>
            <div class='travel_corr'>
                <div class='travel_corr_cord'><h6>$sectimedep</h6><h6><b>$secdep</b></h6></div>
                <div class='vertical'></div>
                <div class='travel_corr_cord'><h6>$sectimearv</h6><h6><b>$secarv</b></h6></div>
            </div>
            </div>
            </div>";
            
            echo $select;
            }
            
            //  $select.="</form>";
    }?> 
        <!-- -------------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------- -->
        <!-- -----------------------------2 correspondance----------------------------- -->
        <!-- -------------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------- -->

        <?php
        $search3=$connection->prepare(
            "SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
             FROM pgm_voyage_org 
             INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
             INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
             AND( `date`>='$traveldate'AND`date`<='$traveldate 23:59:59')
             AND(ligne.Depart='$depart' AND ligne.arrive!='$arrive') AND (`place_disp`>=$places)
             ");
            $search3->execute();
            $datasearch3=$search3->fetchAll();
            // $cpt2=$search3->rowCount();
            // echo $cpt2;
            // $select="<form action='' method='post'>";
            foreach($datasearch3 as $row3){
                $first3=$row3["id_org"];
                $firstdep3=$row3["depart"];
                $firstarv3= $row3["arrive"];
                $firstdatedep3= $row3["date"];
                $firsttimedep3=date('H:i',strtotime("$firstdatedep3"));
                $date=$row3["date_arrivé"];
                $firsttimearv3=date('H:i',strtotime("$date"));///////////////////////////////////////////////////////////
                $prixvoyage2_1=($row3["prix"]*$places);
                $maxdatearvcorr= gettime($firstdatedep3,"$maxdurée");
                $search3_2=$connection->prepare(
                    "SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
                     FROM pgm_voyage_org 
                     INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                     INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
                     AND(ligne.Depart='$firstarv3' AND ligne.arrive!='$arrive' AND ligne.arrive!='$depart')
                     AND( `date`>=ADDTIME('$date','01:00:00')) AND (`place_disp`>=$places)
                     ");
                    $search3_2->execute();
                    $datasearch3_2=$search3_2->fetchAll();
        
                    
                    foreach($datasearch3_2 as $key3){
                       $sec3=$key3["id_org"];
                        $secdep3=$key3["depart"];
                        $secarv3=$key3["arrive"];
                        $secdatedep3=$key3["date"];
                        $sectimedep3=date('H:i',strtotime("$secdatedep3"));
                        $secdatearv3=$key3["date_arrivé"];
                        $sectimearv3=date('H:i',strtotime("$secdatearv3"));
                        $prixvoyage2_2=($key3["prix"]*$places);
    
    
    
                        $search3_3=$connection->prepare(
                            "SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,`date_arrivé`,place_disp
                             FROM pgm_voyage_org 
                             INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
                             INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
                             AND(ligne.Depart='$secarv3' AND ligne.arrive='$arrive')
                             AND( `date`>=ADDTIME('$secdatearv3','01:00:00')) AND (`place_disp`>=$places)
                              AND(`date_arrivé`<='$maxdatearvcorr')
                             ");
                            $search3_3->execute();
                            $datasearch3_3=$search3_3->fetchAll();
                            foreach($datasearch3_3 as $key3_3){
    
                                $third3=$key3_3["id_org"];
                        $thirddep3=$key3_3["depart"];
                        $thirdarv3=$key3_3["arrive"];
                        $thirddatedep3=$key3_3["date"];
                        $thirdtimedep3=date('H:i',strtotime("$thirddatedep3"));
                        $thirddatearv3=$key3_3["date_arrivé"];
                        $thirdtimearv3=date('H:i',strtotime("$thirddatearv3"));
                        $prixvoyage2_3=($key3_3["prix"]*$places);
                        $prixtotalecorr2=$prixvoyage2_1+$prixvoyage2_2+$prixvoyage2_3;
                        $duréevoyage3=subdatetime($firstdatedep3,$thirddatearv3);
                        $duréefirstcorr=subdatetime($secdatedep3,$date);
                        $duréeseccorr=subdatetime($thirddatedep3,$secdatearv3);
                        $cpt=$cpt+1;
                       
                        
                            
                        $select3= " 
            <div class='result_container'>
                <div class='up_container'>
                
                    <div class='time_container'>
                        <div class='depart'>
                        <b>$firsttimedep3</b>
                        <b>$depart</b>
                        </div>
                        <span><h6>$duréevoyage3</h6></span>
                        <div class='arrival'>
                        <b>$thirdtimearv3</b>
                        <b>$arrive</b>
                        </div>
                   
                    </div>
                 <h4><b>$prixtotalecorr2 DA</b></h4>
             </div>
             <div class='buttom_container'>
                <button class='showd1'><i class='fas fa-bus'></i><i class='fas fa-arrow-right'></i><i class='fas fa-bus'></i><i class='fas fa-arrow-right'></i><i class='fas fa-bus'></i>2 Correspondance<i class='fas fa-angle-down'></i></button>
                
                <form action='continue.php' method='post'>
                <input type='hidden' name='correspondance3_1' value='$first3'>
                <input type='hidden' name='correspondance3_2' value='$sec3'>
                <input type='hidden' name='correspondance3_3'  value='$third3'>
                <input type='hidden' name='total_price2'  value='$prixtotalecorr2'>
                <button type='submit' name='corr2' class='book'>Réserver</button>
                </form>
                
            </div>
            <div class='detail hidden'>
                <hr>
                <div class='travel_corr'>
                    <div class='travel_corr_cord'><h6>$firsttimedep3</h6><h6><b>$firstdep3</b></h6></div>
                    <div class='vertical'></div>
                    <div class='travel_corr_cord'><h6>$firsttimearv3</h6><h6><b>$firstarv3</b></h6></div>
                </div>
                <hr>
                <div class='corr_time'><h5><i class='fas fa-clock'></i> Durée de la premiére correspondance: $duréefirstcorr</h5></div>
                <hr>
            <div class='travel_corr'>
                <div class='travel_corr_cord'><h6>$sectimedep3</h6><h6><b>$secdep3</b></h6></div>
                <div class='vertical'></div>
                <div class='travel_corr_cord'><h6>$sectimearv3</h6><h6><b>$secarv3</b></h6></div>
            </div>
            <hr>
            <div class='corr_time'><h5><i class='fas fa-clock'></i> Durée de la deuxiéme correspondance: $duréeseccorr</h5></div>
            <hr>
        <div class='travel_corr'>
            <div class='travel_corr_cord'><h6>$thirdtimedep3</h6><h6><b>$thirddep3</b></h6></div>
            <div class='vertical'></div>
            <div class='travel_corr_cord'><h6>$thirdtimearv3</h6><h6><b>$thirdarv3</b></h6></div>
        </div>
            </div>
            </div>";

            echo $select3;



        }

}


//  $select.="</form>";
}
if($cpt==0){
    echo "<div class='result_container' style='display:flex;justify-content:center;align-items:center;'>
    aucun résultat trouvé
    </div>";
}       ?>
           
        </div>
    </section>


    <script>
        $(document).ready(function(){
            
    $('.showd1').click(function(){
        
        $(this).parent().parent().find('.hidden').slideToggle('display');
        $('.showd1').not(this).parent().parent().find('.hidden').slideUp();
        $(this).find('.fa-angle-down').toggleClass('fa-angle-up');
        $('.showd1').not(this).find('.fa-angle-down').removeClass('fa-angle-up');

        
    });

    
});
    </script>