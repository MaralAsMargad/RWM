<?php
session_start();

$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
?>