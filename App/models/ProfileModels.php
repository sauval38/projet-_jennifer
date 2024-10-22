<?php

namespace Models;

use PDO;
use App\Database;

class ProfileModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function profilModels($user_id) {
        // Sélectionner uniquement les données de l'utilisateur connecté
        $stmt = $this->db->prepare("SELECT username, lastname, firstname, email, password, phone_number FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne (l'utilisateur connecté)
    }
}
