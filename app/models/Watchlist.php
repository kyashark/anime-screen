<?php

class Watchlist {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function isInWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch() ? true : false;
    }

    public function addToWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO watchlist (user_id, movie_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $movieId]);
    }

    public function removeFromWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?");
        return $stmt->execute([$userId, $movieId]);
    }
public function getUserWatchlist($userId) {
    $stmt = $this->db->prepare("
        SELECT 
            m.id,
            m.movie_name,
            m.release_date,
            m.movie_votes,
            m.image,
            m.type,
            m.background_image,
            m.author,
            GROUP_CONCAT(g.genre_name SEPARATOR ',') AS genres
        FROM movies m
        JOIN watchlist w ON m.id = w.movie_id
        LEFT JOIN movie_genres mg ON m.id = mg.movie_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        WHERE w.user_id = ?
        GROUP BY m.id
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
