<?php

class Historique
{
    private $historique_id;
    private $users_id;
    private $jeu_id;
    private $add_at;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Setters
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

    // Getters
    public function getHistoriqueId()
    {
        return $this->historique_id;
    }

    public function getUsersId()
    {
        return $this->users_id;
    }

    public function getJeuId()
    {
        return $this->jeu_id;
    }

    public function getAddAt()
    {
        return $this->add_at;
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
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un historique
    public function DeleteHistory($userId){
        $query = "
        DELETE FROM historique WHERE users_id=?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
