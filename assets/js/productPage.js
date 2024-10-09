document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.carousel-wrapper');
    const slides = document.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;
    let currentIndex = 0;

    // Fonction pour afficher une diapositive spécifique
    function showSlide(index) {
        if (index >= totalSlides) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalSlides - 1;
        } else {
            currentIndex = index;
        }
        const offset = -currentIndex * 100;
        wrapper.style.transform = `translateX(${offset}%)`;
    }

    // Ajouter des écouteurs d'événements pour les boutons suivant et précédent
    const nextButton = document.querySelector('#next-button');
    const prevButton = document.querySelector('#prev-button');

    nextButton.addEventListener('click', function() {
        showSlide(currentIndex + 1);
    });

    prevButton.addEventListener('click', function() {
        showSlide(currentIndex - 1);
    });

    // Fonction qui déplace le carrousel vers l'image correspondant à la couleur sélectionnée
    document.querySelectorAll('.color-square').forEach(function(square) {
        square.addEventListener('click', function() {
            var selectedColorId = this.getAttribute('data-color-id');
            
            // Rechercher la première image qui correspond à la couleur sélectionnée
            var selectedImageIndex = -1;
            slides.forEach(function(slide, index) {
                var image = slide.querySelector('.carousel-image');
                if (image.getAttribute('data-option-id') === selectedColorId) {
                    selectedImageIndex = index;
                }
            });

            // Si une image correspondant à la couleur est trouvée, afficher la diapositive correspondante
            if (selectedImageIndex !== -1) {
                showSlide(selectedImageIndex);
            }
        });
    });

    // Initialiser le carrousel sur la première diapositive
    showSlide(currentIndex);
    startAutoSlide();
});