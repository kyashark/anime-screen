<?php

class Watchlist {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getUserWatchlist($userId) {
        $query = "SELECT m.* FROM watchlists w 
                  JOIN movies m ON w.movie_id = m.id 
                  WHERE w.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToWatchlist($userId, $movieId) {
        $query = "INSERT INTO watchlists (user_id, movie_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }

    public function removeFromWatchlist($userId, $movieId) {
        $query = "DELETE FROM watchlists WHERE user_id = ? AND movie_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $movieId]);
    }
}
