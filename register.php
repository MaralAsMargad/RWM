<?php

require 'includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if username/email already exists
    $sql = "
        SELECT id
        FROM users
        WHERE username = :username
        OR email = :email
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':username' => $username,
        ':email' => $email
    ]);

    if ($stmt->fetch()) {
        $errors[] = "Username or email already exists.";
    }

    if (empty($errors)) {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO users
            (username, email, hashed_password)
            VALUES
            (:username, :email, :hashed_password)
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':hashed_password' => $hashedPassword
        ]);

        header("Location: login.php");
        exit;
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
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">

            <?php foreach ($errors as $error): ?>
                <p>
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <h1>Register</h1>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Register</button>
    </form>

</body>

</html>