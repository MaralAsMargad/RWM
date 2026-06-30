<?php
require '../includes/auth.php';
require '../includes/db.php';

if ($role !== 'admin') {
    die('Access denied.');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $release_year = trim($_POST['release_year']);
    $genre = ($_POST['genre'] ?? []); // if genre is not set, use an empty array
    $summary = trim($_POST['summary']);

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $imageName = null;

    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] === 0
    ) {

        $imageName = time() . '_' . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/" . $imageName
        );
    }

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

    // INSERT MOVIE
    if (empty($errors)) {
        $genreString = implode(',', $genre);
        $sql = "
            INSERT INTO movies
            (title, image, genre, release_year, summary)
            VALUES
            (:title, :image, :genre, :release_year, :summary)
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':title' => $title,
            ':image' => $imageName,
            ':genre' => $genreString,
            ':release_year' => $release_year,
            ':summary' => $summary
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
    <title>Create Movie</title>
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

        <form action="create_movie.php" method="post" enctype="multipart/form-data" class="form-create">    <!-- without enctype PHP cannot receive uploaded files -->
            <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
            <h1 class="header-title">Create Movie</h1>
            <div class="form-group">
                <label for="title">Image</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="number" id="release_year" name="release_year" required>
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <div id="genre-container">
                    <div class="genre-row">
                        <select name="genre[]" required> <!-- this tells PHP to receive an array -->
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

                        <button type="button" onclick="addGenre()">+</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="summary">Summary</label>
                <textarea id="summary" name="summary" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>

</body>

</html>