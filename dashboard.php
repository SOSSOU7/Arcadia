<?php
// dashboard.php
require 'functions.php';

$consultations = getAnimalConsultations();
?>
<?php

// Exemple pour une page accessible à l'administrateur et à l'employé
checkUserRole(['administrateur']);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
</head>
<body>
    <h1>Consultations des Animaux</h1>
    <table>
        <thead>
            <tr>
                <th>Animal ID</th>
                <th>Nombre de Consultations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultations as $consultation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($consultation['animal_id']); ?></td>
                    <td><?php echo htmlspecialchars($consultation['count']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
