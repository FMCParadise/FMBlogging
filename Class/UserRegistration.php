<?php
// Ce fichier enregistre un utilisateur sur la base de données

// On se connecte à la base de données
require 'includes/connection.php';

//Ces lignes déclarent une classe UserRegistration qui gère l'inscription d'un utilisateur. Elle a des propriétés privées 
//($lastname, $firstname, $email, $password, $gpdr, $db) qui stockent les informations de 
//l'utilisateur et la connexion à la base de données.

class UserRegistration {
    private $lastname;
    private $firstname;
    private $email;
    private $password;
    private $gpdr;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
}