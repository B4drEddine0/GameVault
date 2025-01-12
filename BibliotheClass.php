<?php
require_once 'connexion.php';

class Bibliotheque
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function GetBibliotheque($userId)
    {
        $query = "SELECT jeu.jeu_id, jeu.title, jeu.image, jeu.type, bibliotheque.temps_jeu, bibliotheque.status
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
        $stmt->bindParam(':jeu_id', $gameId, PDO::PARAM_INT); 
    
        if ($stmt->execute()) {
            header('Location: bibliotheque.php');
            exit;
        } else {
            echo "Erreur lors de la suppression du jeu.";
        }
    }

    public function addToCollection($users_id, $jeu_id) {
        try {
            $query = "INSERT INTO bibliotheque (users_id, jeu_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$users_id, $jeu_id]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception('Cet élément existe déjà dans votre collection.');
            }
            throw $e;
        }
    }

    public function addToCollectionWithDetails($users_id, $jeu_id, $playtime, $status) {
        try {
            $query = "INSERT INTO bibliotheque (users_id, jeu_id, temps_jeu, status) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$users_id, $jeu_id, $playtime, $status]);
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public function checkGameInBibliotheque($users_id, $jeu_id) {
        try {
            $query = "SELECT COUNT(*) FROM bibliotheque WHERE users_id = ? AND jeu_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$users_id, $jeu_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateGameDetails($gameId, $tempsJeu, $status) {
        try {
            $query = "UPDATE bibliotheque 
                      SET temps_jeu = :temps_jeu, status = :status 
                      WHERE jeu_id = :jeu_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':temps_jeu', $tempsJeu);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':jeu_id', $gameId);
            
            if ($stmt->execute()) {
                header('Location: bibliotheque.php');
                exit;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour: " . $e->getMessage();
        }
    }

}

?>