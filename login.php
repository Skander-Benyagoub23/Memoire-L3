<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>CrossBus</title>
</head>

<?php
require "connect.php";
session_start();

if(isset($_POST["login"])){
    $user=$_POST["user"];
    $mdp=$_POST["password"];


        $sqllogclient = $connection->prepare("SELECT * FROM client WHERE ((`nom_util_client`='$user' OR `email_client`='$user') AND `password_client`='$mdp')");
        $sqllogclient->execute();
        $datalogclient=$sqllogclient->Fetch();

    if(is_array($datalogclient)){
        $_SESSION["idclient"]=$datalogclient["id_client"];
        $_SESSION["userclient"]=$datalogclient["nom_util_client"];
        header('location:client.php');
    }else{
		$_SESSION["failed_login"]="<p style='margin:0 auto; color:#f00;' >Les identifiants saisis sont incorrectes veuillez réessayer</p>";
	}
    }

?>
<body>
	<div class="container" id="container">
		<div class="form-container log-in-container">
			<form action="" method="POST">
				<h1>Se connecter</h1>
				<div class="social-container">
					<a href="#" class="social"><i class="fa fa-user fa-5x"></i></a>
				
				</div>
				<input name='user' type="text" placeholder="E-mail ou nom d'utilisateur" required/>
				<input type="password" name='password' placeholder="Mot de passe" required/>
				<div class="login-signup">
					<span class="text">vous n'êtes pas un membre ?
					</br><a href="signup.php" class="text signup-link">Créer un compte</a>
					</span>
					<?php
                if(isset($_SESSION["failed_login"])){
    echo $_SESSION["failed_login"];
    unset($_SESSION["failed_login"]);
}
?>
				</div>
			
				<button type="submit" name="login">Connexion</button>
			</form>

			
		</div>


		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
					<span>Bienvenue sur <a href="client.php">CrossBus</a></span><p>Réserver votre ticket de bus maintenant!</p>
					<!-- <p>This login form is created using pure HTML and CSS. For social icons, FontAwesome is used.</p> -->
				</div>
			</div>
		</div>


	</div>
</body>
</html>