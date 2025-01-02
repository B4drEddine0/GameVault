<?php
session_start();
require_once 'database.php';

class Users{

    private $db;
    private $username;
    private $email;

    public function __construct(){
        $database = new DbConnection();
        $this->db = $database->getConnection();
    }

    public function setUsername($username) {
        $this->username = htmlspecialchars(strip_tags($username));
    }

    public function setEmail($email) {
        $this->email = htmlspecialchars(strip_tags($email));
    }


    public function AddUser(){

        $query = 'SELECT * FROM user WHERE username = :username and email = :email';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $this->username;
            return true;
        } else {
            $query = 'INSERT INTO user (username, email) VALUES (:username, :email)';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                $lastId = $this->db->lastInsertId();
                $_SESSION['user_id'] = $lastId;
                $_SESSION['username'] = $this->username;
                return true;
            }
            return false;
        }
    }
    }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['name'];
    $email = $_POST['email'];

    $user = new Users();
    $user->setUsername($username);
    $user->setEmail($email);

    if($user->AddUser()){
        header('location: tasks.php');
    }else{
        echo 'erreur while register';
    }
}

?>