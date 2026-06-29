<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!$user_id) {
    die('You must be logged in.');
}

$movie_id = $_POST['movie_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$comment = trim($_POST['comment'] ?? '');

$sql = "
INSERT INTO ratings
(user_id, movie_id, rating, comment)
VALUES
(:user_id, :movie_id, :rating, :comment)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':user_id' => $user_id,
    ':movie_id' => $movie_id,
    ':rating' => $rating,
    ':comment' => $comment
]);

header('Location: /rwm/movies/movies.php');
exit;