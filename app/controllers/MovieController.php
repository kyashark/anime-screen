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

   

    public function movieProfile($movieId){
    
        $movie = $this->movieModel->getMovie($movieId);

        if($movie){
        $username = Session::get('username');
        $this->view('user/movieProfile', ['username' => $username, 'movie' => $movie]);
    } else {
        echo "Movie not found!";
    }

    }

    public function addMovie(){
    Middleware::hasRole('admin'); 

    $username = Session::get('username');
    $this->view('admin/addMovie', ['username' => $username]);
}


public function storeMovie() {
    Middleware::hasRole('admin');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['movie-name'];
        $type = $_POST['movie-type'];
        $releaseDate = $_POST['release-date'];
        $description = $_POST['movie-details'];
        $genres = $_POST['genres'] ?? [];
         $image = $_FILES['image-cover'];

// Validate and move uploaded image
       $image = $_FILES['image-cover'];
$imageName = basename($image['name']); // ✅ This is the correct value to store
$targetPath = __DIR__ . '/../../public/images/' . $imageName;

if (move_uploaded_file($image['tmp_name'], $targetPath)) {
    $success = $this->movieModel->insertMovie($name, $type, $releaseDate, $description, $imageName, $genres);

        if ($success) {
            header('Location: ' . BASE_URL . '/movie/filter');
            exit;
        } else {
            echo "❌ Failed to add movie.";
        }
    } else {
        echo "Invalid Request";
    }
}
}



    
}