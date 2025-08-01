
document.addEventListener("DOMContentLoaded", function() {
    initializeFiltering();
});

function initializeFiltering() {

      const searchInput = document.querySelector(".search-input");
        if (searchInput) {
        // debounce to limit frequency of search calls
        let debounceTimeout;
        searchInput.addEventListener("input", function () {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            updateMovies(); // Refresh movies with new search query
        }, 300);
        });
    }



    // Initialize sorting
    const sortSelector = document.querySelector(".sort-selector");
    
    if (sortSelector) {
        if (document.querySelector(".movie-admin-action")) {
            initializeManagementSorting(sortSelector);
        } else {
            const sortButtons = document.querySelectorAll(".sort");
            if (sortButtons.length > 0) {
                initializeSorting(sortButtons, sortSelector);
            }
        }
    }

    // Initialize genres
    const genreButtons = document.querySelectorAll(".genre");
    if (genreButtons.length > 0) {
        initializeGenres(genreButtons);
    }

    // Initialize management page specific features
    if (document.querySelector(".movie-admin-action")) {
        initializeManagementFilters();
    }

    // Initial load from URL
    loadFiltersFromUrl();
}

function initializeManagementSorting(sortSelector) {
    sortSelector.addEventListener("change", function() {
        const selectedValue = this.value;
        console.log("Sort changed to:", selectedValue);
        
        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get("type") || "movie";
        const genres = urlParams.get("genres");
        
        let newUrl = `${window.location.pathname}?type=${type}&sort=${selectedValue}`;
        if (genres) newUrl += `&genres=${genres}`;
        
        console.log("Updating URL to:", newUrl); // Debug
        history.pushState(null, "", newUrl);
        fetchMovies();
    });
}

function initializeSorting(sortButtons, sortSelector) {
    sortButtons.forEach((button) => {
        button.addEventListener("click", () => {
            // Check if the clicked button is already active
            const wasActive = button.classList.contains("active");
            
            // Remove active class from all buttons
            sortButtons.forEach((btn) => btn.classList.remove("active"));
            
            // Toggle the active state
            if (!wasActive) {
                button.classList.add("active");
            }
            
            // Update the sort selector value
            const newSort = wasActive ? "random" : button.dataset.sort;
            sortSelector.value = newSort;
            
            // Force update the movies
            updateMovies();
        });
    });

    sortSelector.addEventListener("change", () => {
        const selectedValue = sortSelector.value;
        sortButtons.forEach((button) => {
            button.classList.toggle("active", 
                selectedValue !== "random" && button.dataset.sort === selectedValue
            );
        });
        updateMovies();
    });
}

function initializeGenres(genreButtons) {
    genreButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (button.tagName === 'BUTTON') {
                button.classList.toggle("active");
            } else if (button.type === 'checkbox') {
                button.classList.toggle("active", button.checked);
            }
            updateMovies();
        });
    });
}

// Admin filter genres

function initializeManagementFilters() {
    const toggleGenres = document.getElementById("toggle-genres");
    const genresWrapper = document.getElementById("genres-wrapper");
    const container = document.getElementById("genre-selector");

    if (toggleGenres && genresWrapper) {
        toggleGenres.addEventListener("click", (e) => {
            e.stopPropagation();
            const isVisible = genresWrapper.style.display === "flex";
            genresWrapper.style.display = isVisible ? "none" : "flex";
            genresWrapper.style.flexDirection = "column";
            genresWrapper.classList.toggle("active", !isVisible);
        });

        document.addEventListener('click', function(event) {
            if (!container.contains(event.target)) {
                genresWrapper.style.display = "none";
                genresWrapper.classList.remove("active");
            }
        });
    }
}


function updateMovies() {
    let sort, activeGenres;

    if (document.getElementById("movie-grid")) {
        // Movie grid page
        sort = document.querySelector(".sort.active")?.dataset.sort || "random";
        activeGenres = [...document.querySelectorAll(".genre.active")].map(
            (button) => button.dataset.genre
        );
    } else {
        // Management page
        const sortSelector = document.querySelector(".sort-selector");
        sort = sortSelector ? sortSelector.value : "random";
        activeGenres = [...document.querySelectorAll(".genre[type='checkbox']:checked")].map(
            (checkbox) => checkbox.dataset.genre
        );
    }

    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get("type") || "movie";

    const searchInput = document.querySelector(".search-input");
    const searchQuery = searchInput ? searchInput.value.trim() : "";

    let newUrl = `${window.location.pathname}?type=${type}&sort=${sort}`;

    if (activeGenres.length) newUrl += `&genres=${activeGenres.join(",")}`;

    if (searchQuery.length > 0) {
        newUrl += `&query=${encodeURIComponent(searchQuery)}`;
    }

    history.pushState(null, "", newUrl);
    fetchMovies();
    syncSortSelector();
}


