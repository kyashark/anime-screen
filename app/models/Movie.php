<?php

class Movie{
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }


    // public function getMovies($type,$sort = 'random', $genres = []) {
    //     $query = "SELECT DISTINCT m.id,
    //                     m.movie_name,
    //                     m.release_date,
    //                     m.movie_votes,
    //                     m.image
    //         FROM movies m
    //         LEFT JOIN movie_genres mg ON m.id = mg.movie_id 
    //         LEFT JOIN genres g ON mg.genre_id = g.genre_id
    //         WHERE m.type =:type";
        
    //     $conditions = [];
    //     $params = [':type' => $type];

    //     // Check for genres and use named placeholders
    //     if (!empty($genres)) {
    //     // Create named placeholders like :genre1, :genre2, ...
    //     $placeholders = [];
    //     foreach ($genres as $index => $genre) {
    //         $placeholders[] = ":genre" . $index;
    //         $params[":genre" . $index] = $genre; // Bind each genre to a named placeholder
    //     }
    //     // Add condition for genre filter
    //     $conditions[] = "g.genre_name IN (" . implode(",", $placeholders) . ")";
    // }

        
    //     if (!empty($conditions)) {
    //         $query .= ' AND ' . implode(' AND ', $conditions);
    //     }


    //     // sorting condition
    //     switch ($sort) {
    //         case 'top':
    //             $query .= " ORDER BY m.movie_votes DESC";
    //             break;
    //         case 'new':
    //             $query .= " ORDER BY m.release_date DESC";
    //             break;
    //         case 'alpha':
    //             $query .= " ORDER BY m.movie_name ASC";
    //             break;
    //         default:
    //             $query .= " ORDER BY RAND()";
    //     }

    //     $stmt = $this->db->prepare($query);
    //     $stmt->execute($params);

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getMovies($type = null, $sort = 'random', $genres = []) {
        $query = "SELECT DISTINCT m.id,
                        m.movie_name,
                        m.release_date,
                        m.movie_votes,
                        m.image
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
    
        // Append conditions if any exist
        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }
    
        // Sorting condition
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
    
    // public function getAllMovies() {
    //     $stmt = $this->db->prepare("SELECT * FROM movies");
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getMovie($movieId){
        $query = "SELECT m.id,
                         m.movie_name,
                         m.release_date,
                         m.movie_votes,
                         m.image,
                         m.description,
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