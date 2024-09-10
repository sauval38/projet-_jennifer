<?php

namespace Models;

use App\Database;

class LoginFormModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate($email,$password) {
        $sqlLogin= $this->db->prepare("SELECT roles.name, users.* FROM users
        JOIN roles ON users.role_Id = roles.Id
        WHERE email = :email or username = :username");
        $sqlLogin->bindParam(':email',$email);
        $sqlLogin->bindParam(':username',$email);
        $sqlLogin->execute();
        $user = $sqlLogin->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['name'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_logged_in'] = true;
            return true;
        } else {
            return false;
        }
    }
}
