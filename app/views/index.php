<html>

<head>
  <title>Anime Screen</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
  <header>
    <h1>A</h1>
    <ul class="nav-bar" id="nav-bar">
          <li><a href="#">Home</a></li>
          <li><a href="#">Movies</a></li>
          <li><a href="#">Series</a></li>
    </ul>

    <div class="right-nav">
        <a href="<?= BASE_URL ?>/auth/login"><button class="btn login">Login</button></a>
        <a href="<?= BASE_URL ?>/auth/register"><button class="btn">Register</button></a>
        <div class="menu-item" id="menu-item">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </div>
      <script src="<?= BASE_URL ?>/js/main.js"></script>
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
  </div>
</main>

<div class="background-image">
    <img src="<?= BASE_URL ?>/images/dragon.png">
</div>


</body>
 