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

    // public function filter(){
    //     $type = isset($_GET['type']) ? $_GET['type']:'';

    //     $sort = isset($_GET['sort']) ? $_GET['sort'] : 'random';
    //     $genres = isset($_GET['genres']) ? explode(',', $_GET['genres']) : [];
        
    //     $movies = $this->movieModel->getMovies($type,$sort, $genres);

    //     // Check if the request is an AJAX call
    //     $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    //     // Check if the request is an AJAX call
    //     if ($isAjax) {
    //         // Return JSON response for AJAX
    //         header('Content-Type: application/json');
    //         echo json_encode($movies);
    //         exit;
    //     } else {
    //         // Render movies for non-AJAX requests
    //         $username = Session::get('username');
    //         $this->view('user/movie', ['username' => $username, 'movies' => $movies]); 
    //     }
    // }

    // public function filter() {
    //     $type = isset($_GET['type']) ? $_GET['type'] : '';
    //     $sort = isset($_GET['sort']) ? $_GET['sort'] : 'random';
    //     $genres = isset($_GET['genres']) ? explode(',', $_GET['genres']) : [];
        
    //     $movies = $this->movieModel->getMovies($type, $sort, $genres);
    
    //     // Check if the request is an AJAX call
    //     $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    
    //     if ($isAjax) {
    //         // Return JSON response for AJAX
    //         header('Content-Type: application/json');
    //         echo json_encode($movies);
    //         exit;
    //     } else {
    //         // Get user details
    //         $username = Session::get('username');
    //         $isAdmin = (int) Session::get('is_admin');
    
    //         // Render appropriate view based on user role
    //         if ($isAdmin) {
    //             $this->view('admin/movieManagement', ['username' => $username, 'movies' => $movies]);
    //         } else {
    //             $this->view('user/movie', ['username' => $username, 'movies' => $movies]);
    //         }
    //     }
    // }


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
        $username = Session::get('username');

        $this->view('admin/addMovie', ['username' => $username]);
    }
    
}