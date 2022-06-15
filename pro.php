<?php
session_start();
require "connect.php";
if(isset($_POST['delete'])){
    $idp=$_POST['id_proprietaire'];   
   $supp = $connection->prepare("DELETE FROM propriétaire where `id_proprietaire`='$idp'");
   $supp->execute();
   header('location:pro.php');
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
                            <a href="#"><i class="fas fa-user-tie"></i><span>Propriétaire</span></a>
                            <a href="chauffeur.php"><i class="fas fa-address-card"></i><span>Chauffeur</span></a>
                            <a href="bus.php"><i class="fas fa-bus"></i><span>Bus</span></a>
                            <a href="logadmin.php"><i class="fas fa-route"></i><span>Ligne</span></a>
                        </div>
                    </li>
                    <li class="item" id="settings">
                        <a href="#settings" class="menu-btn">
                            <i class="fas fa-cog"></i><span>Option<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                            <a href="#" id='update_profile'><i class="fas fa-lock"></i><span>Modifier profil</span></a>
                            <a href="logout.php"><i class="fa-solid fa-sign-out"></i><span>Se déconnecter</span></a>
                        </div>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">
                
                <?php
$res = $connection->prepare("SELECT `id_proprietaire`,`nom_prop`,`prenom_prop`,`contact_prop`,`email_prop`,`nom_entreprise`,utilisateur.nom_util,prenom_util FROM propriétaire INNER JOIN utilisateur ON propriétaire.id_utilisateur=utilisateur.id_utilisateur");
$res->execute();
$res_data = $res->fetchAll();

$data = "
<table>
<thead>
    <tr>
        <th>nom</th>
        <th>prenom</th>
        <th>contact</th>
        <th>email</th>
        <th>Entreprise</th>
        <th>Utilisateur</th>
        <th>Operation</th>
      
    </tr>
</thead>
<tbody>";
foreach($res_data as $row){
    $data .="<tr>
    <td>".$row["nom_prop"]."</td>
    <td>".$row["prenom_prop"]."</td>
    <td>".$row["contact_prop"]."</td>
    <td>".$row["email_prop"]."</td>
    <td>".$row["nom_entreprise"]."</td>
    <td>".$row["nom_util"].$row["prenom_util"]."</td>


  <td><div class='btn_container'><form action='' method='POST' class='form_supp'>

    <input type='hidden' name='id_proprietaire' value=".$row["id_proprietaire"].">

    <button type='submit' name='delete' class='supp'><i class='fas fa-trash'></i> Supprimer</button>
</form>
<form action='editerpro.php' method='GET' class='form_edit'>
<input type='hidden' name='id_proprietaire' value=".$row["id_proprietaire"].">
<button type='submit' name='edit' class='edit'><i class='fas fa-edit'></i> Modifier</button>
</form></div></td>
            </tr>";
        }
    $data.= "</tbody>
    </table>";

echo $data;

if(isset($_POST["submitpro"])){
    $nom_prop = $_POST["nom_prop"];
    $prenom_prop = $_POST["prenom_prop"];
    $username_prop = $_POST["username_prop"];
    $contact_prop = $_POST["contact_prop"];
    $email_prop = $_POST["email_prop"];
    $nom_entreprise = $_POST["nom_entreprise"];
    $mdp_prop = $_POST["password_prop"];
    $util = $_SESSION["idadmin"];
    echo $util;
    if(empty($nom_prop)||empty($prenom_prop)||empty($contact_prop)||empty($prenom_prop)||empty($email_prop)||empty($nom_entreprise)||empty($util)){
        echo "entrer les informations!";
    }
    else{
    $stmt = $connection->prepare("INSERT INTO propriétaire (nom_prop , prenom_prop , contact_prop , email_prop , nomutil_prop , password_prop , nom_entreprise , id_utilisateur) VALUES ('$nom_prop','$prenom_prop','$contact_prop'
     ,'$email_prop','$username_prop','$mdp_prop','$nom_entreprise','$util')");
    $stmt->execute();
}
}


$proinput="
<div class='inputdata'>
<form action='' method='POST' class='container'>
       
<input type='text' name='nom_prop'  placeholder='nom_prop' class='sub'  required>

<input type='text' name='prenom_prop'  placeholder='prenom_prop' class='sub'  required>

<input type='text' name='username_prop'  placeholder='Nom utilisateur' class='sub'  required>

<input type='number' minlength='10' maxlength='10' name='contact_prop'  placeholder='contact_prop' class='sub'  required>

<input type='email' name='email_prop'  placeholder='email_prop' class='sub'  required>

<input type='text' name='nom_entreprise'  placeholder='nom_entreprise' class='sub'  required>

<input type='password' name='password_prop'  placeholder='Mot de passe' class='sub'  required>

<input type='submit' name='submitpro' value='Enregistrer' class='sub add'>
</form></div>";
echo $proinput;
?>
<link rel="stylesheet" href="table.css">

        







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