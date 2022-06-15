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
                    <li class="item">
                        <a href="#" class="menu-btn">
                            <i class="fas fa-info-circle"></i><span>A propos</span>
                        </a>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">
                
                <?php
$iduser=$_SESSION["idadmin"];

$sqluser=$connection->prepare("SELECT * FROM utilisateur WHERE id_utilisateur!=$iduser");
$sqluser->execute();
$datauser=$sqluser->fetchAll();
$tabuser="<table>
<thead>
    <tr>
        <th>Utilisateur</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>E-mail</th>
        <th>Contact</th>
        <th>Operation</th>
    </tr>
</thead>
<tbody>";
foreach($datauser as $row){
    $tabuser.="<tr>
    <td>".$row["nom_utilisateur"]."</td>
    <td>".$row["nom_util"]."</td>
    <td>".$row["prenom_util"]."</td>
    <td>".$row["email_util"]."</td>
    <td>".$row["Contact_util"]."</td>
    <td>";
    if(isset($_POST['deleteuser'])){
        $id=$_POST['id_util'];
    $supp = $connection->prepare("DELETE FROM utilisateur WHERE `id_utilisateur`='$id'");
    $supp->execute();
    }
    
    $tabuser.="<div class='btn_container'><form action='' method='POST' class='form_supp'>
    <input type='hidden' name='id_util' value=".$row["id_utilisateur"].">
    <button type='submit' name='deleteuser' class='supp'><i class='fas fa-trash'></i> Supprimer</button>
</form></div></td>
</tr>";

}
$tabuser.="</tbody>
</table>";

echo $tabuser;

if(isset($_POST["submituser"])){
    $nomuser=$_POST["nom"];
    $prenomuser=$_POST["prenom"];
    $userusername=$_POST["utilisateur"];
    $emailuser=$_POST["email"];
    $contactuser=$_POST["contact"];
    $passworduser=$_POST["password"];
    $confirmuser=$_POST["confirm_password"];
    if($passworduser==$confirmuser){
        $verify=$connection->prepare("SELECT * FROM utilisateur WHERE (nom_utilisateur='$userusername' OR `email_util`='$emailuser')");
        $verify->execute();
        if($verify->rowCount()!=0){
            $_SESSION["user_exists"]="<p style='color:#f00; margin:0;'>Nom utilisateur ou email déja existe</p>";
        }
        else{
            $adduser=$connection->prepare("INSERT INTO `utilisateur` 
            (`nom_util`, `prenom_util`, `Contact_util`, `email_util`, `password_util`, `nom_utilisateur`) 
            VALUES ('$nomuser','$prenomuser','$contactuser','$emailuser','$passworduser','$userusername')");
            $adduser->execute();
        }
        
    }
    else{
        $_SESSION["password_incorrect"]="<p style='color:#f00; margin:0;'>Le mot de passe saisie est incorrecte</p>";
    }
    
}


$userinput="<div class='inputdata'>";
if(isset($_SESSION["user_exists"])){
    echo $_SESSION["user_exists"];
    unset($_SESSION["user_exists"]);
}
if(isset($_SESSION["password_incorrect"])){
    echo $_SESSION["password_incorrect"];
    unset($_SESSION["password_incorrect"]);
}
$userinput.="<form action='' method='post' class=''>
<input type='text' placeholder='Nom' name='nom'  required>
<input type='text' name='prenom'  placeholder='Prénom'  required>
<input type='text'  name='utilisateur' placeholder='Nom utilisateur' required>
<input type='email' name='email' placeholder='E-mail' required>
<input type='number' name='contact'  placeholder='Contact'  required>
<input type='password' name='password' placeholder='Mot de passe'>
<input type='password' name='confirm_password' placeholder='Confirmer mot de passe'>
<input type='submit' name='submituser' value='Enregistrer' class='add'>
</form>
</div>";

echo $userinput;

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