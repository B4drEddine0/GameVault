<?php
require_once "connexion.php";

Class Game{
    private $db;
    private $jeu_id;
    private $admin_id;
    private $title;
    private $image;
    private $image2;
    private $image3;
    private $image4;
    private $description;
    private $type;
    private $nb_users;
    private $rating;
    private $status;
    private $temps_jeu;
    private $date_sortie;
    private $create_at;

    public function __construct() {
        $database = new DbConnection;
        $this->db = $database->getConnection();
    }

    public function getId() { return $this->jeu_id; }
    public function getAdminId() { return $this->admin_id; }
    public function getTitle() { return $this->title; }
    public function getImage() { return $this->image; }
    public function getDescription() { return $this->description; }
    public function getType() { return $this->type; }
    public function getNbUsers() { return $this->nb_users; }
    public function getRating() { return $this->rating; }
    public function getStatus() { return $this->status; }
    public function getTempsJeu() { return $this->temps_jeu; }
    public function getDateSortie() { return $this->date_sortie; }
    public function getCreateAt() { return $this->create_at; }


    public function setJeu_id($jeu_id) { $this->jeu_id = $jeu_id; }
    public function setAdminId($admin_id) { $this->admin_id = $admin_id; }
    public function setTitle($title) { $this->title = $title; }
    public function setImage($image) { $this->image = $image; }
    public function setImage2($image2) { $this->image2 = $image2; }
    public function setImage3($image3) { $this->image3 = $image3; }
    public function setImage4($image4) { $this->image4 = $image4; }
    public function setDescription($description) { $this->description = $description; }
    public function setType($type) { $this->type = $type; }
    public function setNbUsers($nb_users) { $this->nb_users = $nb_users; }
    public function setRating($rating) { $this->rating = $rating; }
    public function setStatus($status) { $this->status = $status; }
    public function setTempsJeu($temps_jeu) { $this->temps_jeu = $temps_jeu; }
    public function setDateSortie($date_sortie) { $this->date_sortie = $date_sortie; }

    public function getAdmId(){
        $query='SELECT admin_id FROM admins join users on admins.users_id = users.users_id where users.username = :user';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user', $_SESSION['username']);

        if ($stmt->execute()) {
            $_SESSION['admin_id'] = $stmt->fetchColumn();
        }
    }

    public function add() {
            $query = "INSERT INTO jeu (admin_id, title, description, type, nb_users, rating, status, temps_jeu, date_sortie,image,image2,image3,image4) 
                     VALUES (:admin_id, :title, :description, :type, :nb_users, :rating, :status, :temps_jeu, :date_sortie, :image, :image2, :image3, :image4)";
            
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
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':image2', $this->image2);
            $stmt->bindParam(':image3', $this->image3);
            $stmt->bindParam(':image4', $this->image4);

            if($stmt->execute()) {
                $this->jeu_id = $this->db->lastInsertId();
                return true;
            }
            return false;
    }


    public function getAllGames() {
            $query = "SELECT * FROM jeu ORDER BY create_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSelectedGame() {
        $query = "SELECT jeu_id, title, description, image,image2,image3,image4, type, rating, date_sortie, nb_users, temps_jeu, status 
                  FROM jeu 
                  WHERE jeu_id = :jeu_id";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jeu_id', $this->jeu_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modifyGame() {
        $query = "UPDATE jeu SET title= :title,description= :description,
        type= :type,date_sortie= :date_sortie,image= :image WHERE jeu_id= :jeu_id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':date_sortie', $this->date_sortie);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':jeu_id', $this->jeu_id);

        if($stmt->execute()) {
            header('location: dashboard.php');
        }
        return false;
}

    public function deleteGame($jeu_id) {
        $query = "DELETE FROM jeu WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jeu_id', $jeu_id);
        $stmt->execute();
        header('location: dashboard.php');
    }

    public function getCollectionCount() {
        $query = "SELECT COUNT(*) as count FROM bibliotheque WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['jeu_id' => $this->jeu_id]);
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function addView(){
        $query = "UPDATE jeu SET vues = vues+1 WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['jeu_id' => $this->jeu_id]);
    }
    public function getViewCount() {
        $query = "SELECT vues as count FROM jeu WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['jeu_id' => $this->jeu_id]);
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function getCommentCount() {
        $query = "SELECT COUNT(*) as count FROM notation WHERE jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['jeu_id' => $this->jeu_id]);
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function addNotation($users_id,$jeu_id,$rating,$content) {
        $query = "SELECT users_id, jeu_id, rating, content FROM notation where jeu_id = :jeu_id AND users_id = :users_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id', $users_id);
        $stmt->bindParam(':jeu_id', $jeu_id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $query = "UPDATE notation SET rating=:rating, content=:content,create_at= NOW() where jeu_id = :jeu_id AND users_id = :users_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':users_id', $users_id);
            $stmt->bindParam(':jeu_id', $jeu_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':content', $content);
            if($stmt->execute()){
                return true; 
                }   
        }else{
            $query = "INSERT INTO notation (users_id, jeu_id, rating, content) VALUES 
                (:users_id, :jeu_id, :rating, :content)";
        
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(':users_id', $users_id);
            $stmt->bindParam(':jeu_id', $jeu_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':content', $content);
            if($stmt->execute()){
            return true; 
            }   
        }
    }

    public function getNotation($jeu_id) {
        $query = "SELECT u.users_id, n.jeu_id, n.rating, n.content, u.username, u.image, n.create_at
        FROM notation n JOIN users u ON n.users_id = u.users_id WHERE n.jeu_id = :jeu_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jeu_id', $jeu_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function avgRate($jeu_id){
        $query = 'SELECT AVG(rating) as total_rate FROM notation WHERE jeu_id = :jeu_id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('jeu_id',$jeu_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($result['total_rate']) ? $result['total_rate'] : 0;
    }
}
?>