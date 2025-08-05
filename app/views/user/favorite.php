
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
        <a class="favorite-btn" href="<?= BASE_URL ?>/user/favoritesPage">
           <i class="far fa-heart"></i>
        </a>
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
  <span class="fa-solid fa-bookmark hero-icon"></span>

    <h1>Your Favorites</h1>
    <p>All the movies and shows you love, saved in one place</p>
  </div>
</div>

        <div class="watchlist-container-grid fav-page-grid">
            <div class="watchlist-grid">
                <?php if (empty($movies)) : ?>
                    <div class="watchlist-para">
                        No favorites found
                    </div>
                <?php else : ?>
                   <?php foreach ($movies as $movie) : ?>
                                <div class="watchlist-movie-card" data-status="<?= htmlspecialchars($movie['status'] ?? 'all') ?>">
                                <div class="watchlist-movie-cover">
                                     <img src='<?= BASE_URL ?>/images/cover/<?php echo $movie['image'];?>'>
                                </div>
                                <div class="movie-details">
                                    <div class="movie-watchlist-action">
                                    <?php
                                        $statusKey = !empty($movie['status']) ? $movie['status'] : 'to_watch';

                                        $classMap = [
                                        'to_watch' => 'state-add',
                                        'watching' => 'state-watching',
                                        'watched' => 'state-watched'
                                        ];

                                        $textMap = [
                                        'to_watch' => 'To Watch',
                                        'watching' => 'Watching',
                                        'watched' => 'Watched'
                                        ];

                                        $btnClass = $classMap[$statusKey];
                                        $btnText = $textMap[$statusKey];
                                    ?>
                                    <button class="watchlist-btn <?= $btnClass ?>" data-id="<?= $movie['watchlist_id'] ?>">
                                    <?= $btnText ?>
                                    </button>
                                    </div>
                                    <h2><?= htmlspecialchars($movie['movie_name']) ?></h2>
                                     <p class="movie-year"><?php echo date('Y', strtotime($movie['release_date'])) ;?></p>
                                    <p class="movie-director">Directed by <?= htmlspecialchars($movie['author']) ?></p>
                                    <p class="movie-geners"><?php echo str_replace(',', ' . ', $movie['genres']); ?></p>

                                    <div class="movie-action">
                                        <button 
                                            class="add-list-btn <?php echo $movie['isInWatchlist'] ? 'remove' : 'add'; ?>" 
                                            data-id="<?php echo $movie['id']; ?>">
                                            <?php echo $movie['isInWatchlist'] ? 'Saved' : 'Watchlist'; ?>
                                        </button>
                                        <span class="vote-count"><?= htmlspecialchars($movie['movie_votes']) ?></span>
                                           <span class="material-symbols-outlined heart <?= $movie['isFavorited'] ? 'active-heart' : '' ?>" 
                                                data-id="<?= $movie['id'] ?>"
                                                style="font-variation-settings: 'FILL' <?= $movie['isFavorited'] ? 1 : 0 ?>, 'wght' 400, 'GRAD' 0, 'opsz' 0;">
                                            &#xe87d;
                                            </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<div id="toast" class="toast"></div>

    <script>
    const BASE_URL = "<?= BASE_URL ?>";
    </script>
    <script src="<?= BASE_URL ?>/js/main.js"></script>
    <script src="<?= BASE_URL ?>/js/movie.js"></script>
</body>

</html>
