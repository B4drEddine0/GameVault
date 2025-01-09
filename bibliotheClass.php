<?php

class Bibliotheque
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function GetBibliotheque($userId)
    {
        $query = "SELECT jeu.title, jeu.image, jeu.type
                  FROM bibliotheque
                  JOIN jeu ON bibliotheque.jeu_id = jeu.jeu_id
                  WHERE bibliotheque.users_id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

