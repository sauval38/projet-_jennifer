<?php

namespace AdminControllers;

use AdminModels\AdminAboutMeModels;
use AdminViews\AdminAboutMeViews;

class AdminAboutMeControllers {
    protected $adminAboutMeViews;
    protected $adminAboutMeModels;

    public function __construct() {
        $this->adminAboutMeViews = new AdminAboutMeViews();
        $this->adminAboutMeModels = new AdminAboutMeModels();
    }

    public function showAboutMe() {
        $aboutMes = $this->adminAboutMeModels->fetchAboutMeData(); 
        if (!empty($aboutMes)) {
            $aboutMeData = $aboutMes[0]; 
        } else {
            $aboutMeData = ['id' => '', 'bio' => '', 'image_path' => '']; 
        }
        $this->adminAboutMeViews->displayAdminAboutMe($aboutMeData); 
    }

    public function updateAboutMe() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bio = $_POST['bio'];
            $id = $_POST['id']; 
            $imagePath = null;

            $existingData = $this->adminAboutMeModels->fetchAboutMeDataById($id);
            $oldImagePath = $existingData['image_path'];

            if (!empty($_FILES['image_path']['name'])) {
                $targetDir = "assets/images/aboutMe/"; 
                $imagePath = $targetDir . basename($_FILES["image_path"]["name"]);
                
                if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath)) {
                    if (!empty($oldImagePath) && file_exists($oldImagePath)) {
                        unlink($oldImagePath); 
                    }
                } else {
                    $_SESSION['message'] = 'Erreur lors du téléchargement de l\'image.';
                    header("Location: aboutMe");
                    exit;
                }
            } else {
                $imagePath = $oldImagePath;
            }

            if ($this->adminAboutMeModels->updateAboutMe($id, $bio, $imagePath)) {
                $_SESSION['message'] = 'Mise à jour réussie!';
            } else {
                $_SESSION['message'] = 'Erreur lors de la mise à jour!';
            }
            
            header("Location: aboutMe");
            exit;
        }
    }
}

