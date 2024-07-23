<?php
require '../db.php';
require '../functions.php';

checkUserRole(['administrateur']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create']) || isset($_POST['update'])) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        // Gérer le téléchargement de l'image
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "../uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Vérifiez si l'image est valide
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                    exit;
                }
            } else {
                echo "Le fichier n'est pas une image.";
                exit;
            }
        }

        if (isset($_POST['create'])) {
            if (createService(['nom' => $nom, 'description' => $description, 'image' => $imagePath])) {
                echo "Service ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout du service.";
            }
        } elseif (isset($_POST['update'])) {
            $id = $_POST['id'];
            if (updateService($id, ['nom' => $nom, 'description' => $description, 'image' => $imagePath])) {
                echo "Service mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du service.";
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        if (deleteService($id)) {
            echo "Service supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du service.";
        }
    }
}

$services = getServices();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services</title>
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
    <h1>Gestion des Services</h1>
    
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <h2>Ajouter un Nouveau Service</h2>
    <form action="create_service.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>
        
        <button type="submit" name="create" class="btn btn-primary">Ajouter</button>
    </form>
    
    <h2>Liste des Services</h2>
    <ul class="list-group">
        <?php foreach ($services as $service): ?>
            <li class="list-group-item">
                <form action="create_service.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                    <div class="form-group">
                        <label for="nom-<?php echo $service['id']; ?>">Nom:</label>
                        <input type="text" id="nom-<?php echo $service['id']; ?>" name="nom" class="form-control" value="<?php echo htmlspecialchars($service['nom']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="description-<?php echo $service['id']; ?>">Description:</label>
                        <textarea id="description-<?php echo $service['id']; ?>" name="description" class="form-control"><?php echo htmlspecialchars($service['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image-<?php echo $service['id']; ?>">Image:</label>
                        <input type="file" id="image-<?php echo $service['id']; ?>" name="image" class="form-control">
                        <?php if ($service['image']): ?>
                            <img src="<?php echo $service['image']; ?>" alt="Image du service" class="img-thumbnail mt-2" style="width:100px;">
                        <?php endif; ?>
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
