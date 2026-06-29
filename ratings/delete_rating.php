<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!$user_id) {
    die('You must be logged in.');
}

$rating_id = $_POST['rating_id'] ?? null;

$sql = "
    SELECT *
    FROM ratings
    WHERE id = :id
    AND user_id = :user_id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $rating_id,
    ':user_id' => $user_id
]);

$rating = $stmt->fetch();

if (!$rating) {
    die('Rating not found.');
}

$sql = "
    DELETE FROM ratings
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $rating_id
]);

header(
    'Location: /rwm/movies/view_movie.php?id=' .
    $rating['movie_id']
);
exit;