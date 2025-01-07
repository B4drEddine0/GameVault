<?php
require_once "connexion.php";
class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $image;
    private $db;

    // Constructeur pour initialiser les propriétés de l'utilisateur
    public function __construct($id = null, $username = null, $email = null, $password = null, $role = 'joueur', $image=null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->image = $image;

        $database = new DbConnection;
        $this->db = $database->getConnection();
    }

    // Getters et Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    // Méthode pour hacher le mot de passe
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Méthode pour vérifier le mot de passe
    public function verifyPassword($inputPassword) {
        return password_verify($inputPassword, $this->password);
    }


    public function getAllUsers() {
        $query = "SELECT * FROM users ORDER BY username DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBannedUsers() {
        $query = "SELECT * FROM users where statut = 'Suspended' ORDER BY username DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveUsers() {
        $query = "SELECT * FROM users where statut = 'Active' ORDER BY username DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSelectedUser() {
        $query = "SELECT users_id, username, email, user_password, role_user, image 
                  FROM users 
                  WHERE users_id = :users_id";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id', $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modifyUser() {
        $query = "UPDATE users SET username= :username,email= :email,
        user_password= :user_password,role_user= :role_user,image= :image WHERE users_id= :users_id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':user_password', $this->password);
        $stmt->bindParam(':role_user', $this->role);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':users_id', $this->id);

        if($stmt->execute()) {
            header('location: dashboard.php');
        }
        return false;
    }

    public function getProfile($id){
        $query = 'SELECT image FROM users where users_id = :users_id';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':users_id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkBann($id){
        $query = 'SELECT users_id FROM bannes where users_id =:users_id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id',$id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false;
        }
    }

    public function BannUser($id){
        $query = 'INSERT into bannes (users_id) values (:users_id)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id',$id);
        $stmt->execute();

        $query2 = 'UPDATE users SET statut= "Suspended" where users_id =:users_id ';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bindParam(':users_id',$id);
        $stmt2->execute();
        header('Location: dashboard.php');
        exit();
    }

    public function UnBannUser($id){
        $query = 'DELETE from bannes where users_id =:users_id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':users_id',$id);
        $stmt->execute();

        $query2 = 'UPDATE users SET statut= "Active" where users_id =:users_id ';
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bindParam(':users_id',$id);
        $stmt2->execute();
        header('Location: dashboard.php');
        exit();
    }

}
