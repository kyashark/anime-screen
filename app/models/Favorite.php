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

    public function getFavoriteMovies($userId) {
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
        JOIN favorites f ON m.id = f.movie_id
        LEFT JOIN movie_genres mg ON m.id = mg.movie_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        WHERE f.user_id = ?
        GROUP BY m.id
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
