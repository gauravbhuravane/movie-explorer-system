<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    if ($new !== $confirm) {
        $error = "New password and confirmation do not match.";
    } else {
        // Get current password hash
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_pass);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($current, $db_pass)) {
            $error = "Current password is incorrect.";
        } else {
            // Update new password
            $new_hashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $new_hashed, $user_id);
            if ($update->execute()) {
                $success = "Password changed successfully!";
            } else {
                $error = "Error updating password.";
            }
            $update->close();
        }
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="container mt-5">
  <h3>🔒 Change Password</h3>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="w-50 mx-auto">
    <div class="mb-3">
      <label for="current" class="form-label">Current Password</label>
      <input type="password" name="current_password" id="current" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="new" class="form-label">New Password</label>
      <input type="password" name="new_password" id="new" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="confirm" class="form-label">Confirm New Password</label>
      <input type="password" name="confirm_password" id="confirm" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Password</button>
  </form>
</div>

<?php include('includes/footer.php'); ?>
