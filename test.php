<?php
require_once 'connexion.php'; // Assurez-vous d'avoir la connexion à la base de données

// Connexion à la base de données
$dbConnection = (new DbConnection())->getConnection();

if ($dbConnection) {
    // Requête pour récupérer les informations de l'utilisateur
    $query = "SELECT username, email, image FROM users WHERE username = 'utilisateur' LIMIT 1";

    // Exécution de la requête
    $stmt = $dbConnection->query($query);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Affichage des informations de l'utilisateur
        echo "<h2>Nom d'utilisateur: " . htmlspecialchars($user['username']) . "</h2>";
        echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
        echo "<img src='" . htmlspecialchars($user['image']) . "' alt='Image de profil' width='150'>";
    } else {
        echo "Utilisateur non trouvé.";
    }
}
?>
