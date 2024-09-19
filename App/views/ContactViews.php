<?php

namespace Views;

class ContactViews {
    public function contactViews() {
        ?>
        <h1>Tu as des questions ? Contacte-moi</h1>
        <div id="form-contact">
            <form class="form" method="POST" action="contact">
                <h2>Pose-moi tes questions ici</h2>

                <label for="text">Nom:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Objet:</label>
                <input type="text" id="subject" name="subject" required>  
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Envoyer</button>
            </form>
        </div>  

        <div class="contact-info">
            <img src="./assets/images/contact.jpg" alt="contact" class="contact-image">
            <div class="contact-details">
                <h2>ICI, INFORMATIONS SUPPLÉMENTAIRES</h2>
                <p><strong>Adresse :</strong> 123 Rue de l'Exemple, 75000 Paris, France</p>
                <p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
                <p><strong>Email :</strong> contact@example.com</p>
            </div>
        </div> 

        <?php
    }
}
