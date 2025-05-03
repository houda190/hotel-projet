// Animation de recherche quand l'utilisateur clique sur "Rechercher"
document.querySelector('.search-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la page de se recharger
  
    const searchQuery = document.querySelector('.search-form input[type="text"]').value;
    alert('Recherche pour: ' + searchQuery);
    // Vous pouvez ici ajouter un appel AJAX pour afficher des résultats en fonction de la recherche
  });
  
  // Exemple de filtre dynamique pour afficher les hôtels (à l'avenir, cela pourrait être connecté à une base de données)
  function filterHotels() {
    const searchValue = document.querySelector('.search-form input[type="text"]').value.toLowerCase();
    const hotels = document.querySelectorAll('.hotel');
  
    hotels.forEach(hotel => {
      const hotelName = hotel.querySelector('.hotel-name').textContent.toLowerCase();
      if (hotelName.includes(searchValue)) {
        hotel.style.display = 'block'; // Afficher l'hôtel
      } else {
        hotel.style.display = 'none'; // Masquer l'hôtel
      }
    });
  }
// Fonction pour filtrer les hôtels
function filterHotels() {
    const searchValue = document.querySelector('.search-form input[type="text"]').value.toLowerCase();
    const hotels = document.querySelectorAll('.hotel');
  
    hotels.forEach(hotel => {
      const hotelName = hotel.querySelector('.hotel-name').textContent.toLowerCase();
      if (hotelName.includes(searchValue)) {
        hotel.style.display = 'block'; // Afficher l'hôtel
      } else {
        hotel.style.display = 'none'; // Masquer l'hôtel
      }
    });
  }
  
  // Lier le filtre à l'événement de recherche
  document.querySelector('.search-form input[type="text"]').addEventListener('input', filterHotels);
      