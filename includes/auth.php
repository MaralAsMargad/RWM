<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
?>