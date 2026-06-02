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
        <button class="create-movie-btn" onclick="location.href='create_movie.php'">+ Add Movie</button>
    </div>
    <div class="movie-container">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <h2> <?= htmlspecialchars($movie['title']) ?> </h2>
                <img src="" alt="Movie Cover Image">
                <p> <strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?> </p>
                <p> <strong>Year:</strong> <?= htmlspecialchars($movie['release_year']) ?> </p>
                <p> <?= htmlspecialchars($movie['summary']) ?> </p>
                <p> <strong>Rating:</strong> <?= htmlspecialchars($movie['rating']) ?>/10 </p>
                <p> <strong>Review:</strong> <?= htmlspecialchars($movie['review']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>