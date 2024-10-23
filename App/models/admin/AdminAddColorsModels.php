<?php

namespace AdminModels;

use App\Database;

class AdminAddColorsModels {
    protected $db;

    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        } 

    public function addColors() {
        $sqlAddColors = "INSERT INTO colors (name) VALUES (:name)";
        $addColors = $this->db->prepare($sqlAddColors);
        $addColors->bindParam(':name', $name);
        return $addColors->execute();
        }     
    }