<?php
require '../includes/db.php';

$errors = [];

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Movie ID missing.");
}

// FETCH EXISTING MOVIE
$sql = "SELECT * FROM movies WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$movie = $stmt->fetch();

if (!$movie) {
    die("Movie not found.");
}

$selectedGenres = explode(',', $movie['genre']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $release_year = trim($_POST['release_year']);
    $genre = $_POST['genre'] ?? [];
    $summary = trim($_POST['summary']);

    // VALIDATION
    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($genre)) {
        $errors[] = "Genre is required.";
    }

    if (empty($release_year)) {
        $errors[] = "Release year is required.";
    }

    // UPDATE MOVIE
    if (empty($errors)) {
        $genreString = implode(',', $genre);
        $sql = "
            UPDATE  movies
            SET title = :title, genre = :genre, release_year = :release_year, summary = :summary
            WHERE id = :id
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':title' => $title,
            ':genre' => $genreString,
            ':release_year' => $release_year,
            ':summary' => $summary,
            ':id' => $id
        ]);

        header("Location: /rwm/movies/movies.php");
        exit;
    }
}
?>

<!-- Add another select underneath -->
<script>
    function addGenre() {

        const container = document.getElementById('genre-container');

        const newGenre = document.createElement('div');

        newGenre.classList.add('genre-row');

        newGenre.innerHTML = `
        <select name="genre[]" required>
            <option value="">Select Genre</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Documentary">Documentary</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Horror">Horror</option>
            <option value="Musical">Musical</option>
            <option value="Romance">Romance</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Thriller">Thriller</option>
        </select>

        <button type="button" onclick="removeGenre(this)">-</button>
    `;

        container.appendChild(newGenre);
    }

    function removeGenre(button) {
        button.parentElement.remove();
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rwm/css/crud_movies.css">
    <!-- search input from nav.css is also being changed by this -->
    <title>Edit Movie</title>
</head>

<body>
    <?php include '../includes/nav.php'; ?>

    <div class="form-container">

        <!-- ERRORS -->
        <?php if (!empty($errors)): ?>

            <div class="errors">

                <?php foreach ($errors as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <form action="edit_movie.php?id=<?= $movie['id'] ?>" method="post" enctype="multipart/form-data"
            class="form-to-edit">
            <!-- without enctype PHP cannot receive uploaded files -->
            <!-- without '?id=<?= $movie['id'] ?>' update won't know which movie to edit  -->
            <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
            <h1 class="header-title">Edit Movie</h1>
            <div class="form-group">
                <label for="title">Image</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="number" id="release_year" name="release_year"
                    value="<?= htmlspecialchars($movie['release_year']) ?>" required>
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <div id="genre-container">
                    <?php foreach ($selectedGenres as $index => $genre): ?>
                        <div class="genre-row">
                            <select name="genre[]" required> <!-- 'genre[]' this tells PHP to receive an array -->
                                <option value="">Select Genre</option>
                                <option value="Action" <?= $genre === 'Action' ? 'selected' : '' ?>>
                                    Action
                                </option>
                                <option value="Adventure" <?= $genre === 'Adventure' ? 'selected' : '' ?>>
                                    Adventure
                                </option>
                                <option value="Comedy" <?= $genre === 'Comedy' ? 'selected' : '' ?>>Comedy
                                </option>
                                <option value="Drama" <?= $genre === 'Drama' ? 'selected' : '' ?>>Drama
                                </option>
                                <option value="Documentary" <?= $genre === 'Documentary' ? 'selected' : '' ?>>Documentary
                                </option>
                                <option value="Fantasy" <?= $genre === 'Fantasy' ? 'selected' : '' ?>>Fantasy
                                </option>
                                <option value="Horror" <?= $genre === 'Horror' ? 'selected' : '' ?>>Horror
                                </option>
                                <option value="Musical" <?= $genre === 'Musical' ? 'selected' : '' ?>>Musical
                                </option>
                                <option value="Romance" <?= $genre === 'Romance'  ? 'selected' : '' ?>>Romance
                                </option>
                                <option value="Sci-Fi" <?= $genre === 'Sci-Fi' ? 'selected' : '' ?>>Sci-Fi
                                </option>
                                <option value="Thriller" <?= $genre === 'Thriller' ? 'selected' : '' ?>>
                                    Thriller
                                </option>
                            </select>
                            <button type="button" onclick="addGenre()">+</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="summary">Summary</label>
                <textarea id="summary" name="summary" required><?= htmlspecialchars($movie['summary']) ?></textarea>
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>

</body>

</html>