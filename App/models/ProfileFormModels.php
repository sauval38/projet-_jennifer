<?php

namespace Models;

use App\Database;
use PDO;

class ProfileFormModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    } 

    public function updateProfile($user_id, $username, $lastname, $firstname, $email, $phone_number) {
        // Mettre à jour les données de l'utilisateur
        $stmt = $this->db->prepare("UPDATE users SET username = :username, lastname = :lastname, firstname = :firstname, email = :email, phone_number = :phone_number WHERE id = :user_id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute(); // Retourne vrai en cas de succès
    }
}