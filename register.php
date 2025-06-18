<?php
include('includes/db.php');
session_start();
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Server-side validation
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $errors[] = "Email is already registered.";
    }

    // If no errors, insert new user
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        if ($stmt->execute()) {
            $success = "✅ Registration successful! You can now log in.";
        } else {
            $errors[] = "Something went wrong. Try again.";
        }
    }
}
include('includes/header.php');
?>

<style>
@keyframes gradientAnimation {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
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

<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

              <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
              <?php endforeach; ?>

              <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
              <?php endif; ?>

              <form method="POST" class="needs-validation" novalidate>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" name="username" id="username" 
                         class="form-control form-control-lg" pattern=".{3,}" required />
                  <label class="form-label" for="username">Your Name</label>
                  <div class="invalid-feedback">Enter at least 3 characters.</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" name="email" id="email" 
                         class="form-control form-control-lg" required />
                  <label class="form-label" for="email">Your Email</label>
                  <div class="invalid-feedback">Enter a valid email.</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="password" id="password" 
                         class="form-control form-control-lg" pattern=".{6,}" required />
                  <label class="form-label" for="password">Password</label>
                  <div class="invalid-feedback">Password must be at least 6 characters.</div>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" data-mdb-button-init
                          class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">
                  Have already an account? <a href="login.php" class="fw-bold text-body"><u>Login here</u></a>
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
// Bootstrap form validation
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
