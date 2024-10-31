<?php 

namespace AdminModels;

use App\Database;

class AdminProductOptionsModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getColors() {
        $query = "SELECT * FROM colors";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductColors($product_id) {
        $query = "
            SELECT co.id AS color_id, co.name AS option_value
            FROM product_option po
            JOIN colors co ON po.option_value = co.name
            WHERE po.product_id = :product_id AND po.option_name = 'couleur'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function optionExists($product_id, $option_name, $option_value) {
        $query = "SELECT COUNT(*) FROM product_option 
                  WHERE product_id = :product_id AND option_name = :option_name AND option_value = :option_value";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->bindParam(':option_name', $option_name);
        $stmt->bindParam(':option_value', $option_value);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }    

    public function saveProductOptions($product_id, $option_name, $option_value) {
        if ($this->optionExists($product_id, $option_name, $option_value)) {
            // Si l'option existe, on fait une mise à jour
            $query = "UPDATE product_option SET option_value = :option_value 
                      WHERE product_id = :product_id AND option_name = :option_name";
        } else {
            // Sinon, on fait une insertion
            $query = "INSERT INTO product_option (product_id, option_name, option_value) 
                      VALUES (:product_id, :option_name, :option_value)";
        }
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':option_name', $option_name);
        $stmt->bindParam(':option_value', $option_value);
        $stmt->execute();
    }
    

    public function getOptionsByProductId($product_id) {
        $query = "SELECT * FROM product_option WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteOptionsByProductId($product_id) {
        $query = "DELETE FROM product_option WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getProductOptionId($productId, $colorId) {
        $query = "SELECT id FROM product_option WHERE product_id = :product_id AND option_value = (SELECT name FROM colors WHERE id = :color_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->bindParam(':color_id', $colorId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function getColorByOptionId($optionId) {
        $query = "SELECT c.id, c.name FROM product_option po
                  JOIN colors c ON po.option_value = c.name
                  WHERE po.id = :optionId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':optionId', $optionId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
}
