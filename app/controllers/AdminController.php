<?php
require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class AdminController extends Controller {
    private $movieModel;

    public function __construct() {
        $this->movieModel = $this->model('Movie'); // Assuming 'Movie' is your model name
    }


    public function index(){
        $this->view('index');
    }
    public function dashboard() {
        Session::start();
        $username = Session::get('username');
        $is_admin = (int) Session::get('is_admin');

        // Only allow access if the user is an admin
        if (!$is_admin) {
            echo "Access Denied!";
            exit;
        }

        $this->view('admin/dashboard', [
            'username' => $username,
            'is_admin' => $is_admin
        ]);
    }

    public function movieManagement() {
        Middleware::requireAdmin();
        $username = Session::get('username');

        $movies = $this->movieModel->getMovies();

    if (!empty($movies)) { 
        $username = Session::get('username');
        $this->view('admin/movieManagement', ['username' => $username, 'movies' => $movies]);
    } else {
        echo "No movies found!";
    }

        $this->view('admin/movieManagement', ['username' => $username, 'movies' => $movies]);
    }

    public function userManagement() {
        Session::start();
        $username = Session::get('username');
        $is_admin = (int) Session::get('is_admin');

        if (!$is_admin) {
            echo "Access Denied!";
            exit;
        }

        $this->view('admin/userManagement', ['username' => $username]);
    }

    public function addMovie(){
        Session::start();
        $username = Session::get('username');

        $this->view('admin/addMovie', ['username' => $username]);
    }
}