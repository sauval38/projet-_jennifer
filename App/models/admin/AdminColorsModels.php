<?php

namespace AdminModels;

use PDO;
use App\Database;

class AdminColorsModels {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); 
    }

    public function adminColorsControllers() {
        $sqlColors = "SELECT * FROM colors";
        $colors = $this->db->prepare($sqlColors);
        $colors->execute();
        return $colors->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteColor($id) {
        $sqlDelete = "DELETE FROM colors WHERE id = :id";
        $stmt = $this->db->prepare($sqlDelete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute(); // Retourne vrai en cas de succès
    }
}