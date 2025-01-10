<?php
require_once __DIR__ . '/../config/connexion.php';

class Chat {
    private $db;

    public function __construct() {
        $database = new DbConnection;
        $this->db = $database->getConnection();
    }


    public function addChat($users_id,$content,$jeu_id){
        $query = 'insert into chat (users_id, content,jeu_id) values (:users_id, :content, :jeu_id) ';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('users_id',$users_id);
        $stmt->bindParam('content',$content);
        $stmt->bindParam('jeu_id',$jeu_id);
        $stmt->execute();
        return true;
    }

    public function getChat($jeu_id){
        $query = 'SELECT c.content, c.create_at, u.username, u.image FROM chat c join users u on c.users_id = u.users_id WHERE c.jeu_id = :jeu_id order by c.create_at Asc';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('jeu_id',$jeu_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}