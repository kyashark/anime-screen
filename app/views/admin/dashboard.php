<html>

<head>
  <title>Anime Screen</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
<header>
    <h2>Dashboard</h2>

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
    <div class="admin-grid-container">
        <div></div>
        <a href="<?= BASE_URL ?>/movie/filter?type=movie&sort=random">
          <h3>Movie Management</h3>
        </a>
        <a href="<?= BASE_URL ?>/movie/filter?type=series&sort=random">
            <h3>Series Management</h3>
        </a>
        <div></div>
        <div></div>
    </div>
</main>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>