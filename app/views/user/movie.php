
<html>

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
  <div class="movie-container">
    <div class="sort-container">
      <section>
        <button class="sort" data-sort="top">Top Voted</button>
        <button class="sort" data-sort="new">New Release</button>
        <button class="sort" data-sort="alpha">Alphabetical</button>
      </section>

      <select class="sort-selector" id="sort-selector">
      <option value="random" selected>Sort Movies</option>
            <option value="top">Top Voted</option>
            <option value="new">New Realease</option>
            <option value="alpha">Alphabetical</option>
      </select>    
      <input type="search" placeholder="Search Movie" class="search-input">
    </div>

    <div class="genre-container">
      <button class="genre" data-genre="action">Action</button>
      <button class="genre" data-genre="adventure">Adventure</button>
      <button class="genre" data-genre="comedy">Comedy</button>
      <button class="genre" data-genre="drama">Drama</button>
      <button class="genre" data-genre="horror">Horror</button>
      <button class="genre" data-genre="sci-fi">Sci-Fi</button>
      <button class="genre" data-genre="thriller">Thriller</button>
      <button class="genre" data-genre="romance">Romance</button>
      <button class="genre" data-genre="fantasy">Fantasy</button>
    </div>

    <div class="movie-grid" id="movie-grid">
      <p class="no-movie-msg">No movies found</p>
    </div>
  </div>
  </main>

 
  <script src="<?= BASE_URL ?>/js/main.js"></script>
  <script src="<?= BASE_URL ?>/js/movie.js"></script>
  <script src="<?= BASE_URL ?>/js/filter.js"></script>
 
</body>
