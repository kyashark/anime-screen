// MOVIE.JS - Handles movie-specific interactions

document.addEventListener("DOMContentLoaded", function () {
  // Initialize only if movie elements exist
  if (document.getElementById("movie-grid") || document.querySelector(".movie-card")) {
    initializeMovieInteractions();
  }

  initializeAddListToggle();
  initializeWatchlistButton();
});

function initializeMovieInteractions() {
  // Movie Cards click handler
  document.addEventListener("click", function (event) {
    const card = event.target.closest(".movie-card");
    if (card) {
      const movieId = card.dataset.id;
      const baseUrl = window.location.origin + "/anime-screen/public/movie/movieprofile";
      window.location.href = `${baseUrl}/${movieId}`;
    }
  });

  // Initialize card hover effects
  initializeCardHover();
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

// Watchlist status button toggle (To Watch / Watching / Watched)
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

// Watchlist add and remove buttons (all cards)
function initializeAddListToggle() {
  const addBtns = document.querySelectorAll(".add-list-btn");

  if (!addBtns.length) return;

  addBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const movieId = btn.dataset.id;

      fetch(`${BASE_URL}/user/toggleWatchlist/${movieId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
          return res.json();
        })
        .then(data => {
          if (data.status === "added") {
            btn.classList.remove("add");
            btn.classList.add("remove");
            btn.textContent = "Saved";
          } else {
            btn.classList.remove("remove");
            btn.classList.add("add");
            btn.textContent = "Watchlist";
          }

          window.location.reload();
        })
  
        .catch(error => {
          console.error("Fetch error:", error);
        });
    });
  });
}

function refreshWatchlistGrid() {
  fetch(`${BASE_URL}/user/getWatchlistJson`)
    .then(res => res.json())
    .then(movies => {
      const grid = document.getElementById('watchlist-grid');
      grid.innerHTML = ''; // clear current grid
      
      movies.forEach(movie => {
        // Create the HTML for each movie card - customize this to your HTML structure
        const card = document.createElement('div');
        card.className = 'movie-card';
        card.dataset.id = movie.id;
        card.innerHTML = `
          <img src="${BASE_URL}/images/cover/${movie.image}" alt="${movie.movie_name}">
          <h3>${movie.movie_name}</h3>
          <button class="add-list-btn remove" data-id="${movie.id}">Saved</button>
        `;
        grid.appendChild(card);
      });

      // Re-initialize buttons or interactions if needed
      initializeAddListToggle();
      initializeMovieInteractions();
    });
}



// Exported for use in filter.js
function initializeCardInteractions() {
  initializeCardHover();
  initializeHeartClick();
}
