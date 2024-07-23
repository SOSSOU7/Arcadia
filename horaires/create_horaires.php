<?php
require '../functions.php';

checkUserRole(['administrateur']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $jour = $_POST['jour'];
        $ouverture = $_POST['ouverture'];
        $fermeture = $_POST['fermeture'];
        if (createSchedule($jour, $ouverture, $fermeture)) {
            $success_message = "Horaire ajouté avec succès.";
        } else {
            $error_message = "Erreur lors de l'ajout de l'horaire.";
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $jour = $_POST['jour'];
        $ouverture = $_POST['ouverture'];
        $fermeture = $_POST['fermeture'];
        if (updateSchedule($id, $jour, $ouverture, $fermeture)) {
            $success_message = "Horaire mis à jour avec succès.";
        } else {
            $error_message = "Erreur lors de la mise à jour de l'horaire.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        if (deleteSchedule($id)) {
            $success_message = "Horaire supprimé avec succès.";
        } else {
            $error_message = "Erreur lors de la suppression de l'horaire.";
        }
    }
}

$schedules = getSchedules();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires</title>
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
    <h1>Gestion des Horaires</h1>
    
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

    <h2>Ajouter un Nouvel Horaire</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="jour">Jour:</label>
            <select id="jour" name="jour" class="form-control" required>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="ouverture">Ouverture:</label>
            <input type="time" id="ouverture" name="ouverture" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="fermeture">Fermeture:</label>
            <input type="time" id="fermeture" name="fermeture" class="form-control" required>
        </div>
        
        <button type="submit" name="create" class="btn btn-primary">Ajouter</button>
    </form>
    
    <h2>Liste des Horaires</h2>
    <ul class="list-group">
        <?php foreach ($schedules as $schedule): ?>
            <li class="list-group-item">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
                    
                    <div class="form-group">
                        <label for="jour-<?php echo $schedule['id']; ?>">Jour:</label>
                        <select id="jour-<?php echo $schedule['id']; ?>" name="jour" class="form-control" required>
                            <option value="Lundi" <?php echo ($schedule['jour'] == 'Lundi') ? 'selected' : ''; ?>>Lundi</option>
                            <option value="Mardi" <?php echo ($schedule['jour'] == 'Mardi') ? 'selected' : ''; ?>>Mardi</option>
                            <option value="Mercredi" <?php echo ($schedule['jour'] == 'Mercredi') ? 'selected' : ''; ?>>Mercredi</option>
                            <option value="Jeudi" <?php echo ($schedule['jour'] == 'Jeudi') ? 'selected' : ''; ?>>Jeudi</option>
                            <option value="Vendredi" <?php echo ($schedule['jour'] == 'Vendredi') ? 'selected' : ''; ?>>Vendredi</option>
                            <option value="Samedi" <?php echo ($schedule['jour'] == 'Samedi') ? 'selected' : ''; ?>>Samedi</option>
                            <option value="Dimanche" <?php echo ($schedule['jour'] == 'Dimanche') ? 'selected' : ''; ?>>Dimanche</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ouverture-<?php echo $schedule['id']; ?>">Ouverture:</label>
                        <input type="time" id="ouverture-<?php echo $schedule['id']; ?>" name="ouverture" class="form-control" value="<?php echo htmlspecialchars($schedule['heureOuverture']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fermeture-<?php echo $schedule['id']; ?>">Fermeture:</label>
                        <input type="time" id="fermeture-<?php echo $schedule['id']; ?>" name="fermeture" class="form-control" value="<?php echo htmlspecialchars($schedule['heureFermeture']); ?>" required>
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
