<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Movie Explorer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css"> <!-- Optional custom styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
  .nav-hover {
    position: relative;
    transition: color 0.3s ease;
  }

  .nav-hover::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 2px;
    display: block;
    margin-top: 5px;
    right: 0;
    background: #0dcaf0;
    transition: width 0.4s ease;
    -webkit-transition: width 0.4s ease;
  }

  .nav-hover:hover::after {
    width: 100%;
    left: 0;
    background: #0dcaf0;
  }

  .navbar-brand {
    letter-spacing: 1px;
  }

  .navbar {
    border-bottom: 2px solid rgba(255,255,255,0.1);
  }

  .badge {
    background: linear-gradient(45deg, #0dcaf0, #0d6efd);
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg fixed-top" style="background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(10px);">
  <div class="container">
    <a class="navbar-brand fs-3 fw-bold text-info animate__animated animate__fadeInLeft" href="index.php">🎬 Movie Explorer</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse animate__animated animate__fadeInRight" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center gap-3">
        <?php if (isset($_SESSION['user_id'])): 
          include_once('includes/db.php');
          $uid = $_SESSION['user_id'];
          $result = $conn->query("SELECT username FROM users WHERE id = $uid");
          $user = $result->fetch_assoc();
        ?>
          <li class="nav-item">
            <span class="badge bg-info text-dark fs-6 p-2">👋 Hello, <?= htmlspecialchars($user['username']) ?>!</span>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-hover text-white fw-semibold" href="favorites.php">❤️ Favorites</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-hover text-white fw-semibold" href="logout.php">🚪 Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link nav-hover text-white fw-semibold" href="register.php">📝 Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-hover text-white fw-semibold" href="login.php">🔑 Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-hover text-white fw-semibold" href="profile.php">🙍‍♂️ Profile</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>