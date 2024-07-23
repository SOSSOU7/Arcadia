<?php
require '../functions.php';

checkUserRole(['administrateur']);

$habitats = getHabitats();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $success_message = '';

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];

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
        }

        // Si de nouvelles images ont été téléchargées, les ajouter à la base de données
        if ($uploadOk == 1) {
            $images_paths = implode(',', $images); // Concaténer les chemins des images en une chaîne de caractères séparée par des virgules
            if (updateHabitat($id, $nom, $description, $images_paths)) {
                $success_message = "Habitat mis à jour avec succès.";
            } else {
                $errors[] = "Erreur lors de la mise à jour de l'habitat.";
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        if (deleteHabitat($id)) {
            $success_message = "Habitat supprimé avec succès.";
        } else {
            $errors[] = "Erreur lors de la suppression de l'habitat.";
        }
    }
    
    // Rafraîchir la liste des habitats après une opération de mise à jour ou de suppression
    $habitats = getHabitats();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Habitats</title>
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
    <h1 class="mb-4">Liste des Habitats</h1>
    <a href="create_habitat.php" class="btn btn-primary mb-4">Ajouter un Nouvel Habitat</a>

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

    <ul class="list-group">
        <?php foreach ($habitats as $habitat): ?>
            <li class="list-group-item mb-3">
                <form action="habitat.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $habitat['id']; ?>">
                    <div class="form-group">
                        <label for="nom-<?php echo $habitat['id']; ?>">Nom:</label>
                        <input type="text" id="nom-<?php echo $habitat['id']; ?>" name="nom" class="form-control" value="<?php echo htmlspecialchars($habitat['nom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description-<?php echo $habitat['id']; ?>">Description:</label>
                        <textarea id="description-<?php echo $habitat['id']; ?>" name="description" class="form-control" required><?php echo htmlspecialchars($habitat['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="images-<?php echo $habitat['id']; ?>">Images (fichiers):</label>
                        <input type="file" id="images-<?php echo $habitat['id']; ?>" name="images[]" class="form-control-file" multiple>
                    </div>
                    <div class="mb-3">
                        <?php
                        $images = explode(',', $habitat['images']);
                        foreach ($images as $image) {
                            echo '<img src="' . $image . '" alt="Image de l\'habitat" class="img-thumbnail mr-2" style="width:100px;">';
                        }
                        ?>
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
