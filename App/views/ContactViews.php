<?php

namespace Views;

class ContactViews {
    public function contactViews() {
        ?>
        <h1>Contactez-moi</h1>
        <div id="form-contact">
            <form class="form" method="POST" action="contact">

                <h2>Pose-moi tes question ici</h2>

                <label for="text">Nom:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Objet:</label>
                <input type="text" id="subject" name="subject" required>  
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Envoyer</button>
        </div>        
        <?php
    }
}
   

