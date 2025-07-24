<!DOCTYPE html>
<html lang="en">
<head>
  <title>Zenith</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
    <script>
        const BASE_URL = "<?= BASE_URL ?>"; // BASE URL for set images 
    </script>
</head>

<body>
<header>
    <h1>As</h1>
    <ul class="nav-bar" id="nav-bar">
        <li><a href="<?= BASE_URL ?>/user/home">Home</a></li>
        <li><a href="<?= BASE_URL ?>/movie/filter?type=movie&sort=random">Movies</a></li>
        <li><a href="<?= BASE_URL ?>/movie/filter?type=series&sort=random">Series</a></li>
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
    <div class="movie-profile-container">
    <div class="movie-profile">
        <a href="javascript:history.back();">
        <div class="back">
            <span></span>
            <span></span>
        </div>
        </a>

        <div class="movie-content">
            <div class="movie-info">
                <h1><?php echo $movie['movie_name'];  ?></h1>
                <p>
                    <span class="movie-year"><?php echo date('Y', strtotime($movie['release_date'])) ;?></span>
                    <span class="movie-geners"><?php echo $movie['genres']; ?></span>
                </p>
                <p class="movie-description"><?php echo $movie['description'];?></p>
                <div class="movie-action">
                    <button>Add List</button>
                    <span class="vote-count"><?php echo $movie['movie_votes'];?></span>
                    <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>  
                </div>
                <p></p>  
            </div>
            <div class="movie-cover">
                <img src='<?= BASE_URL ?>/images/<?php echo $movie['image'];?>'>
            </div>
        </div>
    </div>
</main>
  <script src="<?= BASE_URL ?>/js/main.js"></script>
  <script src="<?= BASE_URL ?>/js/movie.js"></script>
     
</body>
</html>


