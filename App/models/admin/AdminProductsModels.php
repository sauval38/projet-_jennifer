<?php

namespace AdminModels;

use App\Database;

class AdminProductsModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getProductsByRange($product_range_id = null) {
        $query = "SELECT p.*, g.name as gamme_name 
                  FROM products p
                  JOIN products_range g ON p.product_range_id = g.id";
        
        if ($product_range_id) {
            $query .= " WHERE p.product_range_id = :product_range_id";
        }

        $stmt = $this->db->prepare($query);
        
        if ($product_range_id) {
            $stmt->bindParam(':product_range_id', $product_range_id, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createProduct($product_range_id, $name, $description, $price, $stock, $height, $weight) {
        $query = "INSERT INTO products (product_range_id, name, description, price, stock, height, weight) 
                  VALUES (:product_range_id, :name, :description, :price, :stock, :height, :weight)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_range_id', $product_range_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':weight', $weight);
    
        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Retourne le dernier ID inséré
        }
        
        return false; // En cas d'erreur
    }
    

    public function updateProduct($id, $product_range_id, $name, $description, $price, $stock, $height, $weight, $archived) {
        $query = "UPDATE products 
                  SET product_range_id = :product_range_id, name = :name, description = :description, 
                      price = :price, stock = :stock, height = :height, weight = :weight, archived = :archived 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':product_range_id', $product_range_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':archived', $archived, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $query = "UPDATE products SET archived = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
