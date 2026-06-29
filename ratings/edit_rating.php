<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!$user_id) {
    die('You must be logged in.');
}

$rating_id = $_POST['rating_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$comment = trim($_POST['comment'] ?? '');

if (!$rating_id || !$rating) {
    die('Missing data.');
}

// Make sure rating belongs to logged-in user
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

$existingRating = $stmt->fetch();

if (!$existingRating) {
    die('Rating not found.');
}

$sql = "
    UPDATE ratings
    SET
        rating = :rating,
        comment = :comment
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':rating' => $rating,
    ':comment' => $comment,
    ':id' => $rating_id
]);

header(
    'Location: /rwm/movies/view_movie.php?id=' .
    $existingRating['movie_id']
);
exit;