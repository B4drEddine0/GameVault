<?php
require_once 'connexion.php';

class Historique
{
    private $db;
    private $historique_id;
    private $users_id;
    private $jeu_id;
    private $add_at;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setHistoriqueId($historique_id)
    {
        $this->historique_id = $historique_id;
    }

    public function setUsersId($users_id)
    {
        $this->users_id = $users_id;
    }

    public function setJeuId($jeu_id)
    {
        $this->jeu_id = $jeu_id;
    }

    public function setAddAt($add_at)
    {
        $this->add_at = $add_at;
    }


    public function GetHistorique($userId)
    {
        $query = "
        SELECT *
        FROM historique h
        INNER JOIN jeu j ON h.jeu_id = j.jeu_id
        WHERE h.users_id = ?
        ORDER BY h.add_at DESC
    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkExistingEntry($users_id, $jeu_id) {
        $checkQuery = "SELECT COUNT(*) FROM historique WHERE users_id = ? AND jeu_id = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([$users_id, $jeu_id]);
        return $checkStmt->fetchColumn() > 0;
    }

    public function addToHistory($users_id, $jeu_id) {
        try {
            if (!$this->checkExistingEntry($users_id, $jeu_id)) {
                $query = "INSERT INTO historique (users_id, jeu_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$users_id, $jeu_id]);
            }
            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
