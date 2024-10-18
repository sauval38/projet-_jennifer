<?php
namespace Views; // Définition du namespace pour la classe PaymentView

class PaymentView {
    // Méthode pour initialiser le formulaire de choix du moyen de paiement
    public function initForm($paymentOptions) {
        // Affichage du titre du formulaire
        echo '<h1>Choix du moyen de paiement</h1>';
        // Début du formulaire avec la méthode POST et un identifiant unique
        echo '<form method="POST" id="paymentForm">';
        // Sélecteur pour choisir le moyen de paiement
        echo '<select name="payment_name" id="paymentOption">';
        // Boucle à travers les options de paiement pour les afficher dans le sélecteur
        foreach ($paymentOptions as $option) {
            echo '<option value="' . $option['id'] . '">' . $option['method_name'] . '</option>';
        }
        echo '</select>'; // Fin du sélecteur
        echo '<button type="submit">Valider</button>'; // Bouton de soumission du formulaire
        echo '</form>'; // Fin du formulaire
    }
}
?>