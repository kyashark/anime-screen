// Handles movie-specific interactions

document.addEventListener("DOMContentLoaded", function () {
  if (
    document.getElementById("movie-grid") ||
    document.querySelector(".movie-card") ||
    document.querySelector(".watchlist-movie-card")
  ) {
    initializeMovieInteractions();
  }

  initializeAddListToggle();
  initializeWatchlistButton();
  initializeWatchlistFilter();
  updateWatchlistCounts();
});

function initializeMovieInteractions() {
  // Movie Cards click handler
  document.addEventListener("click", function (event) {
    const card = event.target.closest(".movie-card");
    if (card) {
      const movieId = card.dataset.id;
      const baseUrl =
        window.location.origin + "/anime-screen/public/movie/movieprofile";
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

// WATCHLIST BUTTON TOGGLE HANDLE
function initializeAddListToggle() {
  const addBtns = document.querySelectorAll(".add-list-btn");

  if (!addBtns.length) return;

  addBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const movieId = btn.dataset.id;

      fetch(`${BASE_URL}/user/toggleWatchlist/${movieId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((res) => {
          if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
          return res.json();
        })
        .then((data) => {
          if (data.status === "added") {
            btn.classList.remove("add");
            btn.classList.add("remove");
            btn.textContent = "Saved";
          } else {
            btn.classList.remove("remove");
            btn.classList.add("add");
            btn.textContent = "Watchlist";
          }

          localStorage.setItem(
            "watchlistFilter",
            document.querySelector(".stat-box.active")?.dataset.status || "all"
          );
          window.location.reload();
        })

        .catch((error) => {
          console.error("Fetch error:", error);
        });
    });
  });
}

// Watchlist status button toggle (To Watch / Watching / Watched)

function initializeWatchlistButton() {
  const buttons = document.querySelectorAll(".watchlist-btn");

  if (!buttons.length) return;

  const states = [
    { class: "state-add", text: "To Watch" },
    { class: "state-watching", text: "Watching" },
    { class: "state-watched", text: "Watched" },
  ];

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      console.log("Watchlist button clicked");

      let current = states.findIndex((s) => btn.classList.contains(s.class));
      if (current === -1) current = 0;

      const next = (current + 1) % states.length;

      const statusValue = ["to_watch", "watching", "watched"][next];
      const watchlistId = btn.dataset.id;

      console.log(
        "Sending to:",
        `${BASE_URL}/user/updateWatchlistStatus/${watchlistId}`
      );
      console.log("Payload:", JSON.stringify({ status: statusValue }));

      fetch(`${BASE_URL}/user/updateWatchlistStatus/${watchlistId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ status: statusValue }),
      })
        .then((res) => res.json())
        .then((data) => {
          console.log("Response from server:", data);
          if (data.success) {
            current = (current + 1) % states.length;

            btn.classList.remove(...states.map((s) => s.class));
            btn.classList.add(states[current].class);
            btn.textContent = states[current].text;

            window.location.reload();
          } else {
            console.error("Update failed:", data.error);
          }
        })
        .catch((err) => console.error("Fetch failed", err));
    });
  });
}

// FILTER WATCHLIST MOVIES
function initializeWatchlistFilter() {
  const filterButtons = document.querySelectorAll(".stat-box");
  const movieCards = document.querySelectorAll(".watchlist-movie-card");
  const emptyMessage = document.getElementById('empty-message');

  const statusMessages = {
    all: "No movies in your watchlist",
    to_watch: "No movies in to watch",
    watching: "You’re not watching anything yet",
    watched: "You haven't finished any movies yet"
  };

  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      button.classList.add("active");

      const selectedStatus = button.dataset.status;
      let visibleCount = 0;

      localStorage.setItem("watchlistFilter", selectedStatus);

      movieCards.forEach((card) => {
        if (
          selectedStatus === "all" ||
          card.dataset.status === selectedStatus
        ) {
          card.style.display = "";
          visibleCount++; // increment count
        } else {
          card.style.display = "none";
        }
      });

      // show/hide empty message
      if (visibleCount === 0) {
        emptyMessage.style.display = 'block';
        emptyMessage.textContent = statusMessages[selectedStatus];
      } else {
        emptyMessage.style.display = 'none';
      }

      // Handle last-visible class for bottom border
      movieCards.forEach((card) => card.classList.remove("last-visible"));

      const visibleCards = Array.from(movieCards).filter(
        (card) => card.style.display !== "none"
      );
      if (visibleCards.length > 0) {
        visibleCards[visibleCards.length - 1].classList.add("last-visible");
      }
    });
  });

  //  Restore filter from localStorage
  const savedFilter = localStorage.getItem("watchlistFilter");
  if (savedFilter) {
    const savedButton = document.querySelector(
      `.stat-box[data-status="${savedFilter}"]`
    );
    if (savedButton) savedButton.click();
  }
}



// UPDATE MOVIE COUNT IN BUTTON
function updateWatchlistCounts() {
  const movieCards = document.querySelectorAll('.watchlist-movie-card');

  const counts = {
    to_watch: 0,
    watching: 0,
    watched: 0,
  };

  movieCards.forEach(card => {
    const status = card.dataset.status;
    if (counts.hasOwnProperty(status)) {
      counts[status]++;
    }
  });

  // Set count in DOM
  document.querySelector('.count-to_watch').textContent = counts.to_watch;
  document.querySelector('.count-watching').textContent = counts.watching;
  document.querySelector('.count-watched').textContent = counts.watched;

  // All = total
  document.querySelector('.count-all').textContent = movieCards.length;
}


// Exported for use in filter.js
function initializeCardInteractions() {
  initializeCardHover();
  initializeHeartClick();
}
