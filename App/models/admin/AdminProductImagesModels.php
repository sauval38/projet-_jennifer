<?php 

namespace AdminModels;

use App\Database;

class AdminProductImagesModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function saveImages($product_id, $images, $imageOptions = []) {
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $file_name = $images['name'][$key];
            $file_path = 'assets/images/products/' . $file_name;
    
            if (move_uploaded_file($tmp_name, $file_path)) {
                // Récupérer l'option associée à cette image (si elle existe)
                $product_option_id = $imageOptions[$key] ?? null;
    
                // Sauvegarder le chemin de l'image et l'option dans la base de données
                $query = "INSERT INTO product_images (product_id, image_path, product_option_id) 
                          VALUES (:product_id, :image_path, :product_option_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':image_path', $file_path);
    
                // Lier l'option associée (ou null s'il n'y en a pas)
                if ($product_option_id) {
                    $stmt->bindParam(':product_option_id', $product_option_id);
                } else {
                    $stmt->bindValue(':product_option_id', null);
                }
    
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
    
    public function updateImageOption($imageId, $optionId) {
        $query = "UPDATE product_images SET product_option_id = :product_option_id WHERE id = :image_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_option_id', $optionId, \PDO::PARAM_INT);
        $stmt->bindParam(':image_id', $imageId, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
