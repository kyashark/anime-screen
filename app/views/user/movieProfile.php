<!DOCTYPE html>
<html lang="en">
<head>
  <title>Anime Screen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
    <script>
        const BASE_URL = "<?= BASE_URL ?>"; // BASE URL for set images 
    </script>
</head>

<body>

    <div class="main-movie-profile-container">
        <div class="top-section">
            <img src="<?= BASE_URL ?>/images/background/<?php echo htmlspecialchars($movie['background_image']); ?>" alt="Background Image" class="movie-profile-container">

            <div class="back-box">
                <a href="javascript:history.back();">
                <div class="back">
                    <span></span>
                    <span></span>
                </div>
                </a>
     

            <?php if (in_array('admin', Session::get('roles') ?? [])): ?>
                <a href="<?= BASE_URL ?>/movie/edit/<?= $movie['id'] ?>" class="update-btn">
                    <i class="fas fa-pen"></i> Edit
                </a>
            <?php endif; ?>


            </div>

            <div class="shadow-container"></div>
        </div>

        <div class="movie-details-container">
            <div>
                <h1><?php echo $movie['movie_name'];  ?></h1>
                <p class="movie-year"><?php echo date('Y', strtotime($movie['release_date'])) ;?></p>
                <p class="movie-director">Directed by <?php echo htmlspecialchars($movie['author'] ?? 'Unknown'); ?></p>
                <p class="movie-geners"><?php echo str_replace(' ', ' . ', $movie['genres']); ?></P>
                
                 
                <div class="movie-action">
                      <!-- <button class="add-list-btn add" data-id="<?= $movie['id'] ?>">Watchlist</button> -->
                    <button  class="add-list-btn <?php echo $movie['isInWatchlist'] ? 'remove' : 'add'; ?>" data-id="<?php echo $movie['id']; ?>">
                        <?php echo $movie['isInWatchlist'] ? 'Saved' : 'Watchlist'; ?>
                    </button>
                    <span class="vote-count"><?php echo $movie['movie_votes'];?></span>
                    <span class="material-symbols-outlined heart" id="heart">&#xe87d;</span>  
                </div>
              

            </div>
            <div class="movie-cover">
                <img src='<?= BASE_URL ?>/images/cover/<?php echo $movie['image'];?>'>

            </div>
            <div><?php echo $movie['description'];?></div>
        </div>
        
 
    </div>  

  <script src="<?= BASE_URL ?>/js/main.js"></script>
  <script src="<?= BASE_URL ?>/js/movie.js"></script>
     
</body>
</html>


