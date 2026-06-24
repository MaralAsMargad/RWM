<?php
session_start();

require 'includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);     // This can be either email or username
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $errors[] = "Please fill in all required fields.";
    } else {
        $sql = "
    SELECT *
    FROM users
    WHERE username = :username
    OR email = :email
";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':username' => $login,
            ':email' => $login
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['hashed_password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: /rwm/movies/movies.php");
            exit;
        } else {
            $errors[] = "Invalid login credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Log In</title>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div class="login-container">

        <!-- ERRORS -->
        <?php if (!empty($errors)): ?>

            <div class="errors">

                <?php foreach ($errors as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <form action="login.php" method="POST" enctype="multipart/form-data" class="form-login">
            <h1>Log In</h1>
            <div class="form-group">
                <label for="login">Email or Username</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Log In</button>
        </form>
    </div>
</body>

</html>