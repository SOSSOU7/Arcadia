<?php
require '../functions.php';


checkUserRole(['administrateur', 'employe']);


// Récupérer la liste des animaux et des habitats pour le formulaire
$animals = getAnimals();
$habitats = getHabitats();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $prenom = $_POST['prenom'];
        $race = $_POST['race'];
        $etat = $_POST['etat'];
        $habitat_id = $_POST['habitat_id'];

        $target_dir = "../uploads/";
        $uploadOk = 1;
        $images = [];

        // Vérifier si des fichiers ont été téléchargés
        if (isset($_FILES["images"]) && count($_FILES["images"]["tmp_name"]) > 0 && $_FILES["images"]["name"][0] != "") {
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
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
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
        }

        if ($uploadOk == 1) {
            $images_paths = implode(',', $images);
            if (updateAnimal($id, $prenom, $race, $etat, $grammageNourriture, $nourriturePropose, $images_paths, $habitat_id)) {
                echo "Animal mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de l'animal.";
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        if (deleteAnimal($id)) {
            echo "Animal supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'animal.";
        }
    }

    // Rafraîchir la liste des animaux après une opération de mise à jour ou de suppression
    $animals = getAnimals();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
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
    <h1 class="mb-4">Liste des Animaux</h1>
    <a href="create_animal.php" class="btn btn-primary mb-3">Ajouter un Nouvel Animal</a>
    <ul class="list-group">
        <?php foreach ($animals as $animal): ?>
            <li class="list-group-item mb-3">
                <form action="animal.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                    
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($animal['prenom']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="race">Race:</label>
                        <input type="text" class="form-control" id="race" name="race" value="<?php echo htmlspecialchars($animal['race']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="images">Images (fichiers):</label>
                        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                        <div class="mt-2">
                            <?php
                            $images = explode(',', $animal['images']);
                            foreach ($images as $image) {
                                echo '<img src="' . $image . '" alt="Image de l\'animal" class="img-thumbnail" style="width:100px;"> ';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="habitat_id">Habitat:</label>
                        <select class="form-control" id="habitat_id" name="habitat_id" required>
                            <?php foreach ($habitats as $habitat): ?>
                                <option value="<?= $habitat['id'] ?>" <?= $animal['habitat_id'] == $habitat['id'] ? 'selected' : '' ?>><?= $habitat['nom'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" name="update" class="btn btn-success">Mettre à jour</button>
                    <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
