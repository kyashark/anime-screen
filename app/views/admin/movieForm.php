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
    <form class="movie-form-grid" method="POST" action="<?= BASE_URL ?>/movie/store" enctype="multipart/form-data" id="movie-form">

        <!-- Movie Name -->
        <div>
            <label for="movie-name">Movie Name</label>
            <input type="text" id="movie-name" name="movie-name" required
                value="<?= htmlspecialchars($old['movie-name'] ?? '') ?>">
            <span class="error-msg" id='movie-name-error'>
                <?= htmlspecialchars($errors['movie-name-error'] ?? '') ?>
            </span>
        </div>

        <!-- Movie Type -->
        <div>
            <label for="movie-type">Movie Type</label>
            <select id="movie-type" name="movie-type" required>
                <option value="">Select Type</option>
                <option value="Movie" <?= (isset($old['movie-type']) && $old['movie-type'] === 'Movie') ? 'selected' : '' ?>>Movie</option>
                <option value="Series" <?= (isset($old['movie-type']) && $old['movie-type'] === 'Series') ? 'selected' : '' ?>>Series</option>
            </select>
            <span class="error-msg" id='movie-type-error'>
                <?= htmlspecialchars($errors['movie-type-error'] ?? '') ?>
            </span>
        </div>

        <!-- Release Date -->
        <div>
            <label for="release-date">Release Date</label>
            <input type="date" id="release-date" name="release-date" required
                value="<?= htmlspecialchars($old['release-date'] ?? '') ?>">
            <span class="error-msg" id=release-date-error>
                <?= htmlspecialchars($errors['release-date-error'] ?? '') ?>
            </span>
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image-cover">Upload Image Cover</label>
            <input type="file" id="image-cover" name="image-cover" required>
            <span class="error-msg" id='image-error'>
                <?= htmlspecialchars($errors['image-error'] ?? '') ?>
            </span>
        </div>

        <!-- Movie Details -->
        <div>
            <label for="movie-details">Movie Details</label>
            <textarea id="movie-details" name="movie-details" required><?= htmlspecialchars($old['movie-details'] ?? '') ?></textarea>
            <span class="error-msg" id='movie-details-error'>
                <?= htmlspecialchars($errors['movie-details-error'] ?? '') ?>
            </span>
        </div>

        <!-- Genres -->
        <div>
            <label>Select Genres</label>
            <div class="select-grid">
                <?php
                $genreList = ['Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Romance', 'Sci-Fi', 'Thriller'];
                foreach ($genreList as $genre):
                    $isChecked = in_array($genre, $old['genres'] ?? []);
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
        <div><input type="submit" value="Submit" class="submit-btn"></div>

    </form>
</div>

<script src="<?= BASE_URL ?>/js/validation.js"></script>
</main>
