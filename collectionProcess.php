<?php
session_start();
require_once 'connexion.php';
require_once 'BibliotheClass.php';
require_once 'HistoriqueClass.php';
require_once 'classFavoris.php';

if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit;
}

try {
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();
    
    $bibliotheque = new Bibliotheque($conn);
    $historique = new Historique($conn);
    $favoris = new Favoris($conn);

    if (isset($_POST['confirmAddToCollection'])) {
        if ($bibliotheque->checkGameInBibliotheque($_SESSION['user_id'], $_SESSION['game_id'])) {
            header('Location: game_details.php?id=' . $_SESSION['game_id'] . '&error=already_in_collection');
            exit;
        }

        $playtime = $_POST['playtime'];
        $status = $_POST['status'];

        $bibliotheque->addToCollectionWithDetails(
            $_SESSION['user_id'],
            $_SESSION['game_id'],
            $playtime,
            $status
        );
        $historique->addToHistory($_SESSION['user_id'], $_SESSION['game_id']);

        header('Location: game_details.php?id=' . $_SESSION['game_id'] . '&success=added_details');
    }

    if (isset($_POST['delete_game']) && isset($_POST['game_id'])) {
        $gameIdToDelete = $_POST['game_id'];
        $bibliotheque->deleteGameFromLibrary($gameIdToDelete);
        header('Location: bibliotheque.php?success=deleted');
        exit;
    }

    if (isset($_POST['favorite_game']) && isset($_POST['game_id'])) {
        $gameIdToAddFavoris = $_POST['game_id'];
        $favoris->AddtoFavoris($gameIdToAddFavoris);
        header('Location: bibliotheque.php?success=added_to_favorites');
        exit;
    }

    if (isset($_POST['update_game']) && isset($_POST['game_id'])) {
        $gameId = $_POST['game_id'];
        $tempsJeu = $_POST['temps_jeu'];
        $status = $_POST['status'];
        $bibliotheque->updateGameDetails($gameId, $tempsJeu, $status);
        header('Location: bibliotheque.php?success=updated');
        exit;
    }

} catch (Exception $e) {
    header('Location: bibliotheque.php?error=' . urlencode($e->getMessage()));
    exit;
}