function fetchMovies() {
    const url = window.location.href;
    const movieGrid = document.getElementById("movie-grid");
    const movieDataContainer = document.querySelector(".movie-data");

    // Show loading state
    if (movieDataContainer) {
        movieDataContainer.innerHTML = "<div class='loading'>Loading movies...</div>";
    }

    fetch(url, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((movies) => {
        if (movieGrid) {
            updateMovieGrid(movies);
        }
        if (movieDataContainer) {
            updateMovieTable(movies);
        }
    })
    .catch((error) => {
        console.error("Error loading movies:", error);
        if (movieDataContainer) {
            movieDataContainer.innerHTML = "<div class='error'>Error loading movies. Please try again.</div>";
        }
    });
}



function updateMovieGrid(movies) {
    const movieGrid = document.getElementById("movie-grid");
    let html = "";
    
    if (movies.length === 0) {
        html = '<p class="no-movie-msg">No movies found</p>';
    } else {
        movies.forEach((movie) => {
            html += `
                <div class="movie-card" 
                    style="background-image: url('${BASE_URL}/images/cover/${movie.image}');" 
                    data-id="${movie.id}">
                    <div class="card-label">
                        <span>${movie.movie_name}</span>
                        <div class="card-tab">
                            <span class="year">${new Date(movie.release_date).getFullYear()}</span>
                            <span class="vote-count">${movie.movie_votes}</span>
                            <span class="material-symbols-outlined heart">&#xe87d;</span>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    movieGrid.innerHTML = html;
    
    if (typeof initializeCardInteractions === 'function' && movies.length > 0) {
        initializeCardInteractions();
    }
}



function updateMovieTable(movies) {
const movieDataContainer = document.querySelector(".movie-data");
    movieDataContainer.innerHTML = "";

    if (!movies || movies.length === 0) {
        movieDataContainer.innerHTML = `
            <p class="no-movie-msg">No movies found</p>
        `;
        return; // Stop further processing
    }

    movies.forEach((movie) => {
        const movieRow = `
            <div class="movie-table-data">
                <div>
                    <label class="custom-checkbox">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span>${movie.id}</span>
                    </label>
                </div>
                <div>${movie.movie_name}</div>
                <div>${new Date(movie.release_date).getFullYear()}</div>
                <div>${movie.type}</div>
                <div>
                    ${movie.genres ? movie.genres.split(',').map(genre => 
                        `<p>${genre.trim()}</p>`
                    ).join('') : ''}
                </div>
                <div>${movie.movie_votes}</div>
                <div>
                    <button class="more-btn" data-id="${movie.id}">More</button>
                    <button class="delete-btn" data-id="${movie.id}">Delete</button>
                </div>
            </div>
        `;
        movieDataContainer.innerHTML += movieRow;
    });


    // To Delete
    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            const movieId = this.dataset.id;
            if (confirm("Are you sure you want to delete this movie?")) {
                fetch(`${BASE_URL}/movie/delete`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: `movie_id=${movieId}`
                })
                .then((res) => res.text())
                .then((msg) => {
                    console.log("Server response:", msg);
                    fetchMovies();
                })
                .catch((err) => {
                    console.error("Delete failed", err);
                });
            }
        });
    });


    // To Go Movie Profile
        document.querySelectorAll(".more-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            console.log("U triger button");
            const movieId = this.dataset.id;
            const baseUrl = `${window.location.origin}/anime-screen/public/movie/movieprofile`;
            window.location.href = `${baseUrl}/${movieId}`;
        });
    });

}





function loadFiltersFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const sort = urlParams.get("sort") || "random";
    const genres = urlParams.get("genres");
    const query = urlParams.get("query") || "";


    // Set search input value
    const searchInput = document.querySelector(".search-input");
    if (searchInput) {
      searchInput.value = query;
    }


    // Set sort selector value
    const sortSelector = document.querySelector(".sort-selector");
    if (sortSelector) {
        sortSelector.value = sort;
    }

    // Set active sort buttons (for movie grid page)
    const sortButtons = document.querySelectorAll(".sort");
    sortButtons.forEach((button) => {
        button.classList.toggle("active", button.dataset.sort === sort);
    });

    // Set active genres
    if (genres) {
        const selectedGenres = genres.split(",");
        const genreElements = document.querySelectorAll(".genre");
        
        genreElements.forEach((element) => {
            if (element.tagName === 'BUTTON') {
                element.classList.toggle("active", selectedGenres.includes(element.dataset.genre));
            } else if (element.type === 'checkbox') {
                element.checked = selectedGenres.includes(element.dataset.genre);
                element.classList.toggle("active", element.checked);
            }
        });
    }

    updateMovies();
}

function syncSortSelector() {
    const activeSortButton = document.querySelector(".sort.active");
    const sortSelector = document.querySelector(".sort-selector");
    
    if (sortSelector) {
        sortSelector.value = activeSortButton ? activeSortButton.dataset.sort : "random";
    }
}

window.addEventListener("popstate", function() {
    loadFiltersFromUrl();
});