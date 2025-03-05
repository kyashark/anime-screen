<html>

<head>
  <title>Zenith</title>
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
        <a href="<?= BASE_URL ?>/auth/register"><button class="btn type-2">Logout</button></a>
        
        <div class="menu-item" id="menu-item">
          <span></span>
          <span></span>
          <span></span>
        </div>
    
      </div>
     
  </header>
  

  <main>
    <div class="admin-grid">
        <div></div>
        <a href="<?= BASE_URL ?>/admin/movieManagement">
        <div>
            <h3>Movie Management</h3>
        </div>
        </a>

        <a href="<?= BASE_URL ?>/admin/userManagement">
        <div>
            <h3>User Management</h3>
        </div>
        </a>

        <div></div>
        <div></div>
    </div>
</main>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>