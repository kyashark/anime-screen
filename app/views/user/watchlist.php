
<html>

<head>
  <title>Home</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
  <header>
    <h1>A</h1>
    <ul class="nav-bar" id="nav-bar">
          <li><a href="<?= BASE_URL ?>/user/home">Home</a></li>
          <li><a href="<?= BASE_URL ?>/movie/filter?type=movie&sort=random">Movies</a></li>
          <li><a href="<?= BASE_URL ?>/movie/filter?type=series&sort=random">Series</a></li>
          <li><a href="<?= BASE_URL ?>/user/watchlist">Watchlist</a></li>

    </ul>

    <div class="right-nav">
        <a href="#">
            <span class="username">
                <?php echo $username ?>
             </span>
        </a>
        <a href="<?= BASE_URL ?>/auth/logout"><button class="btn logout">Logout</button></a>
        
        <div class="menu-item" id="menu-item">
          <span></span>
          <span></span>
          <span></span>
        </div>
    
      </div>
     
  </header>
    <main>
        <div class="watchlist-container">
            
            <div class="watchlist-hero-section">
                <div class="watchlist-hero-content">
                    <span class="hero-icon">🎬</span>
                    <h1>Your Watchlist</h1>
                    <p>All the movies and shows you want to watch, in one place.</p>
                </div>
            </div>

            <div class="movie-watchlist-action">
                    <div class="first-section">
                        <select class="sort-selector" id="sort-selector">
                        <option value="random" selected>Sort Movies</option>
                        <option value="top">Top Voted</option>
                        <option value="new">New Release</option>
                        <option value="alpha">Alphabetical</option>
                        </select> 
        
                        <div class="genre-selector" id="genre-selector">
                        <button id="toggle-genres" class="genre">Select Genres</button>
                        <div class="genres-wrapper" id="genres-wrapper">
                                <label><input type="checkbox" class="genre" data-genre="adventure"> Adventure</label>
                                <label><input type="checkbox" class="genre" data-genre="comedy"> Comedy</label>
                                <label><input type="checkbox" class="genre" data-genre="drama"> Drama</label>
                                <label><input type="checkbox" class="genre" data-genre="horror"> Horror</label>
                                <label><input type="checkbox" class="genre" data-genre="sci-fi"> Sci-Fi</label>
                                <label><input type="checkbox" class="genre" data-genre="thriller"> Thriller</label>
                                <label><input type="checkbox" class="genre" data-genre="romance"> Romance</label>
                                <label><input type="checkbox" class="genre" data-genre="fantasy"> Fantasy</label>
                            </div>
                        </div>
                    </div>

                    <div class="second-section">
                        <input type="search" placeholder="Search Movie" class="search-input">
                    </div>
            </div>

            <div class="watchlist-container-grid">
                <div class="watchlist-grid">
                    <div class="watchlist-movie-card" id="watchlist-movie-card">
                        <div class="watchlist-movie-cover">
                            <img src='../../public/images/cover/ponyo.jpeg'> 
                        </div>
                        <div class="movie-details">
                            <div class="movie-watchlist-action">
                                <button class="watchlist-btn state-add">To Watch</button>
                            </div>
                            <h2>Ponyo</h2>
                            <p class="movie-year">1998</p>
                            <p class="movie-director">Directed by Hayao Miyazaki</p>
                            <p class="movie-geners">Adventure . Fantasy</P>
                            <div class="movie-action">
                                <button class="add-list-btn add">Watchlist</button>
                                <span class="vote-count">1000</span>
                                <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>  
                            </div>
                        </div>
                    </div>
                                        <div class="watchlist-movie-card" id="watchlist-movie-card">
                        <div class="watchlist-movie-cover">
                            <img src='../../public/images/cover/ponyo.jpeg'> 
                        </div>
                        <div class="movie-details">
                            <div class="movie-watchlist-action">
                                <button class="watchlist-btn state-add">To Watch</button>
                            </div>
                            <h2>Ponyo</h2>
                            <p class="movie-year">1998</p>
                            <p class="movie-director">Directed by Hayao Miyazaki</p>
                            <p class="movie-geners">Adventure . Fantasy</P>
                            <div class="movie-action">
                                <button class="add-list-btn add">Watchlist</button>
                                <span class="vote-count">1000</span>
                                <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>  
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="watchlist-stats">

                    <h4>Explore More</h4>
                    <div class="stat-box">
                        <h3>Favorites</h3>
                        <p>5</p>
                    </div>
                    <div class="stat-box">
                        <h3>To Watch</h3>
                        <p>24</p>
                    </div>
                    <div class="stat-box">
                        <h3>Watching</h3>
                        <p>3</p>
                    </div>
                    <div class="stat-box">
                        <h3>Watched</h3>
                        <p>14</p>
                    </div>
                </div>
            </div>

            



        </div>
   </main>

   
  <script src="<?= BASE_URL ?>/js/main.js"></script>
  <script src="<?= BASE_URL ?>/js/movie.js"></script>
  <script src="<?= BASE_URL ?>/js/filter.js"></script>
</body>

</html>