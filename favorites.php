<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM favorites WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">❤️ Your Favorite Movies</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card h-100">
            <img src="<?= $row['poster'] !== 'N/A' ? $row['poster'] : 'https://via.placeholder.com/300x445?text=No+Image' ?>" class="card-img-top" alt="<?= $row['title'] ?> Poster">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= $row['title'] ?></h5>
              <p class="card-text">Year: <?= $row['year'] ?></p>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <a href="movie.php?imdbID=<?= $row['imdb_id'] ?>" class="btn btn-sm btn-primary">View</a>
                <a href="remove_favorite.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to remove this movie from favorites?')">
                  🗑️
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-muted">You haven’t saved any favorites yet.</p>
  <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
