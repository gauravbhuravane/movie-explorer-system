<?php include('includes/header.php'); ?>

<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    .content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .search-section {
        padding: 60px 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .search-section:hover {
        transform: scale(1.01);
    }
    h1 {
        font-weight: 700;
        color: #343a40;
    }
    .search-section input,
    .search-section select {
        border-radius: 8px;
    }
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: background 0.3s;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
    }
    .genre-btn {
        padding: 12px 20px;
        border-radius: 30px;
        border: 2px solid #0d6efd;
        background: transparent;
        color: #0d6efd;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .genre-btn:hover {
        background-color: #0d6efd;
        color: white !important;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
    hr {
        border-top: 2px dashed #adb5bd;
    }
    footer {
        background-color: #212529;
        color: white;
        text-align: center;
        padding: 15px 0;
    }
</style>

<div class="container mt-5 content">
    <div class="text-center search-section">
        <h1 class="mb-4">🎬 Movie Explorer System</h1>
        <form method="GET" action="search.php" class="row g-3 justify-content-center">
            <div class="col-md-4">
                <input type="text" name="query" class="form-control shadow-sm" placeholder="🔍 Search by Title or Keyword">
            </div>
            <div class="col-md-3">
                <select name="genre" class="form-select shadow-sm">
                    <option value="">All Genres</option>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="rating" id="rating" class="form-select shadow-sm">
                    <option value="">Any Rating</option>
                    <option value="9">9+</option>
                    <option value="8">8+</option>
                    <option value="7">7+</option>
                    <option value="6">6+</option>
                    <option value="5">5+</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow">Search 🎯</button>
            </div>
        </form>
    </div>

    <hr class="my-5">

    <h2 class="text-center mb-4">🎭 Explore by Genre</h2>
    <div class="d-flex flex-wrap justify-content-center gap-3">
        <?php
            $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Romance', 'Sci-Fi', 'Thriller', 'Animation'];
            foreach ($genres as $genre) {
                echo "<a href='search.php?genre=" . urlencode($genre) . "' class='genre-btn'>$genre</a>";
            }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
