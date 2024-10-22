<?php

namespace Views;

class ProfileFormViews {
    public function profilFormViews($user_data) {
        ?>
        <h1>Modifier le profil</h1>
        <div id="form-profile">
            <form class="form" action="update_profile" method="post">
                
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" required>
                
                <label for="lastname">Nom:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user_data['lastname'] ?? ''); ?>" required>
                
                <label for="firstname">Prénom:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user_data['firstname'] ?? ''); ?>" required>
            
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                
                <label for="phone_number">Téléphone:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user_data['phone_number'] ?? ''); ?>" required>
            
                <button type="submit">Modifier</button>
            </form>
        </div>    
        <?php
    }
}