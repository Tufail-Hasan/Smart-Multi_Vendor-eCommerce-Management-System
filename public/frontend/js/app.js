document.addEventListener('DOMContentLoaded', function () {

    // Wishlist button visual interaction
    document.querySelectorAll('.wishlist-btn').forEach(button => {

        button.addEventListener('click', function () {

            this.classList.toggle('active');

            this.textContent = this.classList.contains('active')
                ? '♥'
                : '♡';

        });

    });

});
