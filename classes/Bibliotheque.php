<?php
require_once __DIR__ . '/../config/connexion.php';

class Bibliotheque
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function GetBibliotheque($userId)
    {
        $query = "SELECT jeu.jeu_id, jeu.title, jeu.image, jeu.type
                  FROM bibliotheque
                  JOIN jeu ON bibliotheque.jeu_id = jeu.jeu_id
                  WHERE bibliotheque.users_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteGameFromLibrary($gameId)
    {
        $query = "DELETE FROM bibliotheque WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jeu_id', $gameId, PDO::PARAM_INT);  // Bind as integer
    
        if ($stmt->execute()) {
            header('Location: bibliotheque.php');
            exit;
        } else {
            echo "Erreur lors de la suppression du jeu.";
        }
    }






}

?>