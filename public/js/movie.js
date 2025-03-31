// MOVIE.JS - Handles movie-specific interactions

document.addEventListener("DOMContentLoaded", function() {
  // Initialize only if movie elements exist
  if (document.getElementById("movie-grid") || document.querySelector(".movie-card")) {
    initializeMovieInteractions();
  }
});

function initializeMovieInteractions() {
  // Movie Cards click handler
  document.addEventListener("click", function(event) {
    const card = event.target.closest(".movie-card");
    if (card) {
      const movieId = card.dataset.id;
      const baseUrl = window.location.origin + "/zenith-movies/public/movie/movieprofile";
      window.location.href = `${baseUrl}/${movieId}`;
    }
  });

  // Initialize card hover effects
  initializeCardHover();
  
  // Initialize heart icons
  initializeHeartClick();
}

function initializeCardHover() {
  const cardItems = document.querySelectorAll(".movie-card");
  const labelItems = document.querySelectorAll(".card-label");

  cardItems.forEach((cardItem, index) => {
    const labelItem = labelItems[index];
    if (labelItem) {
      labelItem.style.display = "none";

      cardItem.addEventListener("mouseenter", () => {
        labelItem.style.display = "grid";
      });

      cardItem.addEventListener("mouseleave", () => {
        labelItem.style.display = "none";
      });
    }
  });
}

function initializeHeartClick() {
  const heartItems = document.querySelectorAll(".material-symbols-outlined");

  heartItems.forEach((heartItem) => {
    heartItem.addEventListener("click", (event) => {
      event.stopPropagation();

      const currentStyle = window.getComputedStyle(heartItem).fontVariationSettings;

      if (currentStyle.includes('"FILL" 0')) {
        heartItem.style.fontVariationSettings = '"FILL" 1, "wght" 400, "GRAD" 0, "opsz" 0';
      } else {
        heartItem.style.fontVariationSettings = '"FILL" 0, "wght" 400, "GRAD" 0, "opsz" 0';
      }
    });
  });
}

// Make this available to filter.js
function initializeCardInteractions() {
  initializeCardHover();
  initializeHeartClick();
}