<?php
require_once "connextion.php";

Class Game{
    private $db;
    private $jeu_id;
    private $admin_id;
    private $title;
    private $description;
    private $type;
    private $nb_users;
    private $rating;
    private $status;
    private $temps_jeu;
    private $date_sortie;
    private $create_at;

    public function __construct($db) {
        $database = new DbConnection;
        $this->db = $database->getConnection();
    }

    public function getId() { return $this->jeu_id; }
    public function getAdminId() { return $this->admin_id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getType() { return $this->type; }
    public function getNbUsers() { return $this->nb_users; }
    public function getRating() { return $this->rating; }
    public function getStatus() { return $this->status; }
    public function getTempsJeu() { return $this->temps_jeu; }
    public function getDateSortie() { return $this->date_sortie; }
    public function getCreateAt() { return $this->create_at; }


    public function setAdminId($admin_id) { $this->admin_id = $admin_id; }
    public function setTitle($title) { $this->title = $title; }
    public function setDescription($description) { $this->description = $description; }
    public function setType($type) { $this->type = $type; }
    public function setNbUsers($nb_users) { $this->nb_users = $nb_users; }
    public function setRating($rating) { $this->rating = $rating; }
    public function setStatus($status) { $this->status = $status; }
    public function setTempsJeu($temps_jeu) { $this->temps_jeu = $temps_jeu; }
    public function setDateSortie($date_sortie) { $this->date_sortie = $date_sortie; }


    public function add() {
            $query = "INSERT INTO jeu (admin_id, title, description, type, nb_users, rating, status, temps_jeu, date_sortie) 
                     VALUES (:admin_id, :title, :description, :type, :nb_users, :rating, :status, :temps_jeu, :date_sortie)";
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(':admin_id', $this->admin_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':nb_users', $this->nb_users);
            $stmt->bindParam(':rating', $this->rating);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':temps_jeu', $this->temps_jeu);
            $stmt->bindParam(':date_sortie', $this->date_sortie);

            if($stmt->execute()) {
                $this->jeu_id = $this->db->lastInsertId();
                return true;
            }
            return false;
    }


    public function getAllGames() {
        try {
            $query = "SELECT * FROM jeu ORDER BY create_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Erreur de listage : " . $e->getMessage();
            return false;
        }
    }
}
?>