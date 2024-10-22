<?php

namespace Models;

use App\Database;

class AboutMeModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function aboutMeModels() {
        $sqlAboutme = "SELECT * FROM about_me";
        $aboutMe = $this->db->prepare($sqlAboutme);
        $aboutMe->execute();
        return $aboutMe->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function statsModels() {
        $sqlStats = "SELECT * FROM general_stats";
        $stats = $this->db->prepare($sqlStats);
        $stats->execute();
        return $stats->fetchAll(\PDO::FETCH_ASSOC);
    }
}