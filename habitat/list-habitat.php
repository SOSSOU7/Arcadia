<!-- <?php
/*require '../functions.php';

$habitats = getHabitats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Habitats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            width: 300px;
        }
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
    <h1>Liste des Habitats</h1>
    <div id="habitats-container">
        <?php foreach ($habitats as $habitat): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($habitat['nom']); ?></h2>
                <p><?php echo htmlspecialchars($habitat['description']); ?></p>
                <?php
                $images = explode(',', $habitat['images']);
                if (count($images) > 0 && !empty($images[0])):
                ?>
                    <div class="slider">
                        <?php foreach ($images as $image): ?>
                            <div>
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="Image de l'habitat">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; */?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
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
</body>
</html> -->
<?php foreach ($habitats as $habitat): ?>
    <div class="service-item">
    <?php
                $images = explode(',', $habitat['images']);
                if (count($images) > 0 && !empty($images[0])):
                ?>
                    
                        <?php foreach ($images as $image): ?>
                            
                                <img  src="<?php echo htmlspecialchars($image); ?>" alt="Image de l'habitat">
                            
                        <?php endforeach; ?>
                    
                <?php endif; ?>
        <div class="content">
          <a href="habitat_details.php?id=<?php echo $habitat['id']; ?>"><h3><?php echo htmlspecialchars($habitat['nom']); ?></h3></a>
          <p class="service-p"><?php echo htmlspecialchars($habitat['description']); ?></p>
        </div>
      </div>
    <?php endforeach; ?>