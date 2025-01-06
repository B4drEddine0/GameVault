<?php
session_start();
require_once 'GameClass.php';

if (isset($_POST['ajoute'])) {
        $game = new Game();
        
        $game->getAdmId();
        $game->setAdminId($_SESSION['admin_id']);
        $game->setTitle($_POST['title']);
        $game->setImage($_POST['image']);
        $game->setDescription($_POST['description']);
        $game->setType($_POST['type']);
        $game->setStatus('En Cours');
        $game->setDateSortie($_POST['date_sortie']);
        $game->setRating(0);
        $game->setNbUsers(0);
        $game->setTempsJeu(0);

        if($game->add()) {
            header('location: dashboard.php');
        }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['deletedId'];
    $game = new Game();
    if($game->deleteGame($id)) {
        header('location: dashboard.php');
    }
}


if(isset($_POST['update'])){
        $game = new Game();
        $game->setJeu_id($_POST['jeu_id']);
        $game->setTitle($_POST['title']);
        $game->setImage($_POST['image']);
        $game->setDescription($_POST['description']);
        $game->setType($_POST['type']);
        $game->setDateSortie($_POST['date_sortie']);
        $game->modifyGame();

}
?> 