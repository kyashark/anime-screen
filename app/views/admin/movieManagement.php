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
  <title>Anime Screen</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
  <style>

</style>
</head>

<body>
<header>
    <a href="<?= BASE_URL ?>/admin/dashboard">
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
        <a href="<?= BASE_URL ?>/auth/logout"><button class="btn logout">Logout</button></a>
    </div>
     
</header>
  
<main>
    <div class="admin-container">
        <div class="movie-admin-action">
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
        <a href="<?= BASE_URL ?>/movie/create"><button class="add-movie-btn">Add Movie</button></a>
        </div>
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
        
        <!-- Movies fetch using js -->

        </div>
        </div>
    
</main>
<script src="<?= BASE_URL ?>/js/main.js"></script>
<script src="<?= BASE_URL ?>/js/movie.js"></script>
<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/js/filter.js"></script>

</body>
</html>