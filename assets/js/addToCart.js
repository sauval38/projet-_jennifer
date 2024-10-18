// Attend que le DOM soit entièrement chargé
document.addEventListener('DOMContentLoaded', () => {
    let selectedOptionId = null; // Variable pour stocker le product_option_id sélectionné

    // Sélectionne tous les carrés de couleur
    const colorSquares = document.querySelectorAll('.color-square');
    
    // Ajoute un écouteur d'événement 'click' à chaque carré de couleur
    colorSquares.forEach(square => {
        square.addEventListener('click', (event) => {
            // Récupère l'ID de l'option sélectionnée (product_option_id)
            selectedOptionId = event.target.getAttribute('data-color-id');
            console.log('Selected Product Option ID:', selectedOptionId);
        });
    });

    // Sélectionne tous les boutons d'ajout au panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    // Ajoute un écouteur d'événement 'click' à chaque bouton
    addToCartButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            // Vérifie que l'utilisateur a bien sélectionné une couleur
            if (!selectedOptionId) {
                alert('Veuillez sélectionner une couleur avant d’ajouter au panier.');
                return;
            }

             // Récupère les informations du produit depuis la page
            const productInfoContainer = event.target.closest('.product-info');
            const product_id = productInfoContainer.querySelector('h1').getAttribute('data-product-id');
            const price = productInfoContainer.querySelector('p strong').nextSibling.textContent.trim().replace('€', '');
            const quantity = productInfoContainer.querySelector('.qte').value; // Récupère la quantité sélectionnée

            try {
                // Envoie une requête POST au serveur
                const response = await fetch('http://localhost/Projet-stage/projet-_jennifer/?action=addToCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Spécifie que les données envoyées sont au format JSON
                    },
                    body: JSON.stringify({
                        product_id: product_id,
                        quantity: quantity,
                        price: price,
                        product_option_id: selectedOptionId, // Ajoute le product_option_id sélectionné
                    }), // Convertit les données du formulaire en JSON
                });

                // Récupère la réponse du serveur sous forme de texte
                const text = await response.text();
                console.log("ajouté");

                // Ajouter votre logique pour gérer la réponse du serveur ici
            } catch (error) {
                console.error('Error:', error);
                // Ajouter votre logique pour gérer les erreurs ici
            }
        });
    });
});
