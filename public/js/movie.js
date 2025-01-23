document.addEventListener("DOMContentLoaded", function () {
  // Filters, Movie Cards, and Heart Icons
  loadFiltersFromUrl();
  initializeCardHover();
  initializeHeartClick();
});

// Movie Filter and URL Update
const sortButtons = document.querySelectorAll(".sort");
const genreButtons = document.querySelectorAll(".genre");
const movieGrid = document.querySelector("#movie-grid");

function updateMovies() {
  const sort = document.querySelector(".sort.active")?.dataset.sort || "random";
  const activeGenres = [...document.querySelectorAll(".genre.active")].map(
    (button) => button.dataset.genre
  );

  const urlParams = new URLSearchParams(window.location.search);
  const type = urlParams.get("type") || "defaultType"; // Default type if not present

  let newUrl = `${window.location.origin}${window.location.pathname}?type=${type}&sort=${sort}`;

  if (activeGenres.length) newUrl += `&genres=${activeGenres.join(",")}`;

  history.pushState(null, "", newUrl);
  fetchMovies();
}

  // Sort button click event
  sortButtons.forEach(button => {
    button.addEventListener("click", () => {
      if (button.classList.contains("active")) {
        button.classList.remove("active");
      } else {
        sortButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");
      }
      updateMovies();
    });
  });
  
  // Genre button click event
  genreButtons.forEach(button => {
    button.addEventListener("click", () => {
      button.classList.toggle("active");
      updateMovies();
    });
  });

// Fetch movies via AJAX and update the movie grid
function fetchMovies() {
  const url = window.location.href;
  console.log(url);
  const movieGrid = document.getElementById("movie-grid");

  fetch(url, {
    method: "GET",
    headers: {
      "X-Requested-With": "XMLHttpRequest", // Mark as AJAX request
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json(); // Parse the JSON response
    })
    .then((movies) => {
      movieGrid.innerHTML = ""; // Clear the grid before adding movies
      movies.forEach((movie) => {
        console.log(`${BASE_URL}/images/${movie.image}`);

        const movieCard = `
            <div class="movie-card" 
                 style="background-image: url('${BASE_URL}/images/${
          movie.image
        }');" 
                 id="movie-card"
                 data-id="${movie.id}">

                 <div class="card-label" id="card-label">
                    <span>${movie.movie_name}</span>
                    <div class="card-tab">
                        <span class="year">${new Date(
                          movie.release_date
                        ).getFullYear()}</span>
                        <span class="vote-count">${movie.movie_votes}</span>
                        <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>
                
                    </div>
                 </div>
            </div>
            
            `;
        movieGrid.innerHTML += movieCard;
      });

      // Optionally reinitialize behaviors like hover or click after loading
      reinitialize();
    })
    .catch((error) => console.error("Error loading movies:", error));
}

// Listen for browser history changes and fetch new content
window.addEventListener("popstate", fetchMovies);

// Card Hover Effect
function initializeCardHover() {
  const cardItems = document.querySelectorAll(".movie-card");
  const labelItems = document.querySelectorAll(".card-label");

  cardItems.forEach((cardItem, index) => {
    const labelItem = labelItems[index];
    labelItem.style.display = "none";

    cardItem.addEventListener("mouseenter", () => {
      labelItem.style.display = "grid";
    });

    cardItem.addEventListener("mouseleave", () => {
      labelItem.style.display = "none";
    });
  });
}

// Heart Icon Click Behavior
function initializeHeartClick() {
  const heartItems = document.querySelectorAll(".material-symbols-outlined");

  heartItems.forEach((heartItem) => {
    heartItem.addEventListener("click", () => {
      const currentStyle =
        window.getComputedStyle(heartItem).fontVariationSettings;

      if (currentStyle.includes('"FILL" 0')) {
        heartItem.style.fontVariationSettings =
          '"FILL" 1, "wght" 400, "GRAD" 0, "opsz" 0';
      } else {
        heartItem.style.fontVariationSettings =
          '"FILL" 0, "wght" 400, "GRAD" 0, "opsz" 0';
      }
    });
  });
}

// Re-initialize hover and heart click functionality after AJAX update
function reinitialize() {
  initializeCardHover();
  initializeHeartClick();
}

// Load filters from the URL (sort and genres) on page load
function loadFiltersFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  const sort = urlParams.get("sort") || "random"; // Default to "random" if not in URL
  const genres = urlParams.get("genres");

  // Set the active sort button
  const activeSort = [...sortButtons].find(
    (button) => button.dataset.sort === sort
  );
  if (activeSort) {
    activeSort.classList.add("active");
  }

  // Set the active genre buttons
  if (genres) {
    const selectedGenres = genres.split(",");
    genreButtons.forEach((button) => {
      if (selectedGenres.includes(button.dataset.genre)) {
        button.classList.add("active");
      }
    });
  }

  updateMovies();
}
