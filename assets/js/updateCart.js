// Attend que le DOM soit entièrement chargé
document.addEventListener('DOMContentLoaded', () => {
    // Sélectionne tous les boutons de changement de quantité et de retrait du panier
    const changeQuantityButtons = document.querySelectorAll('.change-qte');
    const removeFromCartButtons = document.querySelectorAll('.remove-from-cart');

    // Fonction pour envoyer une requête au serveur afin d'ajuster la quantité
    const adjustQuantity = async (event) => {
        // Trouve le formulaire parent le plus proche du bouton cliqué
        const form = event.target.closest('.product-form');
        // Récupère les valeurs des champs du formulaire
        const product_id = form.querySelector('.product_id').value;
        const cart_id = form.querySelector('.cart_id').value;
        const cart_detail_id = form.querySelector('.cart_detail_id').value;
        const quantity = form.querySelector('.qte').value;

        try {
            // Envoie une requête POST au serveur
            const response = await fetch('http://localhost/projet-_jennifer/?action=adjustQuantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Spécifie que les données envoyées sont au format JSON
                },
                body: JSON.stringify({
                    product_id: product_id,
                    cart_detail_id: cart_detail_id,
                    quantity: quantity,
                    cart_id: cart_id
                }), // Convertit les données du formulaire en JSON
            });

            // Récupère la réponse du serveur sous forme de texte
            const text = await response.text();
            console.log('Response Text:', text);

            // Parse le texte en JSON
            const data = JSON.parse(text);
            console.log('Success:', data);

            // Ajouter votre logique pour gérer la réponse du serveur ici
        } catch (error) {
            console.error('Error:', error);
            // Ajouter votre logique pour gérer les erreurs ici
        }
    };

    // Fonction pour envoyer une requête au serveur afin de retirer un article du panier
    const removeFromCart = async (event) => {
        // Trouve le formulaire parent le plus proche du bouton cliqué
        const form = event.target.closest('.product-form');
        // Récupère les valeurs des champs du formulaire
        const product_id = form.querySelector('.product_id').value;
        const cart_id = form.querySelector('.cart_id').value;
        const cart_detail_id = form.querySelector('.cart_detail_id').value;

        try {
            // Envoie une requête POST au serveur
            const response = await fetch('http://localhost/projet-_jennifer/?action=removeFromCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Spécifie que les données envoyées sont au format JSON
                },
                body: JSON.stringify({
                    cart_detail_id: cart_detail_id,
                    product_id: product_id,
                    cart_id: cart_id
                }), // Convertit les données du formulaire en JSON
            });

            // Récupère la réponse du serveur sous forme de texte
            const text = await response.text();
            console.log('Response Text:', text);

            // Parse le texte en JSON
            const data = JSON.parse(text);
            console.log('Success:', data);

            // Ajouter votre logique pour gérer la réponse du serveur ici
        } catch (error) {
            console.error('Error:', error);
            // Ajouter votre logique pour gérer les erreurs ici
        }
    };

    // Ajoute des écouteurs d'événements pour les boutons de changement de quantité
    changeQuantityButtons.forEach(button => {
        button.addEventListener('click', adjustQuantity);
    });

    // Ajoute des écouteurs d'événements pour les boutons de retrait du panier
    removeFromCartButtons.forEach(button => {
        button.addEventListener('click', removeFromCart);
    });
});