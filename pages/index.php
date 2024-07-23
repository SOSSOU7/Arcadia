<?php
require '../functions.php';

$habitats = getHabitats();

// Récupérer la liste des services
$services = getServices();

// Récupérer uniquement les avis validés
$reviews = getReviewsValid();

//récupérer les horaires
$schedules = getSchedules();

?>
<!DOCTYPE html>
<html lang="en">


<head>
   
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Title --> 
  <title>ARCADIA ZOO</title> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

  <!-- Font-Awesome (CSS) -->
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/all.min.css">

  <!-- Magnific-Popup (CSS) -->
  <link rel="stylesheet" href="../assets/vendors/magnific-popup/magnific-popup.css">

  <!-- Swiper (CSS) -->
  <link rel="stylesheet" href="../assets/vendors/swiper/swiper-bundle.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Custom Stylesheets -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/responsive.css">
  <style>
    .slider {
            width: 100%;
            margin: 10px 0;
        }
        .slider img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
  </style>

</head>
<body>

  <!-- ==================== Scroll-Top Area (Start) ==================== -->
  <a href="#" class="scroll-top">
    <i class="fas fa-long-arrow-alt-up"></i>
  </a>
  <!-- ==================== Scroll-Top Area (End) ==================== -->
    


  <!-- ==================== Header Area (Start) ==================== -->
  <?php include_once('includes/header.php'); ?>
  <!-- ==================== Header Area (End) ==================== -->  



  <!-- ==================== Home-Slider Area (Start) ==================== -->  
  <section class="home">

    <div class="swiper-container home-slider">
      <div class="swiper-wrapper">

        <div class="swiper-slide home-item">
          <img src="../assets/images/Home/Home-1.jpg" alt="">
          <div class="content">
            <div class="text">
              <h5>Bienvenue au ZOO ARCADIA!</h5>
              <h3>Découvrez la nature à l’état sauvage</h3>
              <p>Depuis 1960, le Zoo Arcadia s’est enraciné près de la légendaire forêt de Brocéliande, en Bretagne. Bien plus qu’un simple parc animalier, Arcadia est un sanctuaire de biodiversité, un centre de recherche et d’éducation, et un lieu de préservation dévoué à la sauvegarde des espèces menacées. Notre longue histoire est marquée par la passion pour la préservation des espèces et la sensibilisation à la biodiversité.</p>
              
            </div>
          </div>
        </div>

        <div class="swiper-slide home-item">
          <img src="../assets/images/Home/Home-2.jpg" alt="">
          <div class="content">
            <div class="text">
              <h5>Bienvenue au ZOO ARCADIA!</h5>
              <h3>Nos valeurs écologiques</h3>
              <p>Indépendance énergétique : Arcadia est fier d’être entièrement indépendant au niveau des énergies. Nous utilisons des sources renouvelables pour alimenter nos installations et minimiser notre impact sur l’environnement. Conservation : De la reproduction en captivité à la réintroduction dans la nature, notre équipe de spécialistes travaille sans relâche pour assurer un avenir durable aux espèces menacées. Éducation : Nous sommes déterminés à sensibiliser nos visiteurs à la beauté et à la fragilité de la faune et de la flore. Notre application web vous permettra de découvrir nos résidents fascinants et d’en apprendre davantage sur nos programmes de conservation.</p>
              
            </div>
          </div>
        </div>

        <div class="swiper-slide home-item">
          <img src="../assets/images/Home/Home-3.jpg" alt="">
          <div class="content">
            <div class="text">
              <h5>Bienvenue au ZOO ARCADIA!</h5>
              <h3>Explorez nos habitats</h3>
              <p>Bienvenue dans les vastes étendues sauvages du Zoo Arcadia, où la nature règne en maître dans trois habitats distincts : La jungle : Laissez-vous envelopper par la canopée luxuriante et découvrez une multitude de créatures exotiques, des singes bondissants aux papillons aux couleurs vives. La savane : Contemplez le spectacle envoûtant des troupeaux en migration, des lions en chasse et des éléphants se désaltérant aux points d’eau. L’esprit sauvage de la savane africaine vous imprégnera. Les marais : Explorez ces écosystèmes humides où les eaux calmes et les roseaux ondulants abritent une vie abondante et fascinante, des crocodiles silencieux aux oiseaux échassiers gracieux.</p>
            </div>
          </div>
        </div>

      </div>

      <div class="swiper-pagination swiper-pagination1"></div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

    </div>

  </section>
  <!-- ==================== Home-Slider Area (End) ==================== -->    

  

    


  <!-- ==================== About Area (Start) ==================== --> <div class="heading">  
      <h2>Nos services</h2>  
    </div>
    <?php foreach ($services as $service): ?>
    <section class="about">
        <div class="box-container">
            
                
                    <div class="image">
                        <?php if ($service['image']): ?>
                        <img src="<?php echo $service['image']; ?>" alt="Image du service" >
                    <?php endif; ?>
                    </div>
                    <div class="content">
                        <h3><?php echo htmlspecialchars($service['nom']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
              
            
        </div>
    </section>
  <?php endforeach; ?>

  <!-- ==================== About Area (End) ==================== -->



 



  <!-- ==================== Services Area (Start) ==================== -->
  <section class="services">

    <div class="heading">  
      <h2>Nos habitats</h2>  
    </div>

    <div class="box-container">

   
  <?php include_once('../habitat/list-habitat.php'); ?>

    </div>

  </section>
  <!-- ==================== Services Area (End) ==================== -->


  <!-- ==================== Testimonials Area (Start) ==================== -->
  <section class="home-testimonial linear-bg">

    <div class="heading">  
      <h2>Avis de nos visiteurs</h2>  
    </div>
  
    <div class="swiper-container testimonial-slider">
      <div class="swiper-wrapper">
      <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $review): ?>
        <div class="swiper-slide testi-item">
          <div class="text">
            <h4><?php echo htmlspecialchars($review['pseudo']); ?></h4> 
          </div>
          <p><?php echo htmlspecialchars($review['commentaire']); ?></p>
          
        </div>
          <?php endforeach; ?>
       <?php else: ?>
            <li>Aucun avis validé pour le moment.</li>
      <?php endif; ?>
    </ul>

        
          
      </div>

      <div class="swiper-pagination swiper-pagination3"></div>

    </div>

    
   
              <?php 
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $utilisateur_id = $_POST['utilisateur_id'];
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['contenu'];

    if (createReview( $pseudo, $commentaire)) { ?>
       <script>alert('avis ajouté avec succès');</script> 
       <?php
    } else {
        echo "Erreur lors de l'ajout de l'avis.";
    }
}
?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Laisser un avis</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Votre avis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="form-group">
            <label for="pseudo" class="col-form-label">Votre Pseudo:</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo">
          </div>
          <div class="form-group">
            <label for="contenu" class="col-form-label">Message:</label>
            <textarea class="form-control" id="contenu" name="contenu"></textarea>
          </div>
          <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur_id; ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Soumettre</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

               </div>
      </div>
  </section>
  <!-- ==================== Testimonials Area (End) ==================== -->







  <!-- ==================== Blogs Area (Start) ==================== -->
  <section class="blog main">

   
  
  
  
  </section>
  <!-- ==================== Blogs Area (End) ==================== -->



  <!-- ==================== Footer Area (Start) ==================== -->
  <?php include_once('includes/footer.php'); ?>
  <!-- ==================== Footer Area (End) ==================== -->



  <!-- Jquery -->
  <script src="../assets/vendors/jquery/jquery.min.js"></script>

  <!-- Magnific-Popup JS -->
  <script src="../assets/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Swiper (JS) -->
  <script src="../assets/vendors/swiper/swiper-bundle.min.js"></script>

  <!-- Custom Script Files -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/nav-link-toggler.js"></script>
  <script src="../assets/js/home-slider.js"></script>
  <script src="../assets/js/counter-up.js"></script>
  <script src="../assets/js/testi-slider.js"></script>
  <script src="../https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true
            });
        });
    </script>
  <script src="../https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="../https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:05:46 GMT -->
</html>

