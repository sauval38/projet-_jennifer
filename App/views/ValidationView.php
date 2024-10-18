<?php
namespace Views;

class ValidationView {
    // Méthode pour afficher le formulaire de validation de commande
    public function initForm() {
        // Formulaire de validation de commande
        echo '<form method="POST" action="commande/validation">';
        echo '<h1>Validation de la commande ?</h1>';
        echo '<button>Valider</button>';
        echo '</form>';
    }
}
?>