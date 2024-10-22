<?php

namespace Views;

class ProfileViews {
    public function profileViews($user_data) {
        if ($user_data) {
            ?>
            <h1>Profil de l'utilisateur</h1>
            <div id="profil">
                <table>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <td><?php echo htmlspecialchars($user_data['username'] ?? 'Inconnu'); ?></td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td><?php echo htmlspecialchars($user_data['lastname'] ?? 'Inconnu'); ?></td>
                    </tr>
                    <tr>
                        <th>Prénom</th>
                        <td><?php echo htmlspecialchars($user_data['firstname'] ?? 'Inconnu'); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user_data['email'] ?? 'Inconnu'); ?></td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td><?php echo htmlspecialchars($user_data['phone_number'] ?? 'Inconnu'); ?></td>
                    </tr>
                </table>
            </div>
            <a href="update_profile" class="btn btn-primary">Modifier le profil</a>
            <?php
        } else {
            echo '<p>Aucun utilisateur trouvé.</p>'; // Message si aucun utilisateur n'est trouvé
        }
    }
}