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
        $archived = $_POST['archived'] ?? '';

        // Gestion du téléchargement de l'image
        if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['image_path']['name']);
            $targetDir = "assets/images/gammes/";
            $targetFilePath = $targetDir . $imageName;

            // Supprime l'ancienne image seulement si une nouvelle est téléchargée
            $currentImage = $_POST['current_image'] ?? '';
            if ($currentImage && file_exists($currentImage)) {
                unlink($currentImage);
            }

            // Déplace l'image téléchargée vers le répertoire cible
            if (move_uploaded_file($_FILES['image_path']['tmp_name'], $targetFilePath)) {
                $image_path = $targetFilePath;
            } else {
                $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
                header('Location: ../gammes');
                exit;
            }
        } else {
            // Si aucune nouvelle image n'est téléchargée, conserver l'ancienne
            $image_path = $_POST['current_image'] ?? '';
        }

        if ($id) {
            $this->gammesModels->updateGamme($id, $name, $description, $image_path, $archived);
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
        $gamme = $this->gammesModels->getGammeById($id);

        if ($gamme) {
            // $image_path = $gamme['image_path'];

            // Supprime l'image associée si elle existe
            // if ($image_path && file_exists($image_path)) {
            //     unlink($image_path);
            // }

            $this->gammesModels->deleteGamme($id);
            $_SESSION['message'] = "Gamme supprimée avec succès!";
        } else {
            $_SESSION['message'] = "Gamme non trouvée.";
        }

        header('Location: ../../gammes');
        exit;
    }
}
