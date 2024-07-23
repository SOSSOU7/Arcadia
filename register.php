<?php
require 'db.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
 
    // Vérifier si le nom d'utilisateur ou l'email existe déjà
    $sql = "SELECT COUNT(*) FROM Utilisateur WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo '<div class="alert alert-danger">Le nom d\'utilisateur ou l\'email est déjà utilisé.</div>';
    } else {
        // Insérer l'utilisateur dans la table Utilisateur
        $sql = "INSERT INTO Utilisateur (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute(['username' => $username, 'password' => $password])) {
            $utilisateur_id = $pdo->lastInsertId();

            // Insérer l'utilisateur dans le rôle approprié
            if ($role === 'admin') {
                $sql = "INSERT INTO Administrateur (utilisateur_id) VALUES (:utilisateur_id)";
            } elseif ($role === 'veterinaire') {
                $sql = "INSERT INTO Veterinaire (utilisateur_id) VALUES (:utilisateur_id)";
            } elseif ($role === 'employe') {
                $sql = "INSERT INTO Employe (utilisateur_id) VALUES (:utilisateur_id)";
            } else {
                echo '<div class="alert alert-danger">Rôle invalide.</div>';
                exit;
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['utilisateur_id' => $utilisateur_id]);

            // Envoi de l'email de confirmation
            $mail = new PHPMailer(true);

            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = '4ac0ab30481b6b'; // Remplacez par votre nom d'utilisateur Mailtrap
                $mail->Password = '6e65016c8d5793'; // Remplacez par votre mot de passe Mailtrap
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 2525;

                // Destinataires
                $mail->setFrom('corneillegbaguidi13@gmail.com', 'ZOO ARCARDIA');
                $mail->addAddress($username); // Utilisez l'adresse email entrée par l'utilisateur

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation de création de compte';
                $mail->Body    = "Bonjour, nous vous prions de vous rapprocher de l'administrateur afin de recevoir vos identifiants de connexion au site internet. Merci.";
                $mail->AltBody = "Bonjour, nous vous prions de vous rapprocher de l'administrateur afin de recevoir vos identifiants de connexion au site internet. Merci.";

                $mail->send();
                echo '<div class="alert alert-success">Nouvel utilisateur inséré et email envoyé.</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-warning">Nouvel utilisateur inséré mais l\'email n\'a pas pu être envoyé. Erreur: ' . $mail->ErrorInfo . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Erreur: ' . $stmt->errorInfo()[2] . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Register</h2>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="veterinaire">Vétérinaire</option>
                    <option value="employe">Employé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
