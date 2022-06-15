<?php
require "connect.php";
session_start();

if(isset($_POST["confirm"])){
    $nom=$_POST["nom_ins"];
    $prenom=$_POST["prenom_ins"];
    $username=$_POST["username_ins"];
    $contact=$_POST["contact_ins"];
    $email=$_POST["email_ins"];
    $password=$_POST["password_ins"];
    $confirm=$_POST["confirm_ins"];
    if($password!=$confirm){
        $_SESSION["error_password"]="<input type='password' name='confirm_ins' id='confirmation mot de pass' placeholder='Confirmer le mot de pass' style='border: solid 1px red !important;' required>";
    }
    else{
        $sqlverify = $connection->prepare("SELECT * FROM client WHERE `nom_util_client`='$username'");
        $sqlverify->execute();
        if($sqlverify->rowCount()!=0){
            $_SESSION["already_exist"]="<p style='color:#f00; margin:0;'>Ce nom d'utilisateur existe déja</p>";
        }
        else{
            $sqlsignup = $connection->prepare("INSERT INTO client (`nom_client`,`prenom_client`,`contact_client`,`email_client`,`password_client`,`nom_util_client`)
             VALUES ('$nom','$prenom','$contact','$email','$password','$username')");
             $sqlsignup->execute();
             $_SESSION["userclient"]=$username;
             header('location:client.php');
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="signup.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Sign up Form</title>
</head>
<body>
	<div class="container" id="container">
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
					<h1>Avec<a href="client.php"><h1>CrossBus</h1></a><p>inscrivez-vous et commencez vos Réservations dès maintenant </p></h1>
				</div>
			</div>
		</div>

		<div class="form-container log-in-container">
			<form action="" method='post'>
				<h1>S'inscrire</h1>
				<span></span>
                <input type="text" name="nom_ins" id="Nom" placeholder="Nom" required >
                <input type="text" name="prenom_ins" id="Prenom" placeholder="Prénom" required >
                <?php
                if(isset($_SESSION["already_exist"])){
    echo $_SESSION["already_exist"];
    unset($_SESSION["already_exist"]);
    }
                ?>
                <input type='text' max='15' name='username_ins'  placeholder="Nom d'utilisateur" required >
                <input type="number" minlength=10 maxlength=10 name="contact_ins" id="Contact" placeholder="Contact" required >
				<input type="email" name="email_ins" placeholder="E-mail" required/>
				<input type="password" name="password_ins" placeholder="Mot de passe" required/>
                <?php
                if(isset($_SESSION["error_password"])){
    echo $_SESSION["error_password"];
    unset($_SESSION["error_password"]);
    }
    else{
        echo "<input type='password' name='confirm_ins' id='confirmation mot de pass' placeholder='Confirmer le mot de pass' required>";
    }
?>
			
				<button type="submit" name="confirm">Valider</button>
			</form>
		</div>


	

	</div>
</body>
</html>