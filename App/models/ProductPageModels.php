<?php

namespace Models;

use App\Database;

class ProductPageModels {

    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Méthode pour récupérer un produit par ID
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les images et leurs options associées
    public function getImagesWithOptions($productId) {
        $query = "
            SELECT pi.id, pi.image_path, po.option_name, po.option_value, po.id as product_option_id
            FROM product_images pi
            LEFT JOIN product_option po ON pi.product_option_id = po.id
            WHERE pi.product_id = :productId AND po.option_name = 'couleur'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les options de produit, par exemple pour afficher les couleurs disponibles
    public function getProductOptions($productId) {
        $query = "
            SELECT po.id, po.option_name, po.option_value
            FROM product_option po
            WHERE po.product_id = :productId AND po.option_name = 'couleur'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Méthode pour traduire les couleurs
    public function translateColor($color) {
        // Dictionnaire de traduction des couleurs
        $translations = [
            'noir' => 'black',
            'rouge' => 'red',
            'rose' => 'pink',
            'blanc' => 'white',
            // Ajoute d'autres traductions si nécessaire
        ];

        return $translations[$color] ?? $color; // Retourne la couleur traduite ou la couleur originale si non trouvée
    }
}
