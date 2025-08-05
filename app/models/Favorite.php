<?php

class Favorite {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function isFavorited($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->rowCount() > 0;
    }

    public function addFavorite($userId, $movieId) {
        $stmt = $this->db->prepare("INSERT INTO favorites (user_id, movie_id) VALUES (?, ?)");
        $stmt->execute([$userId, $movieId]);

        $voteStmt = $this->db->prepare("UPDATE movies SET movie_votes = movie_votes + 1 WHERE id = ?");
        $voteStmt->execute([$movieId]);
    }


    public function removeFavorite($userId, $movieId) {
        $stmt = $this->db->prepare("DELETE FROM favorites WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);

        $voteStmt = $this->db->prepare("UPDATE movies SET movie_votes = movie_votes - 1 WHERE id = ? AND movie_votes > 0");
        $voteStmt->execute([$movieId]);
    }


    public function getVotesFromMovieTable($movieId) {
        $stmt = $this->db->prepare("SELECT movie_votes FROM movies WHERE id = ?");
        $stmt->execute([$movieId]);
        $row = $stmt->fetch();
        return $row ? (int)$row['movie_votes'] : 0;
    }
}
