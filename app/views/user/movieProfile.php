<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith</title>
</head>
<body>
    <p><?php echo $movie['movie_name'];  ?></p>
    <p><?php echo date('Y', strtotime($movie['release_date'])) ;?></p>
    <p><?php echo $movie['genres']; ?></p>
    <p><?php echo $movie['description'];?></p>
    <p><?php echo $movie['image'];?></p>
    <p><?php echo $movie['movie_votes'];?></p>    
</body>
</html>


