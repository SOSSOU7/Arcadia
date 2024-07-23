<?php
require '../functions.php';

checkUserRole(['administrateur', 'employe']);



$reviews = getReviews();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['toggle_validation'])) {
        $review_id = $_POST['review_id'];
        $current_status = $_POST['current_status'];
        $new_status = $current_status == 1 ? 0 : 1;

        if (validateReview($review_id, $new_status)) {
            echo "État de l'avis mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de l'état de l'avis.";
        }

        // Rafraîchir la liste des avis après une opération de mise à jour
        $reviews = getReviews();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Avis</title>
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
    <h1 class="mb-4">Liste des Avis</h1>
    <ul class="list-group">
        <?php foreach ($reviews as $review): ?>
            <li class="list-group-item mb-3">
                <p><strong>Pseudo:</strong> <?php echo htmlspecialchars($review['pseudo']); ?></p>
                <p><strong>Contenu:</strong> <?php echo htmlspecialchars($review['commentaire']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($review['date']); ?></p>
                <p><strong>Statut:</strong> <?php echo $review['valide'] == 1 ? 'Validé' : 'Invalidé'; ?></p>
                <form action="" method="post">
                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                    <input type="hidden" name="current_status" value="<?php echo $review['valide']; ?>">
                    <button type="submit" name="toggle_validation" class="btn btn-<?php echo $review['valide'] == 1 ? 'danger' : 'success'; ?>">
                        <?php echo $review['valide'] == 1 ? 'Invalider' : 'Valider'; ?>
                    </button>
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
