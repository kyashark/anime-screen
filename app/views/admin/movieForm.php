<html>

<head>
  <title>Add Movie</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
<header>
    <a href="javascript:history.back();">
        <div class="back">
            <span></span>
            <span></span>
        </div>
    </a>
    
    <h2>Add New Movie</h2>

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
        <form class="movie-form-grid" method="POST" action="<?= BASE_URL ?>/movie/store" enctype="multipart/form-data">

        <div>
            <label for="movie-name">Movie Name</label>
            <input type="text" id="movie-name" name="movie-name" required>
        </div>
        <div>
            <label for="movie-type">Movie Type</label>
            <input type="text" id="movie-type" name="movie-type" required>
        </div>
        <div>
            <label for="release-date">Release Date</label>
            <input type="date" id="release-date" name="release-date" required>
        </div>
        <div>
            <label for="image-cover">Upload Image Cover</label>
            <input type="file" id="image-cover" name="image-cover" required>
        </div>
        <div>
            <label for="movie-details">Movie Details</label>
            <textarea id="movie-details" name="movie-details" required></textarea>
        </div>
        <div>
            <label>Select Genres</label>
            <div class="select-grid">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="genres[]" value="Action">
                        <span class="checkmark"></span>
                        <span>Action</span>
                    </label>
                    <label class="custom-checkbox">
                        <input type="checkbox" name="genres[]" value="Adventure">
                        <span class="checkmark"></span>
                        <span>Adventure</span>
                    </label>
                    <label class="custom-checkbox">
                        <input type="checkbox" name="genres[]" value="Comedy">
                        <span class="checkmark"></span>
                        <span>Comedy</span>
                    </label>
                    <label class="custom-checkbox">
                        <input type="checkbox" name="genres[]" value="Drama">
                        <span class="checkmark"></span>
                        <span>Drama</span>
                    </label>
                    <label class="custom-checkbox">
                        <input type="checkbox" name="genres[]" value="Horror">
                        <span class="checkmark"></span>
                        <span>Horror</span>
                    </label>
                   
            </div>
        </div>
        <div><input type="reset" value="Clear" class="clear-btn"></div>
        <div><input type="submit" value="Submit" class="submit-btn"></div>
        </form>
    </div>


</main>