<?php
session_start();
require "connect.php";
if(isset($_POST['deletepgm'])){
    $idpgm=$_POST['id_pgm'];

 $supporg = $connection->prepare("DELETE FROM pgm_voyage where `id_pgm_voyage`='$idpgm'");
$supporg->execute();
   
$supp = $connection->prepare("DELETE FROM pgm_voyage where `id_pgm_voyage`='$idpgm'");
$supp->execute();
header('location:sidebar.php');
}
?>
<link rel="stylesheet" href="table.css">
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Cross Bus</title>
        <link rel="stylesheet" href="fontawesome/css/all.css">

        <link rel="stylesheet" href="style1.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    </head>
    <body>
        <!--wrapper start-->
        <div class="wrapper">
        <div id='edit_profile' class="update_background">
        <div class="form_update">
            <button id='close'><i class="fas fa-x"></i></button>

            <?php
            $idadmin=$_SESSION["idadmin"];
            $sqladmin=$connection->prepare("SELECT * FROM utilisateur WHERE id_utilisateur=$idadmin");
            $sqladmin->execute();
            $dataadmin=$sqladmin->fetchAll();
            foreach($dataadmin as $admin){
                $nom=$admin["nom_util"];
                $prenom=$admin["prenom_util"];
                $num=$admin["Contact_util"];
                $mail=$admin["email_util"];
                $username=$admin["nom_utilisateur"];
                $password=$admin["password_util"];
            }
            if(isset($_POST["confirm"])){

                    $nameadm=$_POST["nameadmin"];
                    $firtname=$_POST["prenomadm"];
                    $mailadm=$_POST["mailadm"];
                    $contactadm=$_POST["numadm"];
                    $usernameadm=$_POST["usernameadm"];
                    $newpass=$_POST["newpass"];
                    $confirm=$_POST["confirmpass"];
                if(empty($newpass) && empty($confirm)){
                    $_SESSION["useradmin"]=$usernameadm;
                    $sqlupdate=$connection->prepare("UPDATE `utilisateur` SET
                    `nom_util`='$nameadm',`prenom_util`='$firtname',`Contact_util`='$contactadm',`email_util`='$mailadm',`nom_utilisateur`='$usernameadm' WHERE `id_utilisateur`=$idadmin");
                    $sqlupdate->execute();
                    echo "<script> alert(\"Donnés modifié avec succès\");</script>";
                }
                elseif(!empty($newpass))
                {
                    if($confirm == $password){
                        $sqlupdate=$connection->prepare("UPDATE `utilisateur` SET
                    `nom_util`='$nameadm',`prenom_util`='$firtname',`Contact_util`='$contactadm',`email_util`='$mailadm',`nom_utilisateur`='$usernameadm',`password_util`='$newpass' WHERE `id_utilisateur`=$idadmin");
                    $sqlupdate->execute();
                    echo "<script> alert(\"Donnés modifié avec succès\");</script>";
                    }
                    else {
                       echo "<script> alert(\"Echec de l'operation: mot de passe incorrect\");</script>";
                    }
                }

            }
            ?>
            <form action="" class='edit_form' method='post'>
                <div class='input_popup_container'>
                <div>Nom</br><input type='text' name='nameadmin' placeholder='nom' value='<?php echo $nom?>'></div>
                <div>Prenom</br>
                <input type='text' name='prenomadm' placeholder='prenom' value='<?php echo $prenom?>'></div>
                <div> Adresse-mail</br>
                <input type='text' name='mailadm' placeholder='adresse-mail' value='<?php echo $mail?>'></div>
                <div>Contact</br>
                <input type='text' name='numadm' placeholder='contact' value='<?php echo $num?>'></div>
                <div>Nom utilsateur</br>
                <input type='text' name='usernameadm' placeholder='username' value='<?php echo $username?>'></div>
                <div class='hide'>f</br>
                <input type='text' placeholder=''></div>
                <div>Nouveau mot de passe</br>
                <input type='password' name='newpass' placeholder=''></div>
                <div>Mot de passe actuel</br>
                <input type='password' name='confirmpass' placeholder=''></div>
                </div>
                <button  type='submit' class='confirm' name='confirm'>Confirmer <i class="fas fa-check"></i></button>
            </form>
            
        </div>
    </div>
            <!--header menu start-->
            <div class="header">
                <div class="header-menu">
                    <div class="title">Cross <span>Bus</span></div>
                    <div class="sidebar-btn">
                        <i class="fas fa-bars"></i>
                    </div>
                    <ul>
                        <li><a href="#"><i class="fas fa-power-off"></i></a></li>
                    </ul>
                </div>
            </div>
            <!--header menu end-->
            <!--sidebar start-->
            <div class="sidebar">
                <div class="sidebar-menu">
                    <center class="profile">
                        <img src="admin.png" alt="">
                        <p><?php echo $_SESSION["useradmin"]; ?></p>
                    </center>
                    <li class="item">
                        <a href="home.php" class="menu-btn">
                            <i class="fas fa-desktop"></i><span>Accueil</span>
                        </a>
                    </li>
                    <li class="item" id="profile">
                        <a href="#profile" class="menu-btn">
                        <i class="fa-solid fa-calendar-day"></i><span>Horaire et date<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                            <a href="sidebar.php"><i class="fa-solid fa-clock"></i><span>Horaire</span></a>
                            <a href="pgm_voyage_org.php"><i class="fa-solid fa-calendar-day"></i><span>Date</span></a>
                        </div>
                    </li>
                    <li class="item" id="messages">
                        <a href="#messages" class="menu-btn">
                            <i class="fas fa-list-alt"></i><span>Autre<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                        <?php
                            if(isset($_SESSION["super_admin"])){
                           echo "<a href='newuser.php'><i class='fas fa-user'></i><span>Utilisateur</span></a>";
                        }
                            ?>
                            <a href="pro.php"><i class="fas fa-user-tie"></i><span>Propriétaire</span></a>
                            <a href="chauffeur.php"><i class="fas fa-address-card"></i><span>Chauffeur</span></a>
                            <a href="bus.php"><i class="fas fa-bus"></i><span>Bus</span></a>
                            <a href="table.php"><i class="fas fa-route"></i><span>Ligne</span></a>
                        </div>
                    </li>
                    <li class="item" id="settings">
                        <a href="#settings" class="menu-btn">
                            <i class="fas fa-cog"></i><span>Option<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                            <a href="#" id='update_profile'><i class="fas fa-lock"></i><span>Modifier profil</span></a>
                           <a href="logout.php" name="signout"><i class="fa-solid fa-sign-out"></i><span>Se déconnecter</span></a>
                        </div>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">
                

            
      <?php
// session_start();
//get data from table pgm_voyage:
$getpgm = $connection->prepare("SELECT id_pgm_voyage,ligne.depart , ligne.arrive,ligne.duree,TIME(`heure_départ`),
TIME(`heure_arrivé`),`prix`,chauffeur.Nom_chauff,chauffeur.Prenom_Chauff,utilisateur.nom_util,bus.id_bus,bus.matricule,utilisateur.prenom_util 
FROM pgm_voyage INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne INNER JOIN chauffeur ON pgm_voyage.id_chauffeur=chauffeur.id_chauffeur INNER JOIN bus ON pgm_voyage.id_bus=bus.id_bus  INNER JOIN utilisateur ON pgm_voyage.id_utilisateur=utilisateur.id_utilisateur");

 $getpgm->execute();

 $pgm_data=$getpgm->fetchAll();

 
     $tabpgm="
     <div class='tableau'>
     <table>
<thead>
    <tr>
        <th>Ligne</th>
        <th>Heure-départ</th>
        <th>Heure-arrivé</th>
        <th>Prix</th>
        <th>Chauffeur</th>
        <th>Bus</th>
        <th>Utilisateur</th>
        <th>Operation</th>
    </tr>
</thead>
<tbody>";
$time=NULL;
     foreach($pgm_data as $row){
        $tabpgm.="<tr>
        <td>".$row["depart"].'-'.$row["arrive"]."</td>
        <td>".$row["TIME(`heure_départ`)"]."</td>
        <td>".$row["TIME(`heure_arrivé`)"]."</td>
        <td>".$row["prix"].' '.'DA'."</td>
        <td>".$row["Nom_chauff"].' '.$row["Prenom_Chauff"]."</td>
        <td>".$row["matricule"]."</td>
        <td>".$row["nom_util"].' '.$row["prenom_util"]."</td>
        <td>";
    $tabpgm.="<div class='btn_container'><form action='' method='POST' class='form_supp'>
        <input type='hidden' name='id_pgm' value=".$row["id_pgm_voyage"].">
        <button type='submit' name='deletepgm' class='supp'><i class='fas fa-trash'></i> Supprimer</button>
         </form>";
    }
    echo $time;
$tabpgm.= "</tbody>
</table>
</div>";


     echo $tabpgm;

     if(isset($_POST["submitpgm"])){
        $ligne=$_SESSION["trajet"];
        $tempd =$_SESSION["departure_time"];
        $tempa =$_SESSION["arrival_time"];
        $prix=$_POST["prix"];
        $bus=$_POST["id_bus"];
        $chauff=$_POST["driver"];
        $util = $_SESSION["idadmin"];

        $stmt1 = $connection->prepare("INSERT INTO `pgm_voyage` (`id_ligne`,`heure_départ`,`heure_arrivé`,`prix`,`id_chauffeur`,`id_bus`,`id_utilisateur`)
                             VALUES ('$ligne', '$tempd', '$tempa', '$prix','$chauff','$bus', '$util')");
        $stmt1->execute();
        // $stmt2 = $connection->prepare("SELECT arrive FROM ligne WHERE id_ligne=$ligne");
        // $stmt2->execute();
        // $data_arrive=$stmt2->fetchALL();
        // foreach($data_arrive as $row){
        //     $arrival=$row["arrive"];
        // }
        // $stmt3 = $connection->prepare("UPDATE bus SET `last_position` = '$arrival' WHERE id_bus=$bus");
        // $stmt3->execute();

        

        
        $ligne ="";
        $tempd = "";
        $prix = "";
        $util ="";
     }



     $pgm_input="<div class='inputdata'>
<form action='' method='post' class=''>";
$sqlligne=$connection->prepare("SELECT * FROM ligne");
$sqlligne->execute();
$lignedata=$sqlligne->fetchAll();
$pgm_input.="<select name='id_ligne' id='ligne' required>
<option value=''>Sélectionner une ligne</option>";
foreach($lignedata as $row){
$ligne=$row["id_ligne"];
$depart=$row["depart"];
$arrive=$row["arrive"];
   $pgm_input.= "<option value='$ligne'>$depart $arrive</option>";}
   $pgm_input.="</select>
<input type='time' name='departure' id='departure'  required>

<input type='number' min='1' name='prix' placeholder='Prix' required>

<select name='id_bus' id='id_bus' required>
<option value=''>Sélectionner un bus</option>
</select> 

<select name='driver' id='driver' required>
<option value=''>Sélectionner un Chauffeur</option>
</select>";
$pgm_input.="<input type='submit' name='submitpgm' value='Enregistrer' class='add'>
</form>
</div>";
echo $pgm_input;

// echo "";
?>
      </div>
            <!--main container end-->
        </div>
        <!--wrapper end-->

        <script type="text/javascript">
        $(document).ready(function(){
            $(".sidebar-btn").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
        </script>

<script type='text/javascript'>
    $(document).ready(function(){
    $('#ligne, #departure').on('change',function() {
        var ligne_id = $("#ligne").val();
        var departure = $("#departure").val();
        $.ajax({
            url:'searchbus.php',
            type:'POST',
            cache:false,
            data:{ligne_id:ligne_id,departure:departure},
            dataType: 'html',
            success:function(data){
                $('#id_bus').html(data);
                
            },error:function(){
               
            }
        });

        $.ajax({
            url:'searchdriver.php',
            type:'POST',
            cache:false,
            data:{ligne_id:ligne_id,departure:departure},
            dataType: 'html',
            success:function(data){
                $('#driver').html(data);
                
            },error:function(){
               
            }
        });
       
    });  
   
    // $("#update_profile").on('click',function() {
    //     var popup = $(".jjjjjjj").val();
    //     // var btn_edit=$(this).val
    //     popup.style.background-color=blue;
    // });

});

var popup = document.querySelector('#edit_profile');
var btnpop = document.querySelector('#update_profile');
var btnpopclose = document.querySelector('.fa-x');
var form = document.querySelector('.form_update');

btnpop.addEventListener('click',()=>{
    popup.style.display="flex";
});

btnpopclose.addEventListener('click',()=>{
    popup.style.display="none";
});

</script>

    </body>
</html>