<?php
require '../functions.php';
require '../db.php';



//récupérer les horaires
$schedules = getSchedules();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Utilisateur WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //vérifier si le username et le mot de passe existent 
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Vérifier le rôle de l'utilisateur
        $roles = ['Administrateur', 'Veterinaire', 'Employe'];
        foreach ($roles as $role) {
            $sql = "SELECT * FROM $role WHERE utilisateur_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user['id']]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['user_role'] = strtolower($role);
                break;
            }
        }

        echo "Connexion réussie";
        // Rediriger vers une page sécurisée
        header("Location: dashboard.php");
    } else {
        $error="E-mail ou mot de passe incorrect";
    }
}
?>




<!DOCTYPE html>
<html lang="en"> 

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Shop/Login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:12 GMT -->
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
      <h2>Espace de Connexion</h2>
    </div> 

    <div class="link">
      <a href="../../index.html">Accueil</a>
      <i class="fas fa-angle-double-right"></i>
      <span class="page">Connexion</span>
    </div>

  </div>
  <!-- ==================== Page-Title (End) ==================== -->
  

  
  <!-- ==================== Login Area (Start) ==================== -->
  <section class="login">
    <marquee  direction="right"> <h2>Connexion uniquement réservée au personnel du zoo</h2></marquee>

    <form class="account-form" action="" method="POST">
      <h3>connexion</h3>
      <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
      <div class="input-field">
        <label for="email" class="far fa-envelope"></label>
        <input type="email" name="username" placeholder="Entrez votre mail" id="email" class="box" required>
      </div>
      <div class="input-field">
        <label for="password" class="fas fa-lock"></label> 
        <input type="password" name="password" placeholder="Entrez votre mot de passe" id="password" class="box" required>
      </div>

      
      <button type="submit" class="btn" name="login" id="login-btn">Connexion</button>
    </form> 
  
  </section> 
  <!-- ==================== Login Area (End) ==================== -->
    
     

  <!-- ==================== Footer Area (Start) ==================== -->
  <?php include_once('includes/footer.php'); ?>
  <!-- ==================== Footer Area (End) ==================== -->


    
  <!-- Jquery -->
  <script src="../../assets/vendors/jquery/jquery.min.js"></script>

  <!-- Custom Script Files -->
  <script src="../../assets/js/script.js"></script>
  <script src="../../assets/js/nav-link-toggler.js"></script>

</body>

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Shop/Login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:12 GMT -->
</html>  