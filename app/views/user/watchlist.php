
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

            <div class="watchlist-acttion-container">
                <div class="watchlist-stats">
                    <button class="stat-box">
                        <h3>Favorites</h3>
                        <p>5</p>
                    </button>
                    <button class="stat-box">
                        <h3>To Watch</h3>
                        <p>24</p>
                    </button>
                    <button class="stat-box">
                        <h3>Watching</h3>
                        <p>3</p>
                    </button>
                    <button class="stat-box">
                        <h3>Watched</h3>
                        <p>14</p>
                    </button>
                </div>
                 <input type="search" placeholder="Search Movie" class="watchlist-search-input">
            </div>

            

            <div class="watchlist-container-grid">
                <div class="watchlist-grid">
                    <?php if (!empty($movies)) : ?>
                        <?php foreach ($movies as $movie) : ?>
                            <div class="watchlist-movie-card">
                                <div class="watchlist-movie-cover">
                                    <!-- <img src="<?= BASE_URL ?>/public/images/cover/<?= htmlspecialchars($movie['image']) ?>"> -->
                                     <img src='<?= BASE_URL ?>/images/cover/<?php echo $movie['image'];?>'>
                                </div>
                                <div class="movie-details">
                                    <div class="movie-watchlist-action">
                                        <button class="watchlist-btn state-add">To Watch</button>
                                    </div>
                                    <h2><?= htmlspecialchars($movie['movie_name']) ?></h2>
                                    <!-- <p class="movie-year"><?= htmlspecialchars($movie['release_date']) ?></p> -->
                                     <p class="movie-year"><?php echo date('Y', strtotime($movie['release_date'])) ;?></p>
                                    <p class="movie-director">Directed by <?= htmlspecialchars($movie['author']) ?></p>
                                    <p class="movie-geners"><?php echo str_replace(',', ' . ', $movie['genres']); ?></p>

                                    <div class="movie-action">
                                        <!-- <button class="add-list-btn remove" data-id="<?= $movie['id'] ?>">Saved</button> -->
                                        <button 
                                            class="add-list-btn <?php echo $movie['isInWatchlist'] ? 'remove' : 'add'; ?>" 
                                            data-id="<?php echo $movie['id']; ?>">
                                            <?php echo $movie['isInWatchlist'] ? 'Saved' : 'Watchlist'; ?>
                                        </button>
                                        <span class="vote-count"><?= htmlspecialchars($movie['movie_votes']) ?></span>
                                        <span class="material-symbols-outlined heart">&#xe87d;</span>  
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="watchlist-para">No movies in your watchlist</p>
                    <?php endif; ?>

                </div>
                
               

            



        </div>
   </main>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>
  <script src="<?= BASE_URL ?>/js/main.js"></script>
  <script src="<?= BASE_URL ?>/js/movie.js"></script>
  <script src="<?= BASE_URL ?>/js/filter.js"></script>
</body>

</html>



   <!-- <div class="watchlist-movie-card" id="watchlist-movie-card">
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
</div> -->