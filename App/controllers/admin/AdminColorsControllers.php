<?php

namespace AdminControllers;

use AdminModels\AdminColorsModels;
use AdminViews\AdminColorsViews;

class AdminColorsControllers {
    protected $adminColorsViews;
    protected $adminColorsModels;

    public function __construct() {
        $this->adminColorsViews = new AdminColorsViews();
        $this->adminColorsModels = new AdminColorsModels();
    }

    public function AdminColorsControllers() {
        // Vérifier si le formulaire de suppression a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_color'])) {
            $id = intval($_POST['color_id']);

            // Appeler le modèle pour supprimer la couleur
            $deleted = $this->adminColorsModels->deleteColor($id);

            if ($deleted) {
                echo "<h1>Couleur supprimée avec succès !</h1>";
                exit();
            } else {
                echo "<h1>Erreur lors de la suppression de la couleur.</h1>";
            }
        }

        // Récupérer les couleurs après l'action de suppression
        $colors = $this->adminColorsModels->adminColorsControllers();

        // Passer les données des couleurs à la vue
        $this->adminColorsViews->AdminColorsViews($colors);
    }
}