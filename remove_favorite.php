<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$favorite_id = $_GET['id'];

$sql = "DELETE FROM favorites WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $favorite_id, $user_id);
$stmt->execute();

header("Location: favorites.php");
exit();
