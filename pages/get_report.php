<?php
require '../db.php';

$animal_id = $_GET['animal_id'];

$sql = "SELECT * FROM CompteRendu WHERE animal_id = :animal_id ORDER BY date DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['animal_id' => $animal_id]);

$report = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($report);
?>
