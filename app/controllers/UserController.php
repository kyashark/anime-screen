<?php 

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";
require_once "../app/models/Watchlist.php";

class UserController extends Controller {

     private $watchlistModel;

    public function __construct() {
    Session::start();
    // $this->watchlistModel = new Watchlist();
    $this->watchlistModel = $this->model('Watchlist');
}


    public function home() {
        Session::start();
        $username = Session::get('username');
        $this->view('user/home', ['username' => $username]);
    }
    
    public function index() {
        Middleware::redirectIfLoggedIn();
        $this->view('index');
    }


    public function toggleWatchlist($id) {
        Session::start();
        header('Content-Type: application/json'); 

        $userId = Session::get('user_id');
        if (!$userId || !$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }

        $isInList = $this->watchlistModel->isInWatchlist($userId, $id);

        if ($isInList) {
            $this->watchlistModel->removeFromWatchlist($userId, $id);
            echo json_encode(['status' => 'removed']);
        } else {
            $this->watchlistModel->addToWatchlist($userId, $id);
            echo json_encode(['status' => 'added']);
        }

    
        exit;
    }

public function watchlist() {
    Session::start();
    $userId = Session::get('user_id');

    if (!$userId) {
        header('Location: ' . BASE_URL . '/user/home');
        exit;
    }

    $watchlist = $this->watchlistModel->getUserWatchlist($userId);

        // Add isInWatchlist key to each movie
    foreach ($watchlist as &$movie) {
        $movie['isInWatchlist'] = $this->watchlistModel->isInWatchlist($userId, $movie['id']);
    }


    $username = Session::get('username');

    $this->view('user/watchlist', [
        'username' => $username,
        'movies' => $watchlist
    ]);
}
}