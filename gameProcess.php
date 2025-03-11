<?php
session_start();
require_once 'connexion.php';
require_once 'UserClass.php';
require_once 'GameClass.php';
require_once 'ChatClass.php';

if (isset($_POST['ajoute'])) {
        $game = new Game();
        
        $game->getAdmId();
        $game->setAdminId($_SESSION['admin_id']);
        $game->setTitle($_POST['title']);
        $game->setImage($_POST['image']);
        $game->setImage2($_POST['image2']);
        $game->setImage3($_POST['image3']);
        $game->setImage4($_POST['image4']);
        $game->setDescription($_POST['description']);
        $game->setType($_POST['type']);
        $game->setStatus('En Cours');
        $game->setDateSortie($_POST['date_sortie']);
        $game->setRating(0);
        $game->setNbUsers(0);
        $game->setTempsJeu(0);

        if($game->add()) {
            header('Location: dashboard.php');
        }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['deletedId'];
    $game = new Game();
    if($game->deleteGame($id)) {
        header('Location: dashboard.php');
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

if(isset($_POST['updateUser'])){
    $user = new User();
    $user->setId($_POST['users_id']);
    $user->setUsername($_POST['username']);
    $user->setImage($_POST['image']);
    $user->setPassword($_POST['user_password']);
    $user->setRole($_POST['role_user']);
    $user->setEmail($_POST['email']);
    $user->modifyUser();

}

if(isset($_GET['banne'])){
    $id = $_GET['banne'];
    $user = new User();
    if($user->checkBann($id)){
        $user->UnBannUser($id);
    }else{
        $user->BannUser($id);
    }
}

if(isset($_POST['SubReview'])){
    if (!isset($_SESSION['username'])) {
        header('Location: signin.php');
        exit;
    }
    $users_id = $_SESSION['user_id'];
    $jeu_id = $_POST['game_id'];
    $rating = $_POST['rating'];
    $content = $_POST['review'];
    $user = new User();
    if($user->checkBann($users_id)){
        header('Location: game_details.php?id=' . $jeu_id . '&statut=Bann');
    }else{
        $game = new Game();
        if($game->addNotation($users_id,$jeu_id,$rating,$content)){
        header('Location: game_details.php?id=' . $jeu_id);
        exit();
        }
    }
}

    if(isset($_POST['addMsg'])){
        if (!isset($_SESSION['username'])) {
            header('Location: signin.php');
            exit;
        }
        $users_id = $_SESSION['user_id'];
        $jeu_id = $_POST['jeuId'];
        $content = $_POST['message'];
        $user = new User();
        if($user->checkBann($users_id)){
            header('Location: game_details.php?id=' . $jeu_id . '&statut=Bann');
        }else{
        $chat = new Chat();
        if($chat->addChat($users_id,$content,$jeu_id)){
            header('Location: game_details.php?id=' . $jeu_id . '&mode=chat');
        }}
    }
?> 