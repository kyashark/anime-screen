<?php

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class movieController extends Controller{
    private $movieModel;

    public function __construct(){
        Session::Start();
        $username = Session::get('username');
 
      $this->movieModel = $this->model('Movie');
    }


    // SHOW MOVIES USING FILTERING

    public function filter() {
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'random';
    $genres = isset($_GET['genres']) ? explode(',', $_GET['genres']) : [];

    $movies = $this->movieModel->getMovies($type, $sort, $genres);

    // Check if the request is an AJAX call
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    if ($isAjax) {
        // Return JSON response for AJAX
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

        // Check if no errors
        if (empty($errors)) {
            $imageName = basename($image['name']);
            $targetPath = __DIR__ . '/../../public/upload/' . $imageName;

            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $success = $this->movieModel->insertMovie($name, $type, $releaseDate, $description, $imageName, $genres);

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
        'errors' => $errors,
        'old' => [
        'movie-name' => $name,
        'movie-type' => $type,
        'release-date' => $releaseDate,
        'movie-details' => $description,
        'genres' => $genres
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

            // Get image filename before deleting
            $imageName = $this->movieModel->getImageByMovieId($id);

            $success = $this->movieModel->deleteMovieById($id);

            if ($success && $imageName) {
            $imagePath = __DIR__ . '/../../public/upload/' . $imageName;
            if (file_exists($imagePath)) {
                    unlink($imagePath);  // Delete the image file
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

    // SHOW MOVIE PROFILE

  public function movieProfile($movieId){
        $movie = $this->movieModel->getMovie($movieId);

        if($movie){
            $username = Session::get('username');
            $this->view('user/movieProfile', ['username' => $username, 'movie' => $movie]);
        } else {
            echo "Movie not found!";
    }

    }

    
}