<?php

require '../functions.php';



//récupérer les horaires
$schedules = getSchedules();

require '../db.php';
require '../vendor/autoload.php'; // Charger PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Récupérer les emails de tous les employés
    $sql = "SELECT U.username AS email FROM Employe E JOIN Utilisateur U ON E.utilisateur_id = U.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($employes) {
        $mail = new PHPMailer(true);
        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Remplacez par votre hôte SMTP
            $mail->SMTPAuth = true;
            $mail->Username = '919ed6201f0257'; // Remplacez par votre nom d'utilisateur Mailtrap
            $mail->Password = '83a8e27464f8e8'; // Remplacez par votre mot de passe Mailtrap
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;

            // Destinataire et contenu de l'email
            foreach ($employes as $employe) {
                $mail->addAddress($employe['email']);
            }
            $mail->setFrom($email);
            $mail->Subject = $titre;
            $mail->Body    = "Message de: $email\n\n$message";
            $mail->AltBody = "Message de: $email\n\n$message";

            $mail->send();
            echo "Votre message a été envoyé avec succès à tous les employés.";
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
        }
    } else {
        echo "Aucun employé trouvé pour envoyer le message.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Contact/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:12 GMT -->
<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Title --> 
  <title>ZOO ARCADIA</title> 

  <!-- Favicon -->
 <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

  <!-- Font-Awesome (CSS) -->
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/all.min.css">

  <!-- Custom Stylesheets -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/responsive.css">


</head>

<body>

  <!-- ==================== Scroll-Top Area (Start) ==================== -->
  <a href="#" class="scroll-top">
    <i class="fas fa-long-arrow-alt-up"></i>
  </a>
  <!-- ==================== Scroll-Top Area (End) ==================== -->



  <!-- ==================== Header Area (Start) ==================== -->
  <header>

    <!-- ===== Header Area (Start) ===== -->
  <?php include_once('includes/header.php'); ?>
    <!-- ===== Header Area (Ends) ===== -->

  

  </header>
  <!-- ==================== Header Area (End) ==================== -->


        
  <!-- ==================== Page-Title (Start) ==================== -->
  <div class="page-title">

    <div class="title">
      <h2>Contactez-nous</h2>
    </div> 

    <div class="link">
      <a href="index.php">Accueil</a>
      <i class="fas fa-angle-double-right"></i>
      <span class="page">Contact</span>
    </div>

  </div>
  <!-- ==================== Page-Title (End) ==================== -->
 
        

  <!-- ==================== Contact Area (Start) ==================== -->
  <section class="contact" id="contact">

    <div class="box-container"> 

      <!-- ========== Contact Form (Start) ========== -->

<div class="contact-container">

        <h3>Contactez-nous</h3> 

        <form method="post" class="contact-form"  action="contact.php"> 

          <div class="input-box">
            <input type="text" name="titre" class="box" id="name" placeholder="Titre" required>
            <input type="email" name="email" class="box" id="email" placeholder="E-mail" required>
          </div>
                
          <textarea cols="30" rows="10" name="message" class="box" id="comment" placeholder="Message"></textarea>
          
          <button type="submit" class="btn" name="submit" >Envoyer</button>

          

        </form>

      </div>

      <!-- ========== Contact Form (End) ========== --> 

      <!-- ========== Contact Info (Start) ========== -->
      <!-- <div class="contact-info">

        <div class="info-item">
          <i class="fas fa-phone"></i>
          <div class="content">
            <h3>contact</h3>
            <p>+111-222-333</p>
            <p>+123-456-789</p>
          </div>
        </div>

        <div class="info-item">
          <i class="fa-regular fa-clock"></i>
          <div class="content">
            <h3>Opening Hours</h3>
            <p>Mon - Fri : 8am - 6pm</p>
            <p>Sat - Sun : 10am - 4pm</p>
          </div>
        </div>

        <div class="info-item">
          <i class="fas fa-envelope"></i>
          <div class="content">
            <h3>Email</h3>
            <p class="gmail">abc@gmail.com</p>
            <p class="gmail">xyz@gmail.com</p>
          </div>
        </div>

        <div class="info-item">
          <i class="fa-solid fa-map-location-dot"></i>
            <div class="content">
              <h3>address</h3>
              <p>karachi, pakistan</p>
            </div>
        </div>

      </div> -->
      <!-- ========== Contact Info (End) ========== -->

    </div>

  </section>
  <!-- ==================== Contact Area (End) ==================== -->



  <!-- ==================== Footer Area (Start) ==================== -->
  <?php include_once('includes/footer.php'); ?>
  <!-- ==================== Footer Area (End) ==================== -->


  <!-- Jquery -->
  <script src="../assets/vendors/jquery/jquery.min.js"></script>

  <!-- Custom Script Files -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/nav-link-toggler.js"></script>

  

  <!-- ==================== Custom Script ==================== -->

  <!-- Contact-Form Script -->
  <script>
    jQuery('#contact-form').on('submit',function(e){
      jQuery('#contact-form #msg').html('');
      jQuery('#contact-form #submit').html('Please wait');
      jQuery('#contact-form #submit').attr('disabled',true);
      jQuery.ajax({
        url:'assets/php/submit.php',
        type:'post',
        data:jQuery('#contact-form').serialize(),
        success:function(result){
            jQuery('#contact-form #msg').html(result);
            jQuery('#contact-form #submit').html('Submit');
            jQuery('#contact-form #submit').attr('disabled',false);
            jQuery('#contact-form')[0].reset();
        }
      });
      e.preventDefault();
    });
  </script>


</body>

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Contact/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:12 GMT -->
</html>