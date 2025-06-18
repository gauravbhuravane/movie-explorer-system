<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $imdb_id = $_POST['imdb_id'];
    $title   = $_POST['title'];
    $poster  = $_POST['poster'];
    $year    = $_POST['year'];

    // Check if movie is already in favorites
    $check = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND imdb_id = ?");
    $check->bind_param("is", $user_id, $imdb_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        // Not in favorites, insert it
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, imdb_id, title, poster, year) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $imdb_id, $title, $poster, $year);
        $stmt->execute();
        
        // Redirect with status 'added'
        header("Location: movie.php?imdbID=$imdb_id&status=added");
    } else {
        // Already in favorites
        header("Location: movie.php?imdbID=$imdb_id&status=exists");
    }
    exit();
}
?>
