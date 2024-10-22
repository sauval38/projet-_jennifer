<?php

namespace Models;

use App\Database;

class HomeModels {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Méthode pour récupérer les images du carrousel uniquement
    public function getCarouselImages() {
        $sqlHome = "SELECT * FROM home WHERE informations LIKE 'caroussel_%'"; // Récupère uniquement les images pour le carrousel
        $stmt = $this->db->prepare($sqlHome);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Retourne toutes les lignes sous forme de tableau associatif
    }

    // Méthode pour récupérer les images de présentation et gammes
    public function getPresentationAndGammesImages() {
        $sql = "SELECT * FROM home WHERE informations IN ('image_presentation', 'image_gamme')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Retourne les images sous forme de tableau associatif
    }
}