<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crossbus</title>

    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">





    <link rel="stylesheet" href="style22.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo"><a href="#">Cross<span>Bus</span></a></div> 
            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="menu">
                <li><a href="#home" class="menu-btn">Accueil</a></li>
                <li><a href="#about" class="menu-btn">à propos</a></li>
                <li><a href="#services" class="menu-btn">Service</a></li>
                <li><a href="#contact" class="menu-btn">Contact</a></li>
                <?php
                if(isset($_SESSION["userclient"])){
                    echo "<li><a href='profile.php' class='menu-btn'>Mon compte</a></li>
                    <li><a href='logout.php' class='menu-btn'>Se déconnecter</a></li>
                    ";
                }else {
                    echo "<li><a href='login.php' class='menu-btn'>Se connecter</a></li>
                <li><a href='signup.php' class='menu-btn'>S'inscrire</a></li>";
                }
                ?>
                
                <!-- <li><a href="#" class="menu-btn">Conexion</a> </li>   -->
</ul>
          
        </div>
          
    </nav>

    <!-- home section start -->
    <section class="home" id="home">
        <div class="max-width">
            <div class="home-content">
            <?php
                if(isset($_SESSION["success_message"])){
    echo $_SESSION["success_message"];
    unset($_SESSION["success_message"]);
}
?>
                <!-- <div class="text-1">Hello, my name is</div> -->
                <div class="text-2">Voyage en bus entre <span>Wilaya.</span></div>
                
                <div class="text-3"><span class="typing"></span></div>
                <!-- <a href="#">Hire me</a> -->

              <!-- Table de reservation -->
                <div class="booking-form-box">
                <div class="booking-form">
                    
                    <?php
require "connect.php";
if(isset($_POST["searchbooking"])){
    $_SESSION["point_depart"]=$_POST["depart"];
    $_SESSION["point_arrive"]=$_POST["arrive"]; 
    $_SESSION["travel_date"]=$_POST["date"];
    $_SESSION["travel_place"]=$_POST["seat"];
    header('location:search.php');
}
$stmtde=$connection->prepare("SELECT DISTINCT depart FROM ligne ");
$stmtde->execute();
$datade=$stmtde->fetchAll();
$formcli="<form action='' method='post'>
                        <select name='depart' id='depart' required>
                        <option value=''>--Sélectionner le départ--</option>";
                        foreach($datade as $row){
                            $dep=$row["depart"];
                                $formcli.="<option value='$dep'>$dep</option>";
                            }
                            $formcli.="</select>

                    <select name='arrive' id='arrive' required>
                        <option value=''>--Sélectionner l'arrivé--</option>
                        </select>
                        
                
                    <div class='input-grp'>
                                  <input type='date' id='traveldate' name='date' class='form-control select-date' data-validate='Enter password' required>
                        
                    </div>
                
                
                         <div class='input-grp'>
                    
                            <input type='number' name='seat' class='form-control' min='1' placeholder='Nombre de places' required >
                            
                   
                         </div>
                 </div>

                 <div class='input-grp'>
                    <button type='submit' name='searchbooking' class='btn btn-submit '>Chercher</button>
                 </div> 
                 </form>";
                 
                 echo $formcli;
                 ?>

                    </div>
                   </div>
                </div>
               
            </div>
        </div>
    </section>




    <!-- about section start -->
    <section class="about" id="about">
        <div class="max-width">
            <h2 class="title">A propos</h2>
            <div class="about-content">
                <div class="column left">
                    <img src="Capture5.png" alt="">
                </div>
                <div class="column right">
                    <div class="text">CrossBus est <span class="typing-2"></span></div>
                    <p>CrossBus est une marque algérienne qui assure le service de bus interurbain en Algérie, L'équipe de CrossBus travaille sur le confort et la sécurité des voyageurs lors des déplacements, et la dicipline des temps de trajet.</p>
                    <a href="#contact">Contactez nous</a>
                </div>
            </div>
        </div>
    </section>

    <!-- services section start -->
    <section class="services" id="services">
        <div class="max-width">
            <h2 class="title">Nos services</h2>
            <div class="serv-content">
                <div class="card">
                    <div class="box">
                        <i class="fas fa-ticket"></i>
                        <div class="text">Réservation en ligne</div>
                        <p>Plus besoin de vous déplacer, CrossBus vous offre la possibilité de Réserver vos places en ligne.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fas fa-credit-card"></i>
                        <div class="text">Payment en ligne</div>
                        <p>CrossBus vous donne la possibilité de payer vos réservations en ligne avec 100% d'assurance</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fas fa-glasses"></i>
                        <div class="text">Restez bien informé</div>
                        <p>Avec CrossBus vous serez informé sur tous les détails de votre voyage(horaire,correspondance...)</p>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="max-width">
            <h2 class="title">Nous contacter</h2>
            <div class="contact-content">
                <div class="column left">
                    <div class="text">entrer en contact</div>
                    <p>Vous pouvez signaler un probléme ou laisser votre avis en envoyant un message pour nous aider à améliorer CrossBus </p>
                    <div class="icons">
                        <div class="row">
                            <i class="fas fa-user"></i>
                            <div class="info">
                                <div class="head">Nom</div>
                                <div class="sub-title">Benyagoub Skander, Daoudi Tarek</div>
                            </div>
                        </div>
                        <div class="row">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info">
                                <div class="head">Address</div>
                                <div class="sub-title">Annaba, Algerie</div>
                            </div>
                        </div>
                        <div class="row">
                            <i class="fas fa-envelope"></i>
                            <div class="info">
                                <div class="head">Email</div>
                                <div class="sub-title">CrossBus@gmail.com</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="text">Message</div>
                    <form action="#">
                        <div class="fields">
                            <div class="field name">
                                <input type="text" placeholder="Nom" required>
                            </div>
                            <div class="field email">
                                <input type="email" placeholder="E-mail" required>
                            </div>
                        </div>
                        <div class="field">
                            <input type="text" placeholder="Objet" required>
                        </div>
                        <div class="field textarea">
                            <textarea cols="30" rows="10" placeholder="Message.." required></textarea>
                        </div>
                        <div class="button-area">
                            <button type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section start -->
    <footer>
        <span>Créé par <a href="#">CrossBus-coding</a> |  tous droits réservés <span class="far fa-copyright"></span> 2022</span>
    </footer>

    <script src="script.js"></script>

    <script type='text/javascript'>
    $(document).ready(function(){
    $('#depart').on('change',function() {
        var depart_id = $(this).val();
        console.log(depart_id);
        $.ajax({
            url:'searchbook.php',
            type:'POST',
            cache:false,
            data:{depart_id:depart_id},
            dataType: 'html',
            success:function(data){
                $('#arrive').html(data);
                
            },error:function(){
               
            }
        });
       
    });

    
});


var today = new Date();

var dd = today.getDate();

var mm = today.getMonth()+1; 

var yyyy = today.getFullYear();

if(dd<10){

  dd='0'+dd

} 

if(mm<10){

  mm='0'+mm

} 


today = yyyy+'-'+mm+'-'+dd;

document.getElementById("traveldate").setAttribute("min", today);
</script>
</body>
</html>
