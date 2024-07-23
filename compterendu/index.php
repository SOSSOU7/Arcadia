<?php

checkUserRole(['veterinaire']);

require '../db.php';
require '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $details = [
            'date' => $_POST['date'],
            'etat' => $_POST['etat'],
            'nourritureProposee' => $_POST['nourritureProposee'],
            'grammageNourriture' => $_POST['grammageNourriture'],
            'details' => $_POST['details'],
            'animal_id' => $_POST['animal_id']
        ];
        if (createReport($details)) {
            echo "Compte rendu ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du compte rendu.";
        }
    } elseif (isset($_POST['update'])) {
        $report_id = $_POST['id'];
        $new_details = [
            'date' => $_POST['date'],
            'etat' => $_POST['etat'],
            'nourritureProposee' => $_POST['nourritureProposee'],
            'grammageNourriture' => $_POST['grammageNourriture'],
            'details' => $_POST['details'],
            'animal_id' => $_POST['animal_id']
        ];
        if (updateReport($report_id, $new_details)) {
            echo "Compte rendu mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du compte rendu.";
        }
    } elseif (isset($_POST['delete'])) {
        $report_id = $_POST['id'];
        if (deleteReport($report_id)) {
            echo "Compte rendu supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du compte rendu.";
        }
    }
}

$reports = getReports();
$animals = getAnimals();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Comptes Rendus</title>
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
    <h1 class="mb-4">Ajouter un Nouveau Compte Rendu</h1>
    <form action="" method="post" class="mb-5">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="etat">État:</label>
            <input type="text" id="etat" name="etat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nourritureProposee">Nourriture proposée:</label>
            <input type="text" id="nourritureProposee" name="nourritureProposee" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="grammageNourriture">Grammage de la nourriture:</label>
            <input type="number" step="0.01" id="grammageNourriture" name="grammageNourriture" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="details">Détails:</label>
            <textarea id="details" name="details" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="animal_id">Animal:</label>
            <select id="animal_id" name="animal_id" class="form-control" required>
                <?php foreach ($animals as $animal): ?>
                    <option value="<?php echo $animal['id']; ?>"><?php echo htmlspecialchars($animal['prenom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="create" class="btn btn-primary">Ajouter</button>
    </form>

    <h1>Liste des Comptes Rendus</h1>
    <ul class="list-group">
        <?php foreach ($reports as $report): ?>
            <li class="list-group-item mb-3">
                <form action="" method="post" class="form-inline">
                    <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                    <div class="form-group mr-2">
                        <label for="date" class="sr-only">Date</label>
                        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($report['date']); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="etat" class="sr-only">État</label>
                        <input type="text" name="etat" class="form-control" value="<?php echo htmlspecialchars($report['etat']); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="nourritureProposee" class="sr-only">Nourriture proposée</label>
                        <input type="text" name="nourritureProposee" class="form-control" value="<?php echo htmlspecialchars($report['nourritureProposee']); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="grammageNourriture" class="sr-only">Grammage de la nourriture</label>
                        <input type="number" step="0.01" name="grammageNourriture" class="form-control" value="<?php echo htmlspecialchars($report['grammageNourriture']); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="details" class="sr-only">Détails</label>
                        <textarea name="details" class="form-control"><?php echo htmlspecialchars($report['details']); ?></textarea>
                    </div>
                    <div class="form-group mr-2">
                        <label for="animal_id" class="sr-only">Animal</label>
                        <select name="animal_id" class="form-control">
                            <?php foreach ($animals as $animal): ?>
                                <option value="<?php echo $animal['id']; ?>" <?php echo $animal['id'] == $report['animal_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($animal['prenom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-success mr-2">Mettre à jour</button>
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
