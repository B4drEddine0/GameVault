<?php

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;

    // Constructeur pour initialiser les propriétés de l'utilisateur
    public function __construct($id = null, $username = null, $email = null, $password = null, $role = 'joueur') {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    // Getters et Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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
}
