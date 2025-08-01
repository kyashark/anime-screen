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
    
    <h2><?= ($mode ?? '') === 'update' ? 'Update Movie' : 'Add New Movie' ?></h2>


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
     <form class="movie-form-grid" 
      method="POST" 
      action="<?= BASE_URL ?>/movie/<?= isset($movie) ? 'update' : 'store' ?>" 
      enctype="multipart/form-data" 
      id="movie-form">

        <!-- Movie Name -->
        <div>
            <label for="movie-name">Movie Name</label>
            <input type="text" id="movie-name" name="movie-name"  value="<?= $movie['movie_name'] ?? '' ?>" required
                value="<?= htmlspecialchars($old['movie-name'] ?? '') ?>">
            <span class="error-msg" id='movie-name-error'>
                <?= htmlspecialchars($errors['movie-name-error'] ?? '') ?>
            </span>
        </div>


        <!-- Author -->
        <div>
            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?= $movie['author'] ?? '' ?>" required
                value="<?= htmlspecialchars($old['author'] ?? '') ?>">
            <span class="error-msg" id="author-error">
                <?= htmlspecialchars($errors['author-error'] ?? '') ?>
            </span>
        </div>


        <!-- Movie Type -->
        <div>
            <label for="movie-type">Movie Type</label>
            <?php $type = $old['movie-type'] ?? $movie['type'] ?? ''; ?>
            <select id="movie-type" name="movie-type" required>
                <option value="">Select Type</option>
                <option value="Movie" <?= ($type === 'Movie') ? 'selected' : '' ?>>Movie</option>
                <option value="Series" <?= ($type === 'Series') ? 'selected' : '' ?>>Series</option>
            </select>
            <span class="error-msg" id='movie-type-error'>
                <?= htmlspecialchars($errors['movie-type-error'] ?? '') ?>
            </span>
        </div>


        <!-- Release Date -->
        <div>
            <label for="release-date">Release Date</label>
            <input type="date" id="release-date" name="release-date" value="<?= $movie['release_date'] ?? '' ?>" required
                value="<?= htmlspecialchars($old['release-date'] ?? '') ?>">
            <span class="error-msg" id=release-date-error>
                <?= htmlspecialchars($errors['release-date-error'] ?? '') ?>
            </span>
            <div class="image-preview" id="background-preview"> </div>
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image-cover">Upload Image Cover</label>
            <input type="file" id="image-cover" name="image-cover">
            <span class="error-msg" id='image-error'>
                <?= htmlspecialchars($errors['image-error'] ?? '') ?>
            </span>
            
            <div class="image-preview" id="cover-preview"></div>
        </div>

        <!-- Background Image Upload -->
        <div>
            <label for="image-background">Upload Background Image</label>
            <input type="file" id="image-background" name="image-background">

            <span class="error-msg" id='bg-image-error'>
                <?= htmlspecialchars($errors['bg-image-error'] ?? '') ?>
            </span>
            <div class="image-preview"></div>
        </div>

        <!-- Movie Details -->
        <div>
            <label for="movie-details">Movie Details</label>
            <textarea id="movie-details" name="movie-details" required><?= htmlspecialchars($old['movie-details'] ?? '') ?><?= $movie['description'] ?? '' ?></textarea>
            <span class="error-msg" id='movie-details-error'>
                <?= htmlspecialchars($errors['movie-details-error'] ?? '') ?>
            </span>
        </div>

        <!-- Genres -->
        <div>
        <label>Select Genres</label>
            <div class="select-grid">
                <?php
                    $selectedGenres = explode(' ', $movie['genres'] ?? '');
                    $genreList = ['Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Romance', 'Sci-Fi', 'Thriller'];
                    foreach ($genreList as $genre):
                        $isChecked = in_array($genre, $old['genres'] ?? $selectedGenres);
                    ?>
                        <label class="custom-checkbox">
                            <input type="checkbox" name="genres[]" value="<?= $genre ?>" <?= $isChecked ? 'checked' : '' ?>>
                            <span class="checkmark"></span>
                            <span><?= $genre ?></span>
                        </label>
                <?php endforeach; ?>
            </div>  
        </div>

        <!-- Buttons -->
        <div><input type="reset" value="Clear" class="clear-btn"></div>
        <div><input type="submit" value="<?= isset($movie) ? 'Update' : 'Submit' ?>" class="submit-btn"></div>
        <!-- This is for update -->
        <?php if (isset($movie)): ?>
        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
        <?php endif; ?>
    </form>

<script src="<?= BASE_URL ?>/js/validation.js"></script>


</main>
