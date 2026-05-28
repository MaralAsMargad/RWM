<?php
require '../includes/db.php';

$sql = "select * from movies order by created_at desc";
$stmt = $pdo->query($sql);
$movies = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rwm/css/movies.css">
    <title>Movies</title>
</head>
<body>
    <?php include '../includes/nav.php'; ?>

    <div class="movie-header">
        <h1>Movies</h1>
        <a href="create_movie.php">+ Add Movie</a>
    </div>
    <div class="movie-container">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">

            </div>
        <?php endforeach;?>
    </div>
</body>
</html>