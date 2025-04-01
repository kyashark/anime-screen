
document.addEventListener("DOMContentLoaded", function() {
    initializeFiltering();
});

function initializeFiltering() {

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

// function initializeSorting(sortButtons, sortSelector) {
//     sortButtons.forEach((button) => {
//         button.addEventListener("click", () => {
//             sortButtons.forEach((btn) => btn.classList.remove("active"));
//             button.classList.add("active");
//             updateMovies();
//         });
//     });

//     sortSelector.addEventListener("change", () => {
//         const selectedValue = sortSelector.value;
//         sortButtons.forEach((button) => {
//             button.classList.toggle("active", button.dataset.sort === selectedValue);
//         });
//         updateMovies();
//     });
// }
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

function initializeManagementFilters() {
    const toggleGenres = document.getElementById("toggle-genres");
    const genresWrapper = document.getElementById("genres-wrapper");
    const container = document.getElementById('genre-selector');

    if (toggleGenres && genresWrapper) {
        toggleGenres.addEventListener("click", (e) => {
            e.stopPropagation();
            // genresWrapper.style.display = 
            //     genresWrapper.style.display === "none" ? "flex" : "none";
            //     genresWrapper.style.flexDirection = "column";
            genresWrapper.classList.toggle("active");
            // if (genresWrapper.style.display === "none" || genresWrapper.style.display === "") {
            //     genresWrapper.style.display = "flex";
            //     genresWrapper.style.flexDirection = "column"; // Ensure flex direction is applied
            // } else {
            //     genresWrapper.style.display = "none";
            // }
        });

        document.addEventListener('click', function(event) {
            if (!container.contains(event.target)) {
                // genresWrapper.style.display = "none";
                genresWrapper.classList.remove("active");
                // if (!container.contains(event.target)) {
                //     genresWrapper.style.display = "none";
                // }
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

    let newUrl = `${window.location.pathname}?type=${type}&sort=${sort}`;
    if (activeGenres.length) newUrl += `&genres=${activeGenres.join(",")}`;

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
    movieGrid.innerHTML = "";
    
    movies.forEach((movie) => {
        const movieCard = `
            <div class="movie-card" 
                 style="background-image: url('${BASE_URL}/images/${movie.image}');" 
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
        movieGrid.innerHTML += movieCard;
    });
    
    if (typeof initializeCardInteractions === 'function') {
        initializeCardInteractions();
    }
}

function updateMovieTable(movies) {
    const movieDataContainer = document.querySelector(".movie-data");
    movieDataContainer.innerHTML = "";
    
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
                    <button class="update-btn">More</button>
                    <button class="delete-btn">Delete</button>
                </div>
            </div>
        `;
        movieDataContainer.innerHTML += movieRow;
    });
}

function loadFiltersFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const sort = urlParams.get("sort") || "random";
    const genres = urlParams.get("genres");

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

// function syncSortSelector() {
//     const activeSortButton = document.querySelector(".sort.active");
//     if (!activeSortButton) return;
    
//     const currentSort = activeSortButton.dataset.sort || "random";
//     const sortSelector = document.querySelector(".sort-selector");

//     if (sortSelector) {
//         sortSelector.value = currentSort;
//     }
// }

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