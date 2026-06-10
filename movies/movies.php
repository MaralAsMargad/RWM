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
                <h2 class="movie-title"> <?= htmlspecialchars($movie['title']) ?> </h2>

                <?php if (!empty($movie['image'])): ?>
                    <img src="/rwm/uploads/<?= htmlspecialchars($movie['image']) ?>" alt="Movie Cover Image" class="movie-img">
                <?php else: ?>
                    <img src="/rwm/uploads/no-image.png" alt="No Image" class="movie-img">
                <?php endif; ?>

                <div class="movie-info-row">
                    <span class="label">Genre:</span>
                    <span class="value"><?= htmlspecialchars($movie['genre']) ?></span>
                </div>

                <div class="movie-info-row">
                    <span class="label">Year:</span>
                    <span class="value"><?= htmlspecialchars($movie['release_year']) ?></span>
                </div>

                <div class="movie-info-row">
                    <span class="label">Summary:</span>
                    <span class="value"><?= htmlspecialchars(substr($movie['summary'], 0, 80)) ?>...</span>
                </div>
                <!-- <p> <strong>Rating:</strong> <?= htmlspecialchars($movie['rating']) ?>/10 </p> -->
                <br>
                <div class="movie-action-btn">
                    <button class="view-movie-btn"
                        onclick="location.href='view_movie.php?id=<?= $movie['id'] ?>'">View</button>
                    <!-- <button class="delete-movie-btn" onclick="location.href='delete_movie.php?id=<?= $movie['id'] ?>'">Delete</button> -->
                    <button class="edit-movie-btn"
                        onclick="location.href='edit_movie.php?id=<?= $movie['id'] ?>'">Edit</button>
                    <button class="rate-movie-btn"
                        onclick="location.href='add_rating.php?id=<?= $movie['id'] ?>'">Rate</button>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>