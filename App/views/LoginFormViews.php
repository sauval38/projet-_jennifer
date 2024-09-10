<?php

namespace Views;

class LoginFormViews {
    public function formloginViews() {
            ?>
             <div id="form-login-register">
            <form class="form" method="POST" action="login">
                <h2>Se connecter</h2> 
                <input type="hidden" name="form_type" value="login">

                <label for="text">Email / Nom d'utilisateur:</label>
                <input type="text" id="email-login" name="email-login" required>
                
                <label for="password">Mot de passe:</label>
                <input type="password" id="password-login" name="password-login" required>
                
                
                <a href="forgot-password" class="forgot-password">Mot de passe oublié ?</a>
                                
                <button type="submit">Connexion</button>
            </form>
            <?php
    }
}

?>
