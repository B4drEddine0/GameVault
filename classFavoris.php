<?php
require_once 'connexion.php';

class Favoris
{

    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function GetFavoris($userId)
    {
        $query = "SELECT *
                  FROM favoris
                  JOIN jeu ON favoris.jeu_id = jeu.jeu_id
                  WHERE favoris.users_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AddtoFavoris($gameId)
    {
        // Vérifier si le jeu existe déjà dans les favoris
        $queryCheck = "SELECT * FROM favoris WHERE users_id = :users_id AND jeu_id = :jeu_id";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':users_id', $_SESSION['user_id']);
        $stmtCheck->bindParam(':jeu_id', $gameId);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            echo "<script>alert('Le jeu existe déjà dans vos favoris !');</script>";
            return false;
        }

        // Ajouter le jeu aux favoris si pas de doublon
        $query = "INSERT INTO favoris (users_id, jeu_id) VALUES (:users_id, :jeu_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id', $_SESSION['user_id']);
        $stmt->bindParam(':jeu_id', $gameId);

        if ($stmt->execute()) {
            echo "<script>alert('Jeu ajouté à vos favoris avec succès !');</script>";
            header('Location: favoris.php');
            exit;
        } else {
            echo "Erreur lors de l'ajout du jeu.";
        }
    }

    public function deleteGameFromFavoris($gameId)
    {
        $query = "DELETE FROM favoris WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jeu_id', $gameId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Jeu supprimé de vos favoris avec succès !');</script>";
            header('Location: favoris.php');
            exit;
        } else {
            echo "Erreur lors de la suppression du jeu.";
        }
    }
}
