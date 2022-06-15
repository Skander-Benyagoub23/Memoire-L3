<?php
require "connect.php";
session_start();

if(isset($_POST["login"])){
    $user=$_POST["user"];
    $mdp=$_POST["password"];

    $sqllog = $connection->prepare("SELECT * FROM utilisateur WHERE ((`nom_utilisateur`='$user' OR `email_util`='$user') AND `password_util`='$mdp')");
    $sqllog->execute();

    $datalog=$sqllog->Fetch();

    if(is_array($datalog)){
        $_SESSION["idadmin"]=$datalog["id_utilisateur"];
        $_SESSION["useradmin"]=$datalog["nom_utilisateur"];
        $_SESSION["type"]=$datalog["type"];
        if($_SESSION["type"]==1){
            $_SESSION["super_admin"]=1;
        }
        // $_SESSION["mdpadmin"]=$datalog["password_util"];
        // $_SESSION["emailadmin"]=$datalog["email_util"];

        header('location:home.php');
    }
    else{
		$_SESSION["failed_loginuser"]="<p style='margin:0 0 10 20; color:#f00;' >Les identifiants saisis sont incorrectes veuillez réessayer</p>";
	}

}
?>
<html>
<head>
    <link rel="stylesheet" href="logadmin.css">
<title></title>
</head>
<body>
<div class="form_body">
<img src="admin.png">
<p class="text">Connexion utilisateur</p>
<?php 
if(isset($_SESSION["failed_loginuser"])){
    echo $_SESSION["failed_loginuser"];
    unset($_SESSION["failed_loginuser"]);
}
?>
<form class="login_form" method="POST">
<input type="text" name="user" placeholder="Email ou nom d'utilisateur" required><br>
<input type="password" name="password" placeholder="Mot de passe" required><br>
<button type="submit" name="login">Connexion</button>
</form>

</div>

</body>
</html>