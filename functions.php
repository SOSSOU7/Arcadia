
<?php
session_start();
require 'db.php';
//déconnexion
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
//vérification des rôles
//session_start();

function checkUserRole(array $roles) {
    if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], $roles)) {
        ?>
        <h1>403 Erreur</h1>
        <?php
        exit;
    }
}



// Système CRUD pour les habitats

//Créer un habitat
function createHabitat($nom, $description, $images) {
global $pdo;
    
    
    $sql = "INSERT INTO Habitat (nom, description, images) VALUES (:nom, :description, :images)";
    $stmt = $pdo->prepare($sql);
    
    //protection contre les injections sql
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':images', $images);
    
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    } else {
        return false;
    }
}
//récupérer un habitat
function getHabitats() {
    global $pdo;
    
    $sql = "SELECT * FROM Habitat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Récupérer un habitat spécifique par ID
function getHabitatById($habitat_id) {
    global $pdo;
    
    $sql = "SELECT * FROM Habitat WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $habitat_id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//Mettre à jour un habitat
function updateHabitat($habitat_id, $nom, $description, $images) {
    global $pdo;
    
    $sql = "UPDATE Habitat SET nom = :nom, description = :description, images = :images WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':images', $images);
    $stmt->bindParam(':id', $habitat_id);
    
    return $stmt->execute();
}

//Supprimer un habitat
function deleteHabitat($habitat_id) {
    global $pdo;
    
    $sql = "DELETE FROM Habitat WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $habitat_id);
    
    return $stmt->execute();
}

///// CRUD Pour les animaux
// ajouter un animal
function createAnimal($details){
    global $pdo;

    $sql="INSERT INTO Animal(prenom, race, images, etat) VALUES (:prenom, :race, :images, :etat)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($details);


}

//Récupérer la liste des animaux
function getAnimals() {
    global $pdo;
    
    $sql = "SELECT * FROM Animal";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Récupérer les Détails d'un Animal Spécifique
function getAnimalById($animal_id) {
    global $pdo;
    
    $sql = "SELECT * FROM Animal WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=>$animal_id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Mettre à jour les informations d'un animal

function updateAnimal($id, $prenom, $race, $etat, $images_paths, $habitat_id) {
    global $pdo;

    if (empty($images_paths)) {
        $sql = "UPDATE Animal SET prenom = :prenom, race = :race, etat = :etat, habitat_id = :habitat_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);
    } else {
        $sql = "UPDATE Animal SET prenom = :prenom, race = :race, etat = :etat,  images = :images, habitat_id = :habitat_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':images', $images_paths);
    }

    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':race', $race);
    $stmt->bindParam(':etat', $etat);
    $stmt->bindParam(':habitat_id', $habitat_id);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}


//Suppression d'un animal
function deleteAnimal($animal_id) {
    global $pdo;
    
    $sql = "DELETE FROM Animal WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute(['id' => $animal_id]);
}

//Associer un animal à un habitat
function addAnimalToHabitat($animal_id, $habitat_id) {
    global $pdo;
    $sql = "UPDATE Animal SET habitat_id = :habitat_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $animal_id, 'habitat_id' => $habitat_id]);
}

//Récupérer les animaux d'un habitat spécifique
function getAnimalsByHabitat($habitat_id) {
    global $pdo;
    $sql = "SELECT * FROM Animal WHERE habitat_id = :habitat_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['habitat_id' => $habitat_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//récupérer un habitat et ses informations
function getHabitatWithAnimals($habitat_id) {
    global $pdo;

    // Récupérer les informations de l'habitat
    $sql = "SELECT * FROM Habitat WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $habitat_id, PDO::PARAM_INT);
    $stmt->execute();
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($habitat) {
        // Récupérer les animaux associés à cet habitat
        $sql = "SELECT * FROM Animal WHERE habitat_id = :habitat_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':habitat_id', $habitat_id, PDO::PARAM_INT);
        $stmt->execute();
        $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $habitat['animals'] = $animals;
    }

    return $habitat;
}

// Ajoute un nouveau service avec une image
function createService($details) {
    global $pdo;
    $sql = "INSERT INTO Service (nom, description, image) VALUES (:nom, :description, :image)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nom' => $details['nom'],
        ':description' => $details['description'],
        ':image' => $details['image']
    ]);
}

// Récupère la liste des services
function getServices() {
    global $pdo;
    $sql = "SELECT * FROM Service";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupère les détails d'un service spécifique
function getServiceById($service_id) {
    global $pdo;
    $sql = "SELECT * FROM Service WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $service_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Met à jour les informations d'un service avec une image
function updateService($service_id, $new_details) {
    global $pdo;
    $sql = "UPDATE Service SET nom = :nom, description = :description, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nom' => $new_details['nom'],
        ':description' => $new_details['description'],
        ':image' => $new_details['image'],
        ':id' => $service_id
    ]);
}

// Supprime un service
function deleteService($service_id) {
    global $pdo;
    $sql = "DELETE FROM Service WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $service_id]);
}


//CRUD DES AVIS

//Créer un avis
function createReview( $pseudo, $commentaire) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO Avis ( pseudo, commentaire, date, valide) VALUES ( :pseudo, :commentaire, NOW(), 0)');
    return $stmt->execute([
        
        'pseudo' => $pseudo,
        'commentaire' => $commentaire
    ]);
}


//récupérer un avis
function getReviews() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM Avis');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//récupérer un avis par id
function getReviewById($review_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM Avis WHERE id = :id');
    $stmt->execute(['id' => $review_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Supprimer un avis
function deleteReview($review_id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM Avis WHERE id = :id');
    return $stmt->execute(['id' => $review_id]);
}

//fonction pour valider ou invalider un avis
function validateReview($review_id, $status) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE Avis SET valide = :status WHERE id = :review_id');
    return $stmt->execute([
        'status' => $status,
        'review_id' => $review_id
    ]);
}
function getReviewsValid($onlyValid = true) {
    global $pdo;
    $query = 'SELECT * FROM Avis';
    if ($onlyValid) {
        $query .= ' WHERE valide = 1';
    }
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//CRUD des horaires
//créer un horaire
function createSchedule($jour, $ouverture, $fermeture) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO Horaire (jour, heureOuverture, heureFermeture) VALUES (?, ?, ?)');
    return $stmt->execute([$jour, $ouverture, $fermeture]);
}

//récupérer les horaires
function getSchedules() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM Horaire');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//récupérer un horaire par id
function getScheduleById($schedule_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM Horaire WHERE id = ?');
    $stmt->execute([$schedule_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Mise à jour d'un horaire
function updateSchedule($schedule_id, $jour, $ouverture, $fermeture) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE Horaire SET jour = ?, heureOuverture = ?, heureFermeture = ? WHERE id = ?');
    return $stmt->execute([$jour, $ouverture, $fermeture, $schedule_id]);
}

//suprimmer un horaire
function deleteSchedule($schedule_id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM Horaire WHERE id = ?');
    return $stmt->execute([$schedule_id]);
}

//récupération des employés pour envoie de mails
function getEmployees() {
    global $pdo;

    // Requête pour récupérer les emails des employés
    $stmt = $pdo->prepare("SELECT username FROM employe");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//CRUD des comptes rendus

// Ajoute un nouveau compte rendu
function createReport($details) {
    global $pdo;
    $sql = "INSERT INTO CompteRendu (animal_id, etat, nourritureProposee, grammageNourriture, date, details) VALUES (:animal_id, :etat, :nourritureProposee, :grammageNourriture, :date, :details)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':animal_id' => $details['animal_id'],
        ':etat' => $details['etat'],
        ':nourritureProposee' => $details['nourritureProposee'],
        ':grammageNourriture' => $details['grammageNourriture'],
        ':date' => $details['date'],
        ':details' => $details['details']
    ]);
}

// Récupère la liste des comptes rendus
function getReports() {
    global $pdo;
    $sql = "SELECT * FROM CompteRendu";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupère les détails d'un compte rendu spécifique
function getReportById($report_id) {
    global $pdo;
    $sql = "SELECT * FROM CompteRendu WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $report_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Met à jour les informations d'un compte rendu
function updateReport($report_id, $new_details) {
    global $pdo;
    $sql = "UPDATE CompteRendu SET etat = :etat, nourritureProposee = :nourritureProposee, grammageNourriture = :grammageNourriture, date = :date, details = :details, animal_id = :animal_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':etat' => $new_details['etat'],
        ':nourritureProposee' => $new_details['nourritureProposee'],
        ':grammageNourriture' => $new_details['grammageNourriture'],
        ':date' => $new_details['date'],
        ':details' => $new_details['details'],
        ':animal_id' => $new_details['animal_id'],
        ':id' => $report_id
    ]);
}

// Supprime un compte rendu
function deleteReport($report_id) {
    global $pdo;
    $sql = "DELETE FROM CompteRendu WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $report_id]);
}

//récupérer le dernier compte rendu d'un animal
function getLastReportByAnimalId($animal_id) {
    global $pdo;
    $sql = "SELECT * FROM CompteRendu WHERE animal_id = :animal_id ORDER BY date DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':animal_id' => $animal_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// db_mongo.php
require 'vendor/autoload.php'; // Charger l'autoloader de Composer

function getMongoClient() {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    return $client->selectDatabase('votre_base_de_donnees');
}

function incrementAnimalConsultation($animal_id) {
    $db = getMongoClient();
    $collection = $db->selectCollection('consultations');

    $collection->updateOne(
        ['animal_id' => $animal_id],
        ['$inc' => ['count' => 1]],
        ['upsert' => true]
    );
}

function getAnimalConsultations() {
    $db = getMongoClient();
    $collection = $db->selectCollection('consultations');

    return $collection->find()->toArray();
}



?>




