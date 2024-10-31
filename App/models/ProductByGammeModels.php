<?php

namespace Models;

use App\Database;

class ProductByGammeModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductByGammes($id) {
        $queryGammes = "
            SELECT p.id, p.*, MIN(pi.image_path) AS image_path
            FROM products p
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.product_range_id = ? and p.archived = 0
            GROUP BY p.id
        ";
        $product = $this->db->prepare($queryGammes);
        $product->execute([$id]);
        return $product->fetchAll(\PDO::FETCH_ASSOC);
    }
}
