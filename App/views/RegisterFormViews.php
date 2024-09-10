<?php

namespace Views;

class RegisterFormViews {
    public function formRegisterViews() {
        ?>
            <form class="form" method="POST" action="login">
                <h2>S'inscrire</h2> 
                <input type="hidden" name="form_type" value="register">
                <label for="username">Nom d'utilisateur:</label>
                <input type="username" id="username-register" name="username-register" required>
                <label for="email">Email:</label>
                <input type="email" id="email-register" name="email-register" required>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password-register" name="password-register" required>
                <button type="submit">Inscription</button>
            </form>
        </div>
        <?php
        
    }
}

?>
