<html>

<div class="app-wrapper">
<head>
  <title>Home</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
  <header>
    <?php
      $currentUrl = $_SERVER['REQUEST_URI'];
    ?>
    <h1>A</h1>
    <ul class="nav-bar" id="nav-bar">
      <li><a href="<?= BASE_URL ?>/user/home" class="<?= strpos($currentUrl, '/user/home') !== false ? 'active' : '' ?>">Home</a></li>
      <li><a href="<?= BASE_URL ?>/movie/filter?type=movie" class="<?= strpos($currentUrl, '/movie/filter?type=movie') !== false ? 'active' : '' ?>">Movies</a></li>
      <li><a href="<?= BASE_URL ?>/movie/filter?type=series" class="<?= strpos($currentUrl, '/movie/filter?type=series') !== false ? 'active' : '' ?>">Series</a></li>
      <li><a href="<?= BASE_URL ?>/user/watchlist" class="<?= strpos($currentUrl, '/user/watchlist') !== false ? 'active' : '' ?>">Watchlist</a></li>
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
  <div class="home-container">
    <h1>Anime Screen</h1>
    <div class="card-container">
      <div class="card">
        <div class="arrow">
          <img src="<?= BASE_URL ?>/images/arrow.png">
        </div>
        <p>Genre Highlights</p>
      </div>
      <div class="card">
        <div class="arrow">
          <img src="<?= BASE_URL ?>/images/arrow.png">
        </div>
        <p>New Release</p>
      </div>
      <div class="card">
        <div class="arrow">
          <img src="<?= BASE_URL ?>/images/arrow.png">
        </div>
        <p>Trending Now</p>
      </div>
    </div>
     
    <section id="genre-highlights" class="content-section"></section>

    <section id="new-release" class="content-section"></section>

    <section id="trending-now" class="content-section"></section>
   
  </div>
</main>

</div>

  <div class="background-image">
    <img src="<?= BASE_URL ?>/images/dragon.png">
  </div>
  <script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
 