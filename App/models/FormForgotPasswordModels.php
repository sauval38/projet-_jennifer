<?php

namespace Models;

use App\Database;

class FormForgotPasswordModels {
    protected $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function emailByUser() {
        // Étape 1 : Sélectionner l'utilisateur par email ou nom d'utilisateur
        $sqlModifyPassword = "SELECT email FROM users WHERE username = ? OR email = ?";
        $inputUser = $_POST['email'];
        $modifyPassword = $this->db->prepare($sqlModifyPassword);
        $modifyPassword->execute([$inputUser, $inputUser]);
        
        $user = $modifyPassword->fetch();
        
        // Si l'utilisateur existe, créer un token et l'insérer dans la base de données
        if ($user) {
            // Étape 2 : Générer un token sécurisé (par exemple, avec openssl ou bin2hex)
            $token = bin2hex(random_bytes(50));
    
            // Étape 3 : Insertion du token dans la base de données
            $sqlInsertToken = "UPDATE users SET token = ? WHERE email = ?";
            $insertToken = $this->db->prepare($sqlInsertToken);
            $insertToken->execute([$token, $user['email']]);
    
            // Étape 4 : Retourner l'email et le token pour l'envoi de l'email
            return [
                'email' => $user['email'],
                'token' => $token
            ];
        } else {
            // Si l'utilisateur n'existe pas, renvoyer false ou gérer l'erreur
            return false;
        }
    }
    
}
