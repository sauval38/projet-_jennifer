<?php

namespace Views;

class FormResetPasswordViews {
    public function showResetPasswordForm($token) {
        ?>
        <h2>Réinitialiser votre mot de passe</h2>

        <form method="POST" action="?action=password">

            <input type="hidden" name="token" value="<?= $token ?>">
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirmez le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <button type="submit">Réinitialiser le mot de passe</button>

        </form>
        
        <?php
    }
}
