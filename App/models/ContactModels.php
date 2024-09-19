<?php

namespace Models;

use App\Database;

class ContactModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function sendMessageContact() {
        $sqlMessage = "INSERT INTO contact (lastname, email, subject, message) VALUES (:lastname, :email, :subject, :message)";
        $message = $this->db->prepare($sqlMessage);
    
        $name = $_POST['lastname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $messageContent = $_POST['message']; 
    
        $message->bindParam(':lastname', $name);
        $message->bindParam(':email', $email);
        $message->bindParam(':subject', $subject);
        $message->bindParam(':message', $messageContent);
    
        return $message->execute();
    }
}    
