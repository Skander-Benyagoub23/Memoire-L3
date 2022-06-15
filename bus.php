<?php
session_start();
require "connect.php"
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
                            <a href="#"><i class="fas fa-bus"></i><span>Bus</span></a>
                            <a href="table.php"><i class="fas fa-route"></i><span>Ligne</span></a>
                        </div>
                    </li>
                    <li class="item" id="settings">
                        <a href="#settings" class="menu-btn">
                            <i class="fas fa-cog"></i><span>Option<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                            <a href="#" id='update_profile'><i class="fas fa-lock"></i><span>Modifier profil</span></a>
                            <a href="logadmin.php"><i class="fa-solid fa-sign-out"></i><span>Se déconnecter</span></a>
                        </div>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">
                
                <?php
require "connect.php";
//get data from table bus:
$getbus = $connection->prepare("SELECT `id_bus`,`numero`,`matricule`,`capacité`,`couleur`,`disp`,propriétaire.nom_prop,propriétaire.prenom_prop,utilisateur.nom_util,prenom_util,utilisateur.id_utilisateur FROM bus INNER JOIN propriétaire ON bus.id_proprietaire=propriétaire.id_proprietaire INNER JOIN utilisateur ON bus.id_utilisateur=utilisateur.id_utilisateur ");
$getbus->execute();
$bus_data = $getbus->fetchAll();
$tabbus = "
<table>
<thead>
    <tr>
        <th>Num-Bus</th>
        <th>Matricule</th>
        <th>Capacité</th>
        <th>Couleur</th>
        <th>Disponibilité</th>
        <th>Propriétaire</th>
        <th>Utilisateur</th>
        <th>Operation</th>
    </tr>
</thead>
<tbody>";
foreach($bus_data as $row){
    $tabbus .="<tr>
    <td><b>".$row["numero"]."</b></td>
    <td>".$row["matricule"]."</td>
    <td>".$row["capacité"]."</td>
    <td>".$row["couleur"]."</td>";
    if($row["disp"]==1){
        $tabbus .="<td>disponible</td>";
    }
    else if($row["disp"]==0){
        $tabbus .="<td>indisponible</td>";
    }
    
    $tabbus .="<td>".$row["nom_prop"].' '.$row["prenom_prop"]."</td>";
    if($row["id_utilisateur"]!=0){
        $tabbus .="<td>".$row["nom_util"].' '.$row["prenom_util"]."</td>";
    }
    else if($row["id_utilisateur"]==NULL){
        $tabbus .="<td>Propriétaire</td>";
    }

    $tabbus .="<td>";
    //delete data from bus:
    if(isset($_POST['deletebus'])){
        $id=$_POST['id_bus'];
    $supp = $connection->prepare("DELETE FROM bus where `id_bus`='$id'");
    $supp->execute();
    header('location:bus.php');
    }
    
    $tabbus.="<div class='btn_container'><form action='' method='POST' class='form_supp'>
    <input type='hidden' name='id_bus' value=".$row["id_bus"].">
    <button type='submit' name='deletebus' class='supp'><i class='fas fa-trash'></i> Supprimer</button>
</form>";
$tabbus.="
<form action='editbus.php' method='GET' class='form_edit'>
<input type='hidden' name='id_bus' value=".$row["id_bus"].">
<button type='submit' id='editbus' name='editbus' class='edit'><i class='fas fa-edit'></i> Modifier</button>
</form></div></td>
    </tr>";
        }
    $tabbus.= "</tbody>
    </table>";

echo $tabbus;

//add data to table bus:
if(isset($_POST["submitb"])){
    $num = $_POST["num_bus"];
    $matricule = $_POST["matricule"];
    $cap = $_POST["capacite"];
    $couleur = $_POST["couleur"];
    @$disp = $_POST["disp"];
    $prop = $_POST["id_prop"];
    $util = $_SESSION["idadmin"];
    if(empty($disp)){
        $disp=0;
    }
    else{
        $disp=1;
    }
   if(empty($num)||empty($matricule)||empty($cap)||empty($couleur)||empty($prop)){
        echo "entrer les informations!";
    }
    else{
        
    $stmt1 = $connection->prepare("INSERT INTO `bus` (`numero`,`matricule`,`capacité`,`couleur`,`disp`,`id_proprietaire`,`id_utilisateur`) VALUES ('$num', '$matricule', '$cap', '$couleur', '$disp', '$prop', '$util')");
    $stmt1->execute();
    $num ="";
    $matricule = "";
    $cap = "";
    $couleur = "";
    $prop = "";
    //header('location:bus.php') ; 
}
 
}
$bus_input= "<div class='inputdata'>
<form action='' method='post' class=''>
<input type='number' min='1' name='num_bus'  placeholder='Num-Bus'  required>
<input type='text' name='matricule'  placeholder='Matricule' maxlength='12' minlength='12'  required>
<input type='number' min='1' max='60' name='capacite' placeholder='Capacité' required>
<input type='text' name='couleur' placeholder='Couleur' required>
<span style='color:#fff;margin-top:-10px;'>Disponible<input type='checkbox' name='disp' checked style='margin-left:10px;' ></span>
";
$bus_input.="<select name='id_prop' required>
<option value=''>Propriétaire</option>";
$sqlprop=$connection->prepare("SELECT * FROM propriétaire");
$sqlprop->execute();
$dataprop=$sqlprop->fetchAll();
foreach($dataprop as $row){
    $idprop=$row["id_proprietaire"];
    $nomprop=$row["nom_prop"];
    $prenomprop=$row["prenom_prop"];
    $bus_input.="<option value='$idprop'>$nomprop $prenomprop</option>";
}
$bus_input.="</select>
<input type='submit' name='submitb' value='Enregistrer' class='add'>
</form>
</div> ";

echo $bus_input;

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

        var popup = document.querySelector('#edit_profile');
var btnpop = document.querySelector('#update_profile');
var btnpopclose = document.querySelector('.fa-x');

// var popuped = document.querySelector('#edit_table');
// var btnpoped = document.querySelector('#editbus');
// var btnpopcloseed = document.querySelector('#close_edit');

btnpop.addEventListener('click',()=>{
    popup.style.display="flex";
});

btnpopclose.addEventListener('click',()=>{
    popup.style.display="none";
});

// btnpoped.addEventListener('click',()=>{
//     popuped.style.display="flex";
// });

// btnpopcloseed.addEventListener('click',()=>{
//     popuped.style.display="none";
// });
        </script>
    </body>
</html>