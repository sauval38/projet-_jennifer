<?php

namespace AdminControllers;

use Exception;
use AdminModels\AdminHomeModels;
use AdminViews\AdminHomeFormViews;
use AdminModels\AdminHomeFormModels;

class AdminHomeFormControllers {
    protected $adminHomeFormViews;
    protected $adminHomeFormModels;
    protected $adminHomeModels;

    public function __construct() {
        $this->adminHomeFormViews = new AdminHomeFormViews();
        $this->adminHomeModels = new AdminHomeModels();
        $this->adminHomeFormModels = new AdminHomeFormModels();
    }

    public function homeFormAdminControllers() {
        if (isset($_POST['id'])) {
            $imageId = $_POST['id'];
            $image = $this->adminHomeModels->getImageById($imageId);
            $this->adminHomeFormViews->homeFormAdminViews($image);
        } else {
            header("Location: /admin/home");
            exit();
        }
    }

    public function uploadImage() {
        if (isset($_POST['id']) && isset($_FILES['image'])) { // Vérifiez que le nom correspond
            $imageId = $_POST['id'];
    
            try {
                // Appelle la méthode uploadImage pour gérer le téléchargement
                $image_path = $this->adminHomeFormModels->uploadImage($_FILES['image']); // Vérifiez que c'est 'image' ici
                $this->adminHomeFormModels->updateImage($image_path, $imageId);
                echo '<h1>Image modifiée avec succès</h1>';
                exit();
            } catch (Exception $e) {
                // Gérer les erreurs
                echo '<h1>Image déja exisante</h1>';
                exit();
            }
        } else {
            header("Location: /admin/home");
            exit();
        }
    }
}    
