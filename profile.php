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

// Fetch current user data
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);

    if (!empty($new_username) && !empty($new_email)) {
        // Check if email already exists for another user
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $check->bind_param("si", $new_email, $user_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email is already used by another user.";
        } else {
            $update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $update->bind_param("ssi", $new_username, $new_email, $user_id);
            if ($update->execute()) {
                $success = "Profile updated successfully!";
                $username = $new_username;
                $email = $new_email;
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $update->close();
        }
        $check->close();
    } else {
        $error = "Both fields are required.";
    }
}
?>

<?php include('includes/header.php'); ?>

<style>
@keyframes gradientAnimation {
  0% {background-position: 0% 50%;}
  50% {background-position: 100% 50%;}
  100% {background-position: 0% 50%;}
}

.gradient-custom-3 {
  background: linear-gradient(-45deg, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5), rgba(132, 250, 176, 0.5));
  background-size: 400% 400%;
  animation: gradientAnimation 15s ease infinite;
}

.gradient-custom-4 {
  background: linear-gradient(-45deg, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1), rgba(132, 250, 176, 1));
  background-size: 400% 400%;
  animation: gradientAnimation 15s ease infinite;
}
</style>

<section class="vh-100 bg-image gradient-custom-3">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">My Profile</h2>

              <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
              <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
              <?php endif; ?>

              <form method="POST" class="needs-validation" novalidate>
                <div class="form-outline mb-4">
                  <input type="text" name="username" class="form-control form-control-lg" value="<?= htmlspecialchars($username) ?>" required />
                  <label class="form-label">Username</label>
                  <div class="invalid-feedback">Username is required.</div>
                </div>

                <div class="form-outline mb-4">
                  <input type="email" name="email" class="form-control form-control-lg" value="<?= htmlspecialchars($email) ?>" required />
                  <label class="form-label">Email address</label>
                  <div class="invalid-feedback">Enter a valid email.</div>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Update Profile</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">
                  <a href="change_password.php" class="fw-bold text-body"><u>Change Password</u></a>
                </p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// Bootstrap client-side validation
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?php include('includes/footer.php'); ?>
