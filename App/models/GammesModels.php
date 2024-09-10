<?php

namespace Models;

use App\Database;

class GammesModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getGammes() {
        $queryGammes = "SELECT * FROM products_range";
        $gammes = $this->db->prepare($queryGammes);
        $gammes->execute();
        return $gammes->fetchAll(\PDO::FETCH_ASSOC);
    }
}