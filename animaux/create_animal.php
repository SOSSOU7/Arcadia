<?php
require '../functions.php';

// Exemple pour une page accessible à l'administrateur et à l'employé
checkUserRole(['administrateur', 'employe']);


// Récupérer la liste des habitats pour le formulaire
$habitats = getHabitats();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $race = $_POST['race'];
    $etat = $_POST['etat'];
    $habitat_id = $_POST['habitat_id'];
    
    $target_dir = "../uploads/";
    $uploadOk = 1;
    $images = [];

    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Vérifier si l'image est réelle ou fausse
        $check = getimagesize($tmp_name);
        if ($check === false) {
            echo "Le fichier " . $_FILES["images"]["name"][$key] . " n'est pas une image.";
            $uploadOk = 0;
            break;
        }
        
        // Vérifier si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, le fichier " . $_FILES["images"]["name"][$key] . " existe déjà.";
            $uploadOk = 0;
            break;
        }
        
        // Vérifier la taille du fichier
        if ($_FILES["images"]["size"][$key] > 10000000) {
            echo "Désolé, le fichier " . $_FILES["images"]["name"][$key] . " est trop volumineux.";
            $uploadOk = 0;
            break;
        }
        
        // Autoriser certains formats de fichier
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
            break;
        }
        
        // Si tout est correct, essayer de télécharger le fichier
        if ($uploadOk == 1 && move_uploaded_file($tmp_name, $target_file)) {
            $images[] = $target_file;
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de " . $_FILES["images"]["name"][$key];
            $uploadOk = 0;
            break;
        }
    }

    if ($uploadOk == 1) {
        $images_paths = implode(',', $images); // Concaténer les chemins des images en une chaîne de caractères séparée par des virgules
        $details = [
            'prenom' => $prenom,
            'race' => $race,
            'images' => $images_paths,
            'etat' => $etat
        ];

        if (createAnimal($details)) {
            $animal_id = $pdo->lastInsertId();
            if (addAnimalToHabitat($animal_id, $habitat_id)) {
                echo "Animal ajouté et associé à l'habitat avec succès.";
            } else {
                echo "Erreur lors de l'association de l'animal à l'habitat.";
            }
        } else {
            echo "Erreur lors de l'ajout de l'animal.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Menu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../services/create_service.php">Service</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../animaux/create_animal.php">Animaux</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../avis/avis.php">Avis</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../horaires/create_horaires.php">Horaires</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../register.php">Utilisateurs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../habitat/create_habitat.php">Habitat</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
    <h1>Ajouter un Nouvel Animal</h1>
    <form action="create_animal.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>

        <div class="form-group">
            <label for="race">Race:</label>
            <input type="text" class="form-control" id="race" name="race" required>
        </div>

        <div class="form-group">
            <label for="etat">État de l'animal:</label>
            <input type="text" class="form-control" id="etat" name="etat" required>
        </div>

        <div class="form-group">
            <label for="images">Images (fichiers):</label>
            <input type="file" class="form-control-file" id="images" name="images[]" multiple required>
        </div>

        <div class="form-group">
            <label for="habitat_id">Habitat:</label>
            <select class="form-control" id="habitat_id" name="habitat_id" required>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= $habitat['id'] ?>"><?= $habitat['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <a href="animal.php" class="btn btn-secondary mt-3">Retour à la liste des animaux</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
