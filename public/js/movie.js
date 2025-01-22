
document.addEventListener("DOMContentLoaded", function () {
    // Filters, Movie Cards, and Heart Icons
    loadFiltersFromUrl();
    // initializeCardHover();
    // initializeHeartClick();
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
  sortButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (button.classList.contains("active")) {
        button.classList.remove("active");
      } else {
        sortButtons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");
      }
      updateMovies();
    });
  });
  
  // Genre button click event
  genreButtons.forEach((button) => {
    button.addEventListener("click", () => {
      button.classList.toggle("active");
      updateMovies();
    });
  });
  
  
  
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
                 style="background-image: url('${BASE_URL}/images/${movie.image}');" 
                 id="movie-card"
                 data-id="${movie.id}">

                 <div class="card-label" id="card-label">
                    <span>${movie.movie_name}</span>
                    <div class="movie-tab">
                    <span class="year">${new Date(movie.release_date).getFullYear()}</span>
                    <div class=""vote">
                        <span class="vote-count">${movie.movie_votes}</span>
                        <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>
                    </div>
                    </div>
                 </div>
            </div>
            
            `;
            movieGrid.innerHTML += movieCard;
          });
    
          // Optionally reinitialize behaviors like hover or click after loading
          // reinitialize();
        })
        .catch((error) => console.error("Error loading movies:", error));
    }

  // Listen for browser history changes and fetch new content
  window.addEventListener("popstate", fetchMovies);
  
  // Load filters from the URL (sort and genres) on page load
  function loadFiltersFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const sort = urlParams.get("sort") || "random"; // Default to "random" if not in URL
    const genres = urlParams.get("genres");
  
    // Set the active filter button
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
  