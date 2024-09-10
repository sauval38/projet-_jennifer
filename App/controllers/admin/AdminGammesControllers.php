<?php

namespace AdminControllers;

use AdminModels\AdminGammesModels;
use AdminViews\AdminGammeFormViews;

class AdminGammesControllers {
    protected $gammesModels;
    protected $gammeFormViews;

    public function __construct() {
        $this->gammesModels = new AdminGammesModels();
        $this->gammeFormViews = new AdminGammeFormViews();
    }

    public function showForm($id = null) {
        if ($id) {
            $gamme = $this->gammesModels->getGammeById($id);
            if (!$gamme) {
                // Handle the case where the gamme is not found
                echo "Gamme non trouvée";
                return;
            }
        } else {
            $gamme = [
                'id' => '',
                'name' => '',
                'description' => '',
                'image_path' => ''
            ];
        }

        $this->gammeFormViews->displayForm($gamme);
    }

    public function handleFormSubmission() {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $image_path = $_POST['image_path'] ?? '';

        if ($id) {
            $this->gammesModels->updateGamme($id, $name, $description, $image_path);
            $_SESSION['message'] = "Gamme modifiée avec succès!";
            header('Location: ../../gammes');
        } else {
            $this->gammesModels->createGamme($name, $description, $image_path);
            $_SESSION['message'] = "Gamme créée avec succès!";
            header('Location: ../gammes');
        }
        exit;
    }

    public function deleteGamme($id) {
        $this->gammesModels->deleteGamme($id);
        $_SESSION['message'] = "Gamme supprimée avec succès!";
        header('Location: ../../gammes'); // Redirige vers la liste des gammes après la suppression
        exit;
    }
}
