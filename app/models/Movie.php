<?php

class Movie{
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    
    }

    // FETCH ALL MOVIES

    public function getMovies($type = null, $sort = 'random', $genres = []) {
    $query = "SELECT m.id,
                 m.movie_name,
                 m.release_date,
                 m.movie_votes,
                 m.image,
                 m.type,
                 m.background_image,
                 m.author,
                 GROUP_CONCAT(g.genre_name SEPARATOR ',') AS genres
          FROM movies m
          LEFT JOIN movie_genres mg ON m.id = mg.movie_id 
          LEFT JOIN genres g ON mg.genre_id = g.genre_id";


    $conditions = [];
    $params = [];

    // Add condition for type if provided
    if (!empty($type)) {
        $conditions[] = "m.type = :type";
        $params[':type'] = $type;
    }

    // Check for genres and use named placeholders
    if (!empty($genres)) {
        $placeholders = [];
        foreach ($genres as $index => $genre) {
            $placeholders[] = ":genre" . $index;
            $params[":genre" . $index] = $genre;
        }
        $conditions[] = "g.genre_name IN (" . implode(",", $placeholders) . ")";
    }

    if (!empty($conditions)) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $query .= " GROUP BY m.id ";

    switch ($sort) {
        case 'top':
            $query .= " ORDER BY m.movie_votes DESC";
            break;
        case 'new':
            $query .= " ORDER BY m.release_date DESC";
            break;
        case 'alpha':
            $query .= " ORDER BY m.movie_name ASC";
            break;
        default:
            $query .= " ORDER BY RAND()";
    }

    $stmt = $this->db->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // FETCH ONE MOVIE
    public function getMovie($movieId){
        $query = "SELECT m.id,
                 m.movie_name,
                 m.release_date,
                 m.movie_votes,
                 m.image,
                 m.description,
                 m.background_image,
                 m.author,
                 GROUP_CONCAT(g.genre_name SEPARATOR ' ') AS genres
          FROM movies m
          LEFT JOIN movie_genres mg ON m.id = mg.movie_id 
          LEFT JOIN genres g ON mg.genre_id = g.genre_id
          WHERE m.id = :movieId
          GROUP BY m.id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }  
    
        

  
  
    // INSERT MOVIE
public function insertMovie($name, $type, $releaseDate, $description, $image, $genres, $backgroundImage = null, $author = null)
 {
    try {
        $this->db->beginTransaction();

        // $stmt = $this->db->prepare("INSERT INTO movies (movie_name, type, release_date, description, image) VALUES (:name, :type, :release, :desc, :image)");
        // $stmt->execute([
        //     ':name' => $name,
        //     ':type' => $type,
        //     ':release' => $releaseDate,
        //     ':desc' => $description,
        //     ':image' => $image
        // ]);

        $stmt = $this->db->prepare("INSERT INTO movies 
    (movie_name, type, release_date, description, image, background_image, author) 
    VALUES (:name, :type, :release, :desc, :image, :bgImage, :author)");
$stmt->execute([
    ':name' => $name,
    ':type' => $type,
    ':release' => $releaseDate,
    ':desc' => $description,
    ':image' => $image,
    ':bgImage' => $backgroundImage,
    ':author' => $author
]);
        $movieId = $this->db->lastInsertId();

        foreach ($genres as $genreName) {
            // First get genre_id by genre name
            $stmt = $this->db->prepare("SELECT genre_id FROM genres WHERE genre_name = :name LIMIT 1");
            $stmt->execute([':name' => $genreName]);
            $genre = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($genre) {
                $genreId = $genre['genre_id'];
                $stmt = $this->db->prepare("INSERT INTO movie_genres (movie_id, genre_id) VALUES (:movieId, :genreId)");
                $stmt->execute([
                    ':movieId' => $movieId,
                    ':genreId' => $genreId
                ]);
            }
        }

        $this->db->commit();
        return true;
    } catch (PDOException $e) {
        $this->db->rollBack();
         echo "DB Error: " . $e->getMessage(); 
        return false;
    }
}

// GET MOVIE IMAGE NAME
public function getImagesByMovieId($movieId) {
    $stmt = $this->db->prepare("SELECT image, background_image FROM movies WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $movieId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
}


// DELETE MOVIE
public function deleteMovieById($movieId) {
    try {
        $this->db->beginTransaction();

        // Delete from movie_genres first (foreign key constraint)
        $stmt = $this->db->prepare("DELETE FROM movie_genres WHERE movie_id = :id");
        $stmt->execute([':id' => $movieId]);

        // Delete the movie record
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id = :id");
        $stmt->execute([':id' => $movieId]);

        $this->db->commit();
        return true;
    } catch (PDOException $e) {
        $this->db->rollBack();
        error_log($e->getMessage());
        return false;
    }
}

// 

}

/*
SELECT m.movie_name, m.release_date, m.movie_votes, m.image 
FROM movies m 
LEFT JOIN movie_genres mg ON m.id = mg.movie_id 
LEFT JOIN genres g ON mg.genre_id = g.genre_id
WHERE m.type = 'movie' 
AND g.genre_name IN (:genre0, :genre1)
ORDER BY m.release_date DESC
*/