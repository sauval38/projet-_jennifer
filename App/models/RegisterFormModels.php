<?php

namespace Models; 

use App\Database;

class RegisterFormModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createUserModels() {
        $username = $_POST['username-register'];
        $email = $_POST['email-register'];
        $password = password_hash($_POST['password-register'], PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(50));

        try {
            $sqlRegister = $this->db->prepare("INSERT INTO users (username,email,password, token) VALUES (?,?,?,?)");
            $sqlRegister->execute([$username, $email, $password, $token]);

            // Retourner le jeton pour l'envoi d'email
            return $token;

        } catch (\PDOException $e) {
            echo "<h3>Erreur lors de la création de l'utilisateur :</h3> " . $e->getMessage(); 
            return false;
        }
    }

    // Rechercher un utilisateur par le token
    public function getUserByToken($token) {
        $sqlToken = "SELECT * FROM users WHERE token = :token";
        $cnxToken = $this->db->prepare($sqlToken);
        $cnxToken->bindParam(':token', $token);
        $cnxToken->execute();
        return $cnxToken->fetch();
    }

    // Valider l'email d'un utilisateur
    public function verifyEmail($token) {
        $sql = "UPDATE users SET is_verified = 1, token = NULL WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
}
