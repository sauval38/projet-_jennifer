<?php 

namespace AdminModels;

use App\Database;

class AdminProductImagesModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function saveImages($product_id, $images) {
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $file_name = $images['name'][$key];
            $file_path = 'assets/images/products/' . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                // Sauvegarder le chemin de l'image dans la base de données
                $query = "INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':image_path', $file_path);
                $stmt->execute();
            }
        }
    }

    public function getImagesByProductId($product_id) {
        $query = "SELECT * FROM product_images WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function deleteImagesByProductId($product_id) {
        $query = "DELETE FROM product_images WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getImageById($imageId) {
        $query = "SELECT * FROM product_images WHERE id = :image_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':image_id', $imageId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteImageById($imageId) {
        $query = "DELETE FROM product_images WHERE id = :image_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':image_id', $imageId, \PDO::PARAM_INT);
        $stmt->execute();
    }
    
    
}
