<?php
require "connect.php";
session_start();

$idpr=$_GET['id_proprietaire'];

$stmts = $connection->prepare("SELECT * FROM propriétaire WHERE `id_proprietaire`=$idpr");
$stmts->execute();
$tmts_data=$stmts->fetchAll();
foreach($tmts_data as $row){
    $nomp=$row["nom_prop"];
    $prenomp=$row["prenom_prop"];
    $contactp=$row["contact_prop"];
    $emailp=$row["email_prop"];
    $entreprise=$row["nom_entreprise"];
}


if(isset($_POST["submit"])){
    
    $nom_prop = $_POST["nom_prop"];
    $prenom_prop = $_POST["prenom_prop"];
    $contact_prop = $_POST["contact_prop"];
    // $adr_dom = $_POST["adr_dom"];
    $email_prop = $_POST["email_prop"];
    $nom_entreprise = $_POST["nom_entreprise"];
    // $nom_util_prop = $_POST["nom_util_prop"];
    // $password_prop = $_POST["password_prop"];
    $util = $_SESSION["idadmin"];
  
        $stmt = $connection->prepare("UPDATE `propriétaire` SET  `nom_prop`='$nom_prop',  `prenom_prop`='$prenom_prop', `contact_prop`='$contact_prop',  `email_prop`='$email_prop', `nom_entreprise`='$nom_entreprise', `id_utilisateur`='$util' WHERE `id_proprietaire`='$idpr' ");
        $stmt->execute();    
   
header('location:pro.php') ;  
}





?>


    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <div id='edit_table' class='update_background'>
    <title>Chauffeur</title>

<div id='edit_table' class='update_background'>
<div  class='form_update' style="height: 350px;">
        <form action="" class='edit_form' method='post'>
        <div class='input_popup_container'>
            
                <div>Nom</br>
                <input type="text" name="nom_prop"  placeholder="nom_prop" value='<?php echo $nomp;?>'  ></div>
                <div>Prenom</br>
                <input type="text" name="prenom_prop"  placeholder="prenom_prop" value='<?php echo $prenomp;?>'  ></div>
                <div>Contact</br>
                <input type="text" name="contact_prop"  placeholder="contact_prop" value='<?php echo $contactp;?>'  ></div>
                <div>email</br>
                <input type="text" name="email_prop"  placeholder="email" value='<?php echo $emailp;?>' ></div>
                <div>Entreprise</br>
                <input type="text" name="nom_entreprise"  placeholder="nom_entreprise" value='<?php echo $entreprise;?>'  ></div>
                </div>
                <button  type='submit' class='confirm' name='submit'>Confirmer <i class="fas fa-check"></i></button>
                </div>
                
        </form>
        </div>
    </div>



        