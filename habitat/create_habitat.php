<?php
require '../functions.php';
checkUserRole(['administrateur']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    
    $target_dir = "../uploads/";
    $uploadOk = 1;
    $images = [];
    $errors = [];

    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Vérifier si l'image est réelle ou fausse
        $check = getimagesize($tmp_name);
        if ($check === false) {
            $errors[] = "Le fichier " . $_FILES["images"]["name"][$key] . " n'est pas une image.";
            $uploadOk = 0;
            break;
        }
        
        // Vérifier si le fichier existe déjà
        if (file_exists($target_file)) {
            $errors[] = "Désolé, le fichier " . $_FILES["images"]["name"][$key] . " existe déjà.";
            $uploadOk = 0;
            break;
        }
        
        // Vérifier la taille du fichier
        if ($_FILES["images"]["size"][$key] > 10000000) {
            $errors[] = "Désolé, le fichier " . $_FILES["images"]["name"][$key] . " est trop volumineux.";
            $uploadOk = 0;
            break;
        }
        
        // Autoriser certains formats de fichier
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors[] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
            break;
        }
        
        // Si tout est correct, essayer de télécharger le fichier
        if ($uploadOk == 1 && move_uploaded_file($tmp_name, $target_file)) {
            $images[] = $target_file;
        } else {
            $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de " . $_FILES["images"]["name"][$key];
            $uploadOk = 0;
            break;
        }
    }

    if ($uploadOk == 1) {
        $images_paths = implode(',', $images); // Concaténer les chemins des images en une chaîne de caractères séparée par des virgules
        if (createHabitat($nom, $description, $images_paths)) {
            $success_message = "Habitat ajouté avec succès.";
        } else {
            $errors[] = "Erreur lors de l'ajout de l'habitat.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Habitat</title>
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
    <h1 class="mb-4">Ajouter un Nouvel Habitat</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <form action="create_habitat.php" method="post" enctype="multipart/form-data" class="mb-5">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="images">Images (fichiers):</label>
            <input type="file" id="images" name="images[]" class="form-control" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <a href="habitat.php" class="btn btn-secondary">Retour à la liste des habitats</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
