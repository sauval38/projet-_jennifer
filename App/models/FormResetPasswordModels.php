<?php

namespace Models;

use App\Database;

class FormResetPasswordModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function validateToken($token) {
        // Vérifie si le token existe dans la base de données
        $sqlToken = "SELECT * FROM users WHERE token = ?";
        $cnxToken = $this->db->prepare($sqlToken);
        $cnxToken->execute([$token]);

        return $cnxToken->fetch();
    }

    public function updatePassword($newPassword, $token) {
        // Hacher le nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe de l'utilisateur
        $sqlUpdate = "UPDATE users SET password = ? WHERE token = ?";
        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $newPass = $stmtUpdate->execute([$hashedPassword, $token]);

        // Supprimer le token une fois le mot de passe mis à jour
        if ($newPass){
            $sqlDeleteToken = "UPDATE users SET token = NULL WHERE token = ?";
            $stmtDelete = $this->db->prepare($sqlDeleteToken);
            $stmtDelete->execute([$token]);
        return true;
        }
    }
}
