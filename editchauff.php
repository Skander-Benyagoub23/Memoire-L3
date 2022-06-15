<?php 
require "connect.php";
session_start();
$idc=$_GET['id_chauff'];
$stmts = $connection->prepare("SELECT * FROM chauffeur WHERE `id_chauffeur`=$idc");
$stmts->execute();
$tmts_data=$stmts->fetchAll();
foreach($tmts_data as $row){
    $nom=$row["Nom_chauff"];
    $prenom=$row["Prenom_chauff"];
    $contact=$row["Contact_chauff"];
    $email=$row["email_chauff"];
}
if(isset($_POST["editchauff"])){
    
    $nom_chauff = $_POST["nom_chauff"];
    $prenom_chauff = $_POST["prenom"];
    $contact_chauff = $_POST["contact"];
    $email_chauff = $_POST["email_chauff"];
    $util = $_SESSION["idadmin"];
    // if(empty($disp)){
    //     $disp=0;
    // }
    // else{
    //     $disp=1;
    // }
    
        $stmt = $connection->prepare("UPDATE `chauffeur` SET  `Nom_chauff`='$nom_chauff', `Prenom_chauff`='$prenom_chauff', `Contact_chauff`='$contact_chauff',`email_chauff`='$email_chauff',`id_utilisateur`='$util' WHERE `id_chauffeur`='$idc' ");
        $stmt->execute();    
     header('location:chauffeur.php');
}
?>

<link rel="stylesheet" href="table.css">
<link rel="stylesheet" href="fontawesome/css/all.css">
<title>CrossBus</title>
<div id='edit_table' class='update_background'>
        <div  class='form_update' style="height:350;">
        <form action="" class='edit_form' method='post'>
        <div class='input_popup_container'>
                <div>Nom</br>
                <input type='text'  name='nom_chauff'  placeholder='Nom' value='<?php echo $nom?>' ></div>
                <div>Prenom</br>
                <input type='text' name='prenom'  placeholder='Prenom' value='<?php echo $prenom;?>' ></div>
                <div>Contact</br>
                <input type='text'  name='contact' placeholder='Contact' value='<?php echo $contact;?>'></div>
                <div>email</br>
                <input type='text' name='email_chauff' placeholder='email' value='<?php echo $email;?>'></div>
                </div>
                <button  type='submit' class='confirm' name='editchauff'>Confirmer <i class="fas fa-check"></i></button>
        </form>
        </div>
    </div>