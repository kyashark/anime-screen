<html>

<head>
  <title>Zenith</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css" />
</head>

<body>

  <!-- header -->
  <header>
    <nav>
        <ul class="nav-bar" id="nav-bar">
          <li><a href="#">Home</a></li>
          <li><a href="#">Movies</a></li>
          <li><a href="#">Series</a></li>
        </ul>
    
      <div class="right-nav">
        <a href="<?= BASE_URL ?>/auth/login"><button class="btn login">Login</button></a>
        <a href="<?= BASE_URL ?>/auth/register"><button class="btn register">Register</button></a>
        
        <div class="menu-item" id="menu-item">
          <span></span>
          <span></span>
          <span></span>
        </div>
        
      </div>
    </nav>
  </header>
