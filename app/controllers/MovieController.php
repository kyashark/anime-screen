<?php

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";
require_once "../app/models/Favorite.php";

class movieController extends Controller{
    private $movieModel;

    public function __construct(){
        Session::Start();
        $username = Session::get('username');
 
      $this->movieModel = $this->model('Movie');
      $this->favoriteModel = $this->model('Favorite');
    }


    // SHOW MOVIES USING FILTERING


    public function filter() {
        Session::start();
        $userId = Session::get('user_id');

        require_once '../app/models/Favorite.php';
        $favoriteModel = new Favorite();

        $search = $_GET['query'] ?? '';
        $type = $_GET['type'] ?? '';
        $sort = $_GET['sort'] ?? 'random';
        $genres = isset($_GET['genres']) ? explode(',', $_GET['genres']) : [];

        $movies = $this->movieModel->getMovies($type, $sort, $genres, $search);

        foreach ($movies as &$movie) {
            $movie['isFavorited'] = $userId ? $favoriteModel->isFavorited($userId, $movie['id']) : false;
            $movie['movie_votes'] = $favoriteModel->getVotesFromMovieTable($movie['id']);
        }

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode($movies);
            exit;
        } else {
            $username = Session::get('username');

            if (Middleware::hasRole('admin')) {
                $this->view('admin/movieManagement', ['username' => $username, 'movies' => $movies]);
            } else {
                $this->view('user/movie', ['username' => $username, 'movies' => $movies]);
            }
        }
    }




    public function create(){
    Middleware::hasRole('admin'); 

    $username = Session::get('username');
    $this->view('admin/movieForm', ['username' => $username]);
    }

  
    // STORE MOVIE

    public function store() {
    $username = Session::get('username'); 
    Middleware::hasRole('admin');

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get input values safely
        $name = trim($_POST['movie-name'] ?? '');
        $type = trim($_POST['movie-type'] ?? '');
        $releaseDate = $_POST['release-date'] ?? '';
        $description = trim($_POST['movie-details'] ?? '');
        $genres = $_POST['genres'] ?? [];
        $image = $_FILES['image-cover'] ?? null;
        $backgroundImage = $_FILES['image-background'] ?? null;
        $author = trim($_POST['author'] ?? '');

        // Validate name
        if (empty($name)) {
            $errors['movie-name-error'] = "Movie name is required";
        }

        // Validate type
        if (empty($type)) {
            $errors['movie-type-error'] = "Movie type is required";
        }

        // Validate release date
        if (empty($releaseDate)) {
            $errors['release-date-error'] = "Release date is required";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $releaseDate)) {
            $errors['release-date-error'] = "Invalid date format (YYYY-MM-DD)";
        }

        // Validate description
        if (empty($description)) {
            $errors['movie-details-error'] = "Movie description is required";
        } elseif (str_word_count($description) > 100) {
            $errors['movie-details-error'] = "Movie description must not exceed 100 words";
        }

        // Validate image
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            $errors['image-error'] = "Image upload failed";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($image['type'], $allowedTypes)) {
                $errors['image-error'] = "Only JPG and PNG images are allowed";
            }

            if ($image['size'] > 2 * 1024 * 1024) {
                $errors['image-error'] = "Image must be less than 2MB";
            }
        }

        // Validate background image cover
        if (!$backgroundImage || $backgroundImage['error'] !== UPLOAD_ERR_OK) {
            $errors['bg-image-error'] = "Background image upload failed";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($backgroundImage['type'], $allowedTypes)) {
            $errors['bg-image-error'] = "Only JPG and PNG images are allowed for background";
        }   
        if ($backgroundImage['size'] > 2 * 1024 * 1024) {
        $errors['bg-image-error'] = "Background image must be less than 2MB";
        }
        }

        // Validate author
        if (empty($author)) {
            $errors['author-error'] = "Author name is required";
        }

        // Check if no errors
        if (empty($errors)) {
            $imageName = basename($image['name']);
            $targetPath = __DIR__ . '/../../public/images/cover/' . $imageName;

            $bgImageName = basename($backgroundImage['name']);
            $bgTargetPath = __DIR__ . '/../../public/images/background/' . $bgImageName;

            if (move_uploaded_file($image['tmp_name'], $targetPath) &&
            move_uploaded_file($backgroundImage['tmp_name'], $bgTargetPath)) {

            $success = $this->movieModel->insertMovie($name, $type, $releaseDate, $description, $imageName, $genres, $bgImageName, $author);

                if ($success) {
                    header('Location: ' . BASE_URL . '/movie/filter');
                    exit;
                } else {
                    $errors['general'] = "Failed to add movie to the database";
                }
            } else {
                $errors['image-error'] = "Failed to move uploaded image";
            }
        }

        $this->view('admin/movieForm', [
        'username' => $username,

        'mode' => 'create',
        'movie' => null,

        'errors' => $errors,
        'old' => [
        'movie-name' => $name,
        'movie-type' => $type,
        'release-date' => $releaseDate,
        'movie-details' => $description,
        'genres' => $genres,
        'author' => $author
    ]
]);
    } else {
        echo "Invalid request method.";
    }
}

    // DELETE MOVIES

    public function delete() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['movie_id'] ?? null;

    if ($id) {
      // Get cover and background image filenames before deleting
      $movieImages = $this->movieModel->getImagesByMovieId($id);

      $success = $this->movieModel->deleteMovieById($id);

      if ($success && $movieImages) {
        // Delete cover image
        if (!empty($movieImages['image'])) {
          $coverPath = __DIR__ . '/../../public/images/cover/' . $movieImages['image'];
          if (file_exists($coverPath)) unlink($coverPath);
        }

        // Delete background image
        if (!empty($movieImages['background_image'])) {
          $bgPath = __DIR__ . '/../../public/images/background/' . $movieImages['background_image'];
          if (file_exists($bgPath)) unlink($bgPath);
        }
      }

      // Check if it's AJAX
      if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo $success ? "Deleted" : "Delete failed";
        exit;
      }

      // Normal request
      header("Location: " . BASE_URL . "/movie");
      exit;
    }
  }
}

    // MOVIE PROFILE
    public function movieProfile($movieId) {
    Session::start();
    $userId = Session::get('user_id');

    $movie = $this->movieModel->getMovie($movieId);

    if ($movie) {
        $username = Session::get('username');

        // Load Watchlist model to check if movie is in user's watchlist
        require_once '../app/models/Watchlist.php';
        $watchlistModel = new Watchlist();

        $movie['isInWatchlist'] = false;
        if ($userId) {
            $movie['isInWatchlist'] = $watchlistModel->isInWatchlist($userId, $movieId);
        
            // Load Favorite model
            require_once '../app/models/Favorite.php';
            $favoriteModel = new Favorite();

            // Add favorited status and vote count
            $movie['isFavorited'] = $favoriteModel->isFavorited($userId, $movieId);
            $movie['movie_votes'] = $favoriteModel->getVotesFromMovieTable($movieId);
        } else {
            // Set default values if not logged in
            $movie['isFavorited'] = false;
            $movie['movie_votes'] = $this->favoriteModel->getVotesFromMovieTable($movieId);
        }

        $this->view('user/movieProfile', [
            'username' => $username,
            'movie' => $movie
        ]);
    } else {
        echo "Movie not found!";
    }
}



    // Movie details show for edit
    public function edit($id) {
    Middleware::hasRole('admin');
    $movie = $this->movieModel->getMovie($id);
    $username = Session::get('username');

        if ($movie) {
            $this->view('admin/movieForm', [
                        'movie' => $movie,
                        'username' => $username,
                        'mode' => 'update' 
        ]);
        } else {
            echo "Movie not found.";
        }
    }


    // MOVIE UPDATE
   public function update() {
    Middleware::hasRole('admin');
    $username = Session::get('username');

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['movie_id'];
        $name = trim($_POST['movie-name'] ?? '');
        $type = trim($_POST['movie-type'] ?? '');
        $releaseDate = $_POST['release-date'] ?? '';
        $description = trim($_POST['movie-details'] ?? '');
        $author = trim($_POST['author'] ?? '');

        $image = $_FILES['image-cover'] ?? null;
        $bgImage = $_FILES['image-background'] ?? null;

        // Fetch existing image names
        $existing = $this->movieModel->getMovie($id);
        $imageName = $existing['image'];
        $bgImageName = $existing['background_image'];

        // Validate name
        if (empty($name)) {
            $errors['movie-name-error'] = "Movie name is required";
        }

        // Validate type
        if (empty($type)) {
            $errors['movie-type-error'] = "Movie type is required";
        }

        // Validate release date
        if (empty($releaseDate)) {
            $errors['release-date-error'] = "Release date is required";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $releaseDate)) {
            $errors['release-date-error'] = "Invalid date format (YYYY-MM-DD)";
        }

        // Validate description
        if (empty($description)) {
            $errors['movie-details-error'] = "Movie description is required";
        } elseif (str_word_count($description) > 100) {
            $errors['movie-details-error'] = "Movie description must not exceed 100 words";
        }

        // Validate author
        if (empty($author)) {
            $errors['author-error'] = "Author name is required";
        }

        // Validate new image if uploaded
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($image['type'], $allowedTypes)) {
                $errors['image-error'] = "Only JPG and PNG images are allowed";
            }
            if ($image['size'] > 2 * 1024 * 1024) {
                $errors['image-error'] = "Image must be less than 2MB";
            }
        }

        // Validate new background image if uploaded
        if ($bgImage && $bgImage['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($bgImage['type'], $allowedTypes)) {
                $errors['bg-image-error'] = "Only JPG and PNG images are allowed for background";
            }
            if ($bgImage['size'] > 2 * 1024 * 1024) {
                $errors['bg-image-error'] = "Background image must be less than 2MB";
            }
        }

        // If no validation errors
        if (empty($errors)) {
            // Replace cover image if new one uploaded
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $oldPath = __DIR__ . '/../../public/images/cover/' . $existing['image'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }

                $imageName = basename($image['name']);
                $target = __DIR__ . '/../../public/images/cover/' . $imageName;
                move_uploaded_file($image['tmp_name'], $target);
            }

            // Replace background image if new one uploaded
            if ($bgImage && $bgImage['error'] === UPLOAD_ERR_OK) {
                $oldBgPath = __DIR__ . '/../../public/images/background/' . $existing['background_image'];
                if (file_exists($oldBgPath)) {
                    unlink($oldBgPath);
                }

                $bgImageName = basename($bgImage['name']);
                $bgTarget = __DIR__ . '/../../public/images/background/' . $bgImageName;
                move_uploaded_file($bgImage['tmp_name'], $bgTarget);
            }

            $success = $this->movieModel->updateMovie($id, $name, $type, $releaseDate, $description, $author, $imageName, $bgImageName);

            if ($success) {
                header("Location: " . BASE_URL . "/movie/movieProfile/$id");
                exit;
            } else {
                $errors['general'] = "Failed to update movie in the database";
            }
        }

        // If there are errors, return back to the form
        $this->view('admin/movieForm', [
            'username' => $username,
            'mode' => 'update',
            'movie' => [
                'id' => $id,
                'movie_name' => $name,
                'type' => $type,
                'release_date' => $releaseDate,
                'description' => $description,
                'author' => $author,
                'image' => $imageName,
                'background_image' => $bgImageName
            ],
            'errors' => $errors,
            'old' => []
        ]);
    } else {
        echo "Invalid request method.";
    }
}

    
}