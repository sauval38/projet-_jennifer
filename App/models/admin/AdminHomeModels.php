<?php

namespace AdminModels;

use PDO;
use App\Database;

class AdminHomeModels {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); 
    }

    public function imagehomeModels() {
        $sqlImages = "SELECT * FROM home";
        $images = $this->db->prepare($sqlImages);
        $images->execute();
        return $images->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImageById($id) {
        $sql = "SELECT * FROM home WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
