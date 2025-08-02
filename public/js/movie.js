// MOVIE.JS - Handles movie-specific interactions

document.addEventListener("DOMContentLoaded", function() {
  // Initialize only if movie elements exist
  if (document.getElementById("movie-grid") || document.querySelector(".movie-card")) {
    initializeMovieInteractions();
  }

  if(document.getElementById("watchlist-movie-card")){
    initializeWatchlistButton() 
  }

  
  if (document.querySelector(".add-list-btn")) {
    initializeAddListToggle();
  }
});

function initializeMovieInteractions() {
  // Movie Cards click handler
  document.addEventListener("click", function(event) {
    const card = event.target.closest(".movie-card");
    if (card) {
      const movieId = card.dataset.id;
      const baseUrl = window.location.origin + "/anime-screen/public/movie/movieprofile";
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


// Watchlist action button
function initializeWatchlistButton() {
  const btn = document.querySelector('.watchlist-btn');

  if (!btn) return;

  const states = [
    { class: 'state-add', text: 'To Watch' },
    { class: 'state-watching', text: 'Watching' },
    { class: 'state-watched', text: 'Watched' },
  ];

  let current = 0;

  btn.addEventListener("click", () => {
    btn.classList.remove(states[current].class);
    current = (current + 1) % states.length;
    btn.classList.add(states[current].class);
    btn.textContent = states[current].text;
  });
}

// Watchlist add and remove button
function initializeAddListToggle() {
  const addBtn = document.querySelector(".add-list-btn");

  if (!addBtn) return;

  addBtn.addEventListener("click", () => {
    const isAdded = addBtn.classList.contains("remove");

    if (isAdded) {
      // Remove from watchlist
      addBtn.classList.remove("remove");
      addBtn.classList.add("add");
      addBtn.textContent = "Watchlist";
    } else {
      // Add to watchlist
      addBtn.classList.remove("add");
      addBtn.classList.add("remove");
      addBtn.textContent = "Remove";
    }
  });
}


// Make this available to filter.js
function initializeCardInteractions() {
  initializeCardHover();
  initializeHeartClick();
}

