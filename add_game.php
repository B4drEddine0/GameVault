<?php
require_once 'GameVault/GameClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $game = new Game($pdo);
        
        $game->setAdminId($_SESSION['admin_id']); // Assurez-vous d'avoir l'ID admin en session
        $game->setTitle($_POST['title']);
        $game->setDescription($_POST['description']);
        $game->setType($_POST['type']);
        $game->setStatus($_POST['status']);
        $game->setDateSortie($_POST['date_sortie']);
        $game->setRating(0); // Valeur par défaut
        $game->setNbUsers(0); // Valeur par défaut
        $game->setTempsJeu(0); // Valeur par défaut

        if($game->add()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?> 