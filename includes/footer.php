<footer class="bg-dark text-white pt-4 pb-2 mt-5 shadow-lg" style="border-top: 2px solid rgba(255, 255, 255, 0.1);">
  <div class="container text-center text-md-start">
    <div class="row">

      <!-- About Section -->
      <div class="col-md-4 mb-4">
        <h5 class="text-info fw-bold">🎬 Movie Explorer</h5>
        <p class="small">
          Discover, explore, and track your favorite movies with our intuitive and user-friendly platform. Stay updated with the latest releases and classics!
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5 class="text-info fw-bold">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="footer-link">🏠 Home</a></li>
          <li><a href="favorites.php" class="footer-link">❤️ Favorites</a></li>
          <li><a href="profile.php" class="footer-link">🙍‍♂️ Profile</a></li>
          <li><a href="login.php" class="footer-link">🔑 Login</a></li>
          <li><a href="register.php" class="footer-link">📝 Register</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-4">
        <h5 class="text-info fw-bold">Contact Us</h5>
        <p class="small mb-1">📧 bhuravanegaurav123@example.com</p>
        <p class="small mb-3">📞 +91 9021042998</p>
      </div>

    </div>

    <!-- Scrolling Text Effect -->
    <div class="marquee mb-2">
      <span>🔥 Welcome to Movie Explorer System - Find your favorite movies now! 🎬 🍿 🎥</span>
    </div>

    <hr class="bg-light">
    <p class="small mb-0 text-center">&copy; <?= date('Y') ?> Movie Explorer System. All rights reserved.</p>
  </div>
</footer>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<style>
  .footer-link {
    color: #bbb;
    text-decoration: none;
    transition: color 0.3s, text-decoration 0.3s;
  }

  .footer-link:hover {
    color: #0dcaf0;
    text-decoration: underline;
  }

  footer {
    background: linear-gradient(90deg, #000000, #1a1a1a);
    
  }

  .marquee {
    overflow: hidden;
    position: relative;
    height: 30px;
  }

  .marquee span {
    display: inline-block;
    padding-left: 100%;
    white-space: nowrap;
    animation: marquee 12s linear infinite, colorchange 8s ease-in-out infinite;
    font-weight: bold;
    font-size: 16px;
  }

  @keyframes marquee {
    0%   { transform: translateX(0%); }
    100% { transform: translateX(-100%); }
  }

  @keyframes colorchange {
    0%   { color: #0dcaf0; }
    25%  { color: #ffc107; }
    50%  { color: #dc3545; }
    75%  { color: #198754; }
    100% { color: #0dcaf0; }
  }
</style>
