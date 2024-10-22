<?php

namespace AdminModels;

use Exception;
use App\Database;

class AdminHomeFormModels {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); 
    }

    // Méthode pour récupérer l'image actuelle
    public function getCurrentImage($id) {
        $sql = "SELECT image_path FROM home WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchColumn(); // Retourne le chemin de l'image actuelle
    }

    // Méthode pour mettre à jour l'image avec suppression de l'ancienne
    public function updateImage($image_path, $id) {
        // Récupérer l'image actuelle
        $currentImage = $this->getCurrentImage($id);

        // Supprimer l'image actuelle si elle existe
        if ($currentImage && file_exists($currentImage)) {
            unlink($currentImage); // Supprime l'image
        }

        // Mettre à jour la base de données avec la nouvelle image
        $sqlImage = "UPDATE home SET image_path = :image_path WHERE id = :id";
        $update = $this->db->prepare($sqlImage);
        $update->bindParam(':image_path', $image_path);
        $update->bindParam(':id', $id);
        return $update->execute();
    }

    public function uploadImage($file) {
        // Vérifiez si le fichier est une image
        $target_dir = "assets/images/home/"; 
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérification des erreurs
        if ($file["error"] != 0) {
            throw new Exception("Erreur lors du téléchargement du fichier.");
        }

        // Vérification du type d'image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("Le fichier n'est pas une image.");
        }

        // Vérifiez si le fichier existe déjà
        if (file_exists($target_file)) {
            throw new Exception("Désolé, ce fichier existe déjà.");
        }

        // Déplacez le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file; // Retourne le chemin de l'image uploadée
        } else {
            throw new Exception("Désolé, il y a eu une erreur lors du téléchargement de votre fichier.");
        }
    }
}
