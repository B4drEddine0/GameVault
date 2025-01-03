<?php
session_start();
require_once 'GameClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $game = new Game();
        
        $game->getAdmId();
        $game->setAdminId($_SESSION['admin_id']);
        $game->setTitle($_POST['title']);
        $game->setImage($_POST['image']);
        $game->setDescription($_POST['description']);
        $game->setType($_POST['type']);
        $game->setStatus($_POST['status']);
        $game->setDateSortie($_POST['date_sortie']);
        $game->setRating(0);
        $game->setNbUsers(0);
        $game->setTempsJeu($_POST['temps_jeu']);

        if($game->add()) {
            header('location: dashboard.php');
        }
}
?> 