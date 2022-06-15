<?php
session_start();
require "connect.php";
if(isset($_POST['deleteorg'])){
    $idpgmorg=$_POST['id_org'];
$supp = $connection->prepare("DELETE FROM pgm_voyage_org where `id_org`='$idpgmorg'");
$supp->execute();
header('location:pgm_voyage_org.php');
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
                            <a href="logadmin.php"><i class="fa-solid fa-sign-out"></i><span>Se déconnecter</span></a>
                        </div>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">
                
            <div class="welcome">
      

            <?php
//display data
$tableorg=$connection->prepare(
"SELECT id_org,ligne.depart,ligne.arrive,pgm_voyage.prix,`date`,date_arrivé,chauffeur.Nom_chauff,chauffeur.Prenom_Chauff,bus.matricule,place_disp,utilisateur.nom_util, utilisateur.prenom_util FROM pgm_voyage_org 
INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
INNER JOIN chauffeur ON pgm_voyage.id_chauffeur=chauffeur.id_chauffeur
INNER JOIN bus ON pgm_voyage.id_bus=bus.id_bus
INNER JOIN utilisateur ON pgm_voyage_org.id_utilisateur=utilisateur.id_utilisateur"
);
$tableorg->execute();
$dataorg=$tableorg->fetchAll();

$dateinput="
<form action='' method='POST'>
<div class='search_container'>
    <input type='date' name='date' required>
    <button type='submit' name='searchdate'><i class='fas fa-search'></i> Rechercher</button>
    <button type='submit' name='subdate'><i class='fas fa-plus'></i> Ajouter</button>
</div>
</form>";

echo $dateinput;

$taborg="<table>
<thead>
   <tr>
       <th>Ligne</th>
       <th>Départ</th>
       <th>Arrivé</th>
       <th>Chauffeur</th>
       <th>Bus</th>
       <th>Place</br>disponible</th>
       <th>Prix</th>
       <th>Utilisateur</th>
       <th>Operation</th>
   </tr>
</thead>";
$taborgbody="<tbody>";
foreach($dataorg as $row){
    $taborgbody.="<tr>
    <td><b>".$row["depart"].'-'.$row["arrive"]."</b></td>
    <td>".$row["date"]."</td>
    <td>".$row["date_arrivé"]."</td>
    <td>".$row["Nom_chauff"].' '.$row["Prenom_Chauff"]."</td>
    <td>".$row["matricule"]."</td>
    <td>".$row["place_disp"]."</td>
    <td>".$row["prix"].' Da'."</td>
    <td>".$row["nom_util"].' '.$row["prenom_util"]."</td>

    <td>";
    
    $taborgbody.="<div class='btn_container'><form action='' method='POST' class='form_supp'>
    <input type='hidden' name='id_org' value=".$row["id_org"].">
    <button type='submit' name='deleteorg' class='supp' disabeled><i class='fas fa-trash'></i> Supprimer</button>
     </form>";

    //  $taborgbody.="
    //     <form action='editpgm_org.php' method='GET' class='form_edit'>
    //     <input type='hidden' name='id_org' value=".$row["id_org"].">
    //     <button type='submit' name='editorg' class='edit'><i class='fas fa-edit'></i> Modifier</button>
    //     </form></div></td>
    //     </tr>";
}
$taborgbody.= "</tbody>
</table>";

echo $taborg;
echo $taborgbody;





if(isset($_POST["searchdate"])){
    $date=$_POST["date"];
    $taborg="";
    $taborgbody="";
    $search=$connection->prepare(
        "SELECT id_org,ligne.depart,ligne.arrive,`date`,date_arrivé,chauffeur.Nom_chauff,chauffeur.Prenom_Chauff,bus.matricule,place_disp,utilisateur.nom_util, utilisateur.prenom_util FROM pgm_voyage_org 
        INNER JOIN pgm_voyage ON pgm_voyage_org.id_pgm_voyage=pgm_voyage.id_pgm_voyage 
        INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne 
        INNER JOIN chauffeur ON pgm_voyage.id_chauffeur=chauffeur.id_chauffeur
        INNER JOIN bus ON pgm_voyage.id_bus=bus.id_bus
        INNER JOIN utilisateur ON pgm_voyage_org.id_utilisateur=utilisateur.id_utilisateur 
         AND( `date`>='$date'AND`date`<='$date 23:59:59')");
        $search->execute();
        $datasearch=$search->fetchAll();
        $taborg="<table>
        <thead>
           <tr>
               <th>Ligne</th>
               <th>Départ</th>
               <th>Arrivé</th>
               <th>Chauffeur</th>
               <th>Bus</th>
               <th>Place</br>disponible</th>
               <th>Utilisateur</th>
               <th>Operation</th>
           </tr>
        </thead>";
        $taborgbody="</tbody>";
        foreach($datasearch as $row){
            $taborgbody.="<tr>
            <td><b>".$row["depart"].'-'.$row["arrive"]."</b></td>
            <td>".$row["date"]."</td>
            <td>".$row["date_arrivé"]."</td>
            <td>".$row["Nom_chauff"].' '.$row["Prenom_Chauff"]."</td>
            <td>".$row["matricule"]."</td>
            <td>".$row["place_disp"]."</td>
            <td>".$row["nom_util"].' '.$row["prenom_util"]."</td>
        
            <td>";

            // if(isset($_POST['deleteorgsearch'])){
            //     $idpgmorg=$_POST['id_org'];
            // $suppsearch = $connection->prepare("DELETE FROM pgm_voyage_org where `id_org`='$idpgmorg'");
            // $suppsearch->execute();
            // }
            $taborgbody.="<div class='btn_container'><form action='' method='POST' class='form_supp'>
            <input type='hidden' name='id_org' value=".$row["id_org"].">
            <button type='submit' name='deleteorg' class='supp'><i class='fas fa-trash'></i> Supprimer</button>
             </form></td></tr>";
        
        }
        $taborgbody.= "</tbody>
</table>";
echo $taborg;
echo $taborgbody;
        

}


//add date to travel hours
if(isset($_POST["subdate"])){
    $date=$_POST["date"];
    $util = $_SESSION["idadmin"];

    function getdatetime($t1,$t2){//calculate arrival date by additioning departure date and duration:
                
        $t11=strtotime($t1);
        $t22=strtotime($t2);
        $t3=strtotime($t2)-strtotime("00:00:00");
        $t4=$t11+$t3;
        return date('Y-m-d H:i:s',$t4);
    }

    $sqldate=$connection->prepare("SELECT `id_pgm_voyage`,TIME(`heure_départ`),ligne.duree,bus.capacité FROM pgm_voyage INNER JOIN ligne ON pgm_voyage.id_ligne=ligne.id_ligne INNER JOIN bus ON pgm_voyage.id_bus=bus.id_bus");
    $sqldate->execute();
    $datedata=$sqldate->fetchAll();
    foreach($datedata as $row){

       

        $heuredep=$row["TIME(`heure_départ`)"];
        $durée=$row["duree"];
        $cap=$row["capacité"];
        $idhoraire=$row["id_pgm_voyage"];
        $combine=date('Y-m-d H:i:s',strtotime("$date $heuredep"));
        
        if(empty($idorg)){
                $arrivaldate=getdatetime($combine,$durée);
                $stmtorg = $connection->prepare("INSERT IGNORE INTO `pgm_voyage_org` (`id_pgm_voyage`,`date`,`date_arrivé`,`place_disp`,`id_utilisateur`)
                VALUES ('$idhoraire', '$combine', '$arrivaldate','$cap','$util') ");
            $stmtorg->execute();
            }

}


}
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