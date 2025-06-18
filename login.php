<?php
include('includes/db.php');
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed);
            $stmt->fetch();
            if (password_verify($password, $hashed)) {
                $_SESSION['user_id'] = $user_id;
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
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

<section class="vh-100 bg-image gradient-custom-3">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Login</h2>

              <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
              <?php endif; ?>

              <form method="POST" class="needs-validation" novalidate>
                <div class="form-outline mb-4">
                  <input type="email" name="email" class="form-control form-control-lg" required />
                  <label class="form-label">Email</label>
                  <div class="invalid-feedback">Enter a valid email.</div>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" name="password" class="form-control form-control-lg" required />
                  <label class="form-label">Password</label>
                  <div class="invalid-feedback">Password is required.</div>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Don't have an account?
                  <a href="register.php" class="fw-bold text-body"><u>Register here</u></a>
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
