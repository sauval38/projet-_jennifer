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
        $queryGammes = "SELECT * FROM products WHERE product_range_id = ?";
        $product = $this->db->prepare($queryGammes);
        $product->execute([$id]);
        return $product->fetchAll(\PDO::FETCH_ASSOC);
    }
}