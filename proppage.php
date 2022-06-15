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
            $idprop= $_SESSION["idprop"];
            $sqlprop=$connection->prepare("SELECT * FROM propriétaire WHERE id_proprietaire=$idprop");
            $sqlprop->execute();
            $dataprop=$sqlprop->fetchAll();
            foreach($dataprop as $prop){
                $nom=$prop["nom_prop"];
                $prenom=$prop["prenom_prop"];
                $num=$prop["contact_prop"];
                $mail=$prop["email_prop"];
                $entreprise=$prop["nom_entreprise"];
                $username=$prop["nomutil_prop"];
                $password=$prop["password_prop"];
            }
            if(isset($_POST["confirm"])){

                    $nameprop=$_POST["nameprop"];
                    $firtname=$_POST["prenomprop"];
                    $mailprop=$_POST["mailprop"];
                    $contactprop=$_POST["numprop"];
                    $usernameprop=$_POST["usernameprop"];
                    $entrepriseprop=$_POST["entreprise"];
                    $newpass=$_POST["newpass"];
                    $confirm=$_POST["confirmpass"];
                if(empty($newpass) && empty($confirm)){
                    $_SESSION["userprop"]=$usernameprop;
                    $sqlupdate=$connection->prepare("UPDATE `propriétaire` SET
                    `nom_prop`='$nameprop',`prenom_prop`='$firtname',`contact_prop`='$contactprop',`email_prop`='$mailprop',`nomutil_prop`='$usernameprop',`nom_entreprise`='$entrepriseprop' WHERE `id_proprietaire`=$idprop");
                    $sqlupdate->execute();
                    echo "<script> alert(\"Donnés modifié avec succès\");</script>";
                }
                elseif(!empty($newpass))
                {
                    if($confirm == $password){
                        $sqlupdate=$connection->prepare("UPDATE `propriétaire` SET
                    `nom_prop`='$nameprop',`prenom_prop`='$firtname',`contact_prop`='$contactprop',`email_prop`='$mailprop',`nomutil_prop`='$usernameprop',`password_prop`='$newpass',`nom_entreprise`='$entrepriseprop' WHERE `id_proprietaire`=$idprop");
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
                <div>Nom</br><input type='text' name='nameprop' placeholder='nom' value='<?php echo $nom?>'></div>
                <div>Prenom</br>
                <input type='text' name='prenomprop' placeholder='prenom' value='<?php echo $prenom?>'></div>
                <div> Adresse-mail</br>
                <input type='email' name='mailprop' placeholder='adresse-mail' value='<?php echo $mail?>'></div>
                <div>Contact</br>
                <input type='text' name='numprop' placeholder='contact' value='<?php echo $num?>'></div>
                <div>Nom utilsateur</br>
                <input type='text' name='usernameprop' placeholder='username' value='<?php echo $username?>'></div>
                <div >Entreprise</br>
                <input type='text' name='entreprise' placeholder='Entreprise' value='<?php echo $entreprise?>'></div>
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
                        <p><?php echo $_SESSION["userprop"]; ?></p>
                    </center>
                    <li class="item">
                        <a href="#" class="menu-btn">
                            <i class="fas fa-bus"></i><span>Bus</span>
                        </a>
                    </li>

                    <li class="item" id="settings">
                        <a href="#settings" class="menu-btn">
                            <i class="fas fa-cog"></i><span>Option<i class="fas fa-chevron-down drop-down"></i></span>
                        </a>
                        <div class="sub-menu">
                            <a href="#" id='update_profile'><i class="fas fa-lock"></i><span>Modifier profil</span></a>
                            <a href="proplogin.php"><i class="fa-solid fa-sign-out"></i><span>Se déconnecter</span></a>
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
$getbus = $connection->prepare("SELECT `id_bus`,`numero`,`matricule`,`capacité`,`couleur`,`disp`,propriétaire.nom_prop,propriétaire.prenom_prop FROM bus INNER JOIN propriétaire ON bus.id_proprietaire=propriétaire.id_proprietaire  WHERE bus.id_proprietaire=$idprop ");
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
    
    $tabbus .="<td>".$row["nom_prop"].' '.$row["prenom_prop"]."</td>
    <td>";
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
<form action='editbuspro.php' method='GET' class='form_edit'>
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
    if(empty($disp)){
        $disp=0;
    }
    else{
        $disp=1;
    }
   if(empty($num)||empty($matricule)||empty($cap)||empty($couleur)){
        echo "entrer les informations!";
    }
    else{
        
    $stmt1 = $connection->prepare("INSERT INTO `bus` (`numero`,`matricule`,`capacité`,`couleur`,`disp`,`id_proprietaire`) VALUES ('$num', '$matricule', '$cap', '$couleur', '$disp', '$idprop')");
    $stmt1->execute();
    $num ="";
    $matricule = "";
    $cap = "";
    $couleur = "";
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