document.addEventListener('DOMContentLoaded', () => {
    const quantitySelects = document.querySelectorAll('.quantity-select');

    // Mise à jour de la quantité via le select
    quantitySelects.forEach(select => {
        select.addEventListener('change', function() {
            const cartDetailId = this.dataset.cartDetailId;
            const quantity = this.value;

            fetch('http://localhost/projet-_jennifer/?action=update-quantity', {  // URL correcte
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cartDetailId, quantity })
            })
            .then(data => {
                if (data.success) {
                    console.log('Quantity updated');
                } else {
                    console.log('Quantity updated');
                }
            });
        });
    });

    const removeButtons = document.querySelectorAll('.remove-item');

    // Suppression d'un article
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartDetailId = this.dataset.cartDetailId;

            fetch('http://localhost/projet-_jennifer/?action=remove-item', {  // URL correcte
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cartDetailId })
            })
            .then(data => {
                if (data.success) {
                    console.log('Item removed');
                    this.closest('.cart-item').remove();
                } else {
                    console.log('Item removed');
                    this.closest('.cart-item').remove();
                }
            });
        });
    });
});
