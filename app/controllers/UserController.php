<?php 

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";
require_once "../app/models/Watchlist.php";
require_once "../app/models/Favorite.php";

class UserController extends Controller {

     private $watchlistModel;
     private $favoriteModel;

    public function __construct() {
    Session::start();
    $this->watchlistModel = $this->model('Watchlist');
    $this->favoriteModel = $this->model('Favorite');
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



    // DISPLAY WATCHLIST MOVIES

    public function watchlist() {
        $userId = Session::get('user_id');
        if (!$userId) {
            header('Location: ' . BASE_URL . '/user/home');
            exit;
        }

        $watchlist = $this->watchlistModel->getUserWatchlist($userId);

        foreach ($watchlist as &$movie) {
            $movie['isInWatchlist'] = $this->watchlistModel->isInWatchlist($userId, $movie['id']);
            $movie['isFavorited'] = $this->favoriteModel->isFavorited($userId, $movie['id']);
            $movie['movie_votes'] = $this->favoriteModel->getVotesFromMovieTable($movie['id']);
        }

        $username = Session::get('username');

        $this->view('user/watchlist', [
            'username' => $username,
            'movies' => $watchlist
        ]);
    }



    // TOGGLE WATCHLIST BUTTON
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


    // WATCHLIST STATUS UPDATE
    public function updateWatchlistStatus($id) { 
        Session::start();

        // Decode JSON input
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['status'])) {
            echo json_encode(['success' => false, 'error' => 'Missing status in request']);
            return;
        }

        $status = $data['status'];

        if (in_array($status, ['to_watch', 'watching', 'watched'])) {
            $updated = $this->watchlistModel->updateStatusByWatchlistId($id, $status);

            if ($updated) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Update failed']);
            }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid status']);
            }
    }

        // TOGGLE FAVOURITE
        public function toggleFavorite($movieId) {
            Session::start();

            if (!Session::get('user_id')) {
                http_response_code(401);
                echo json_encode(['error' => 'Not logged in']);
                return;
            }

            $userId = Session::get('user_id');

            if ($this->favoriteModel->isFavorited($userId, $movieId)) {
                $this->favoriteModel->removeFavorite($userId, $movieId);
                $status = 'removed';
            } else {
                $this->favoriteModel->addFavorite($userId, $movieId);
                $status = 'added';
            }

            $count = $this->favoriteModel->getVotesFromMovieTable($movieId);

            echo json_encode([
                'status' => $status,
                'count' => $count
            ]);
    }








}