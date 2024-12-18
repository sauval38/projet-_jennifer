<?php

namespace AdminModels;

use App\Database;

class AdminGammesModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllGammes() {
        $query = "SELECT * FROM products_range";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getGammeById($id) {
        $query = "SELECT * FROM products_range WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createGamme($name, $description, $image_path) {
        $query = "INSERT INTO products_range (name, description, image_path) VALUES (:name, :description, :image_path)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_path', $image_path);
        return $stmt->execute();
    }

    public function updateGamme($id, $name, $description, $image_path, $archived) {
        $query = "UPDATE products_range SET name = :name, description = :description, image_path = :image_path, archived = :archived WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':archived', $archived, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteGamme($id) {
        $query = "UPDATE products_range SET archived = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
