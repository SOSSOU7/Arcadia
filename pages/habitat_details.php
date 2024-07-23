<?php
require '../functions.php';




//récupérer les horaires
$schedules = getSchedules();


// Vérifier si un ID d'habitat est fourni
if (!isset($_GET['id'])) {
    echo "ID d'habitat manquant.";
    exit;
}

$habitat_id = $_GET['id'];

// Récupérer les informations de l'habitat et les animaux associés
$habitat = getHabitatWithAnimals($habitat_id);

if (!$habitat) {
    echo "Habitat non trouvé.";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en"> 

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Services/Single-Service.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:00 GMT -->
<head>
 
  <meta charset="UTF-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  

  <!-- Title --> 
  <title><?php echo htmlspecialchars($habitat['nom']); ?></title>  

  <!-- Favicon -->
 <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

  <!-- Font-Awesome (CSS) -->
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/all.min.css">

  <!-- Custom Stylesheets -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/responsive.css">

    <style>
        /* Styles pour le modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


<!-- Modal -->
<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="reportDetails"></div>
    </div>
</div>

<script>
function showReport(animal_id) {
    // Simule une requête Ajax pour récupérer les détails du rapport
    fetch(`get_report.php?animal_id=${animal_id}`)
        .then(response => response.json())
        .then(data => {
            const reportDetails = document.getElementById('reportDetails');
            reportDetails.innerHTML = `
                <h2>Rapport du vétérinaire</h2>
                <p><b>Date :</b> ${data.date}</p>
                <p><b>État :</b> ${data.etat}</p>
                <p><b>Détails :</b> ${data.details}</p>
                <p><b>Nourriture proposée :</b> ${data.nourritureProposee}</p>
                <p><b>Grammage de nourriture :</b> ${data.grammageNourriture} G</p>
            `;
            document.getElementById('reportModal').style.display = "block";
        });

    incrementConsultation(animal_id);
}

// Fermer le modal
document.querySelector('.close').onclick = function() {
    document.getElementById('reportModal').style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('reportModal')) {
        document.getElementById('reportModal').style.display = "none";
    }
}

function incrementConsultation(animal_id) {
    fetch(`increment_consultation.php?animal_id=${animal_id}`)
        .then(response => response.text())
        .then(data => {
            console.log(data);
        });
}
</script>





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


    
  <!-- ==================== Page-Title (Start) ==================== -->
  <div class="page-title">

    <div class="title">
      <h2><?php echo htmlspecialchars($habitat['nom']); ?></h2>
    </div> 

    <div class="link">
      <a href="index.php">Accueil</a>
      <i class="fas fa-angle-double-right"></i>
      <span class="page"><?php echo htmlspecialchars($habitat['nom']); ?></span>
    </div>
 
  </div>
  <!-- ==================== Page-Title (End) ==================== -->



  <!-- ==================== Single Service (Start) ==================== -->
  <section class="single-service page-single">

    <!-- ========== Service Info Container (Start) ========== -->
    <div class="service-info page-info">

      <div class="image"> 
        
        <?php
                $images = explode(',', $habitat['images']);
                if (count($images) > 0 && !empty($images[0])):
                ?>
                    
                        <?php foreach ($images as $image): ?>
                            
                                <img  src="<?php echo htmlspecialchars($image); ?>" alt="Image de l'habitat">
                            
                        <?php endforeach; ?>
                    
                <?php endif; ?>
      </div>

      <div class="content">

        <h3 class="main-heading"><?php echo htmlspecialchars($habitat['nom']); ?></h3>

          <p><?php echo htmlspecialchars($habitat['description']); ?></p>
        
<h3 class="main-heading">Animaux dans cet Habitat</h3>  <!-- ==================== Events Area (Start) ==================== -->
 
<section class="events">

<div class="box-container">

<?php if (empty($habitat['animals'])): ?>
    <p>Aucun animal dans cet habitat.</p>
<?php else: ?>
    <?php foreach ($habitat['animals'] as $animal): ?>
        <div class="event-item">
            <div class="image">
                <?php
                if (!empty($animal['images'])) {
                    $images = explode(',', $animal['images']);
                    foreach ($images as $image) {
                        echo '<img src="' . htmlspecialchars($image) . '" alt="Image">';
                    }
                }
                ?>
            </div>
            <div class="content">
                <a class="main-heading" ><?php echo htmlspecialchars($animal['prenom']); ?></a>
                <p><b>Race :</b> <?php echo htmlspecialchars($animal['race']); ?></p>
                <a href="javascript:void(0)" onclick="showReport('<?php echo $animal['id']; ?>')" class="btn">Voir rapport du vétérinaire</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
function incrementConsultation(animal_id) {
    fetch('increment_consultation.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ animal_id: animal_id })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Consultation incrémentée avec succès');
          } else {
              console.log('Erreur lors de l\'incrémentation de la consultation');
          }
      });
}
</script>


  


 

</div>

</section>
  <!-- ==================== Events Area (End) ==================== -->





      

  

      </div>

    </div>
    <!-- ========== Service Info Container (End) ========== -->



   

  </section>
  <!-- ==================== Single Service (End) ==================== -->
       


  <!-- ==================== Footer Area (Start) ==================== -->
  <?php include_once('includes/footer.php'); ?>
  <!-- ==================== Footer Area (End) ==================== -->
 

  <!-- Jquery -->
  <script src="../assets/vendors/jquery/jquery.min.js"></script>

  <!-- Custom Script Files -->
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/nav-link-toggler.js"></script>



</body>

<!-- Mirrored from astrozoo-html.asdesignsgalaxy.com/pages/Services/Single-Service.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 17:06:00 GMT -->
</html>