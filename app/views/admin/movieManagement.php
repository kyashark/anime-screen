<html>
<?php 
if (!empty($movies)) {
    foreach ($movies as $movie) { 
        // Display movie data
    }
} else {
    echo "<p>No movies found.</p>";
}
?>
<head>
  <title>Zenith</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
  <style>

  .genres-wrapper {
    width: 200px;
    position: absolute;
    background: white;
    padding: 10px;
    border: 1px solid #ccc;
    display: none;
    top: 40px;
    left: 0;
    z-index: 1000;
  }



  .genre-container {
    position: relative;
    display: inline-block;
  }
</style>
</head>

<body>
<header>
    <a href="<?= BASE_URL ?>/user/admin">
        <div class="back">
            <span></span>
            <span></span>
        </div>
    </a>
    
    <h2>Movie Management</h2>

    <div class="right-nav">
        <a href="#">
            <span class="username">
                <?php echo $username ?>
             </span>
        </a>
        <a href="<?= BASE_URL ?>/auth/register"><button class="btn logout">Logout</button></a>
    </div>
     
</header>
  
<main>
    <div class="admin-container">
        <div class="movie-admin-action">
            <div class="filter-section">
        
    
            <select class="sort-selector" id="sort-selector">
            <option value="random" selected>Sort Movies</option>
  <option value="top">Top Voted</option>
  <option value="new">New Release</option>
  <option value="alpha">Alphabetical</option>
</select> 
 
 
        
  <div class="genre-selector" id="genre-selector">
  <button id="toggle-genres">Select Genres</button>
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
                
                <input type="search" placeholder="Search" class="search-input">
            </div>
            <a href="<?= BASE_URL ?>/movie/addMovie"><button class="add-movie-btn">Add Movie</button></a>
        </div>
            <div class="movie-table-header">
                    <div>ID</div>
                    <div>Movie Name</div>
                    <div>Year</div>
                    <div>Type</div>
                    <div>Genres</div>
                    <div>Votes</div>
                    <div>Action</div>
            </div>

        <div class="movie-data">
            <?php 
            if (!empty($movies)) {
                foreach ($movies as $movie) { 
                    ?>
                    <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span><?= htmlspecialchars($movie['id']) ?></span>
                            </label>
                        </div>
                        <div><?= htmlspecialchars($movie['movie_name']) ?></div>
                        <div><?= htmlspecialchars(date('Y', strtotime($movie['release_date']))) ?></div>
                        <div><?= $movie['type'] ?></div>
                        <div>
                            <?php 
                            if (!empty($movie['genres'])) {
                                $genreList = explode(',', $movie['genres']); 
                                foreach ($genreList as $genre) {
                                    echo "<p>" . htmlspecialchars(trim($genre)) . "</p>";
                                }
                            }
                            ?>
                        </div>
                        <div><?= htmlspecialchars($movie['movie_votes']) ?></div>
                        <div>
                            <button class="update-btn">More</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No movies found.</p>";
            }
            ?>

                <!-- <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                </div> -->
            </div>
        </div>
    
</main>
<script src="<?= BASE_URL ?>/js/main.js"></script>
<script src="<?= BASE_URL ?>/js/movie.js"></script>
<script src="<?= BASE_URL ?>/js/filter.js"></script>

</body>
</html>