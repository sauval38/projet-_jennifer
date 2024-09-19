<?php

namespace Views;

class FormForgotPasswordViews {
    public function formForgotPasswordViews() {
            ?>
             <div id="form-forgot-password">
                <form class="form" method="POST" action="forgot-password">
                    <h2>Demande de mot de passe</h2> 

                    <p>Mot de passe perdu ? Veuillez saisir votre identifiant ou votre adresse e-mail. Vous recevrez un lien par e-mail pour créer un nouveau mot de passe.</p>

                    <label for="text">Email / Nom d'utilisateur:</label>
                    <input type="text" id="email" name="email" required>
                                    
                    <button type="submit">Envoyer la demande</button>
                </form>
            </div>
            <?php
    }
}

?>