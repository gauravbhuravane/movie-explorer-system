<?php include('includes/header.php'); ?>

<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }
    .content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .movie-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .movie-poster {
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }
    .btn-favorite {
        transition: transform 0.2s, background-color 0.2s;
    }
    .btn-favorite:hover {
        transform: scale(1.05);
        background-color: #dc3545 !important;
        color: white !important;
    }
    footer {
        background-color: #212529;
        color: white;
        text-align: center;
        padding: 15px 0;
    }
</style>

<div class="container mt-5 content">
    <?php
        $apiKey = "c71b269b";
        $imdbID = isset($_GET['imdbID']) ? $_GET['imdbID'] : '';

        if (!empty($imdbID)) {
            $url = "http://www.omdbapi.com/?apikey=$apiKey&i=$imdbID&plot=full";
            $response = file_get_contents($url);
            $movie = json_decode($response, true);

            if ($movie['Response'] == "True") {
                $poster = $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x445?text=No+Image';
                echo "<div class='row justify-content-center movie-card'>";
                echo "  <div class='col-md-4 mb-3 text-center'>
                            <img src='$poster' class='movie-poster' alt='{$movie['Title']} Poster'>
                        </div>";
                echo "  <div class='col-md-8'>
                            <h2>{$movie['Title']} ({$movie['Year']})</h2>
                            <p><strong>Genre:</strong> {$movie['Genre']}</p>
                            <p><strong>Runtime:</strong> {$movie['Runtime']}</p>
                            <p><strong>Director:</strong> {$movie['Director']}</p>
                            <p><strong>Actors:</strong> {$movie['Actors']}</p>
                            <p><strong>IMDb Rating:</strong> {$movie['imdbRating']} ⭐</p>
                            <p><strong>Plot:</strong> {$movie['Plot']}</p>";

                // Favorite Button
                if (isset($_SESSION['user_id'])) {
                    echo "<form action='save_favorite.php' method='POST'>
                            <input type='hidden' name='imdb_id' value='{$movie['imdbID']}'>
                            <input type='hidden' name='title' value='{$movie['Title']}'>
                            <input type='hidden' name='year' value='{$movie['Year']}'>
                            <input type='hidden' name='poster' value='{$movie['Poster']}'>
                            <button type='submit' class='btn btn-outline-danger mt-3 btn-favorite'>❤️ Add to Favorites</button>
                          </form>";
                } else {
                    echo "<p class='text-muted mt-3'>🔒 Login to save this movie to favorites.</p>";
                }

                echo "  </div>";
                echo "</div>";
            } else {
                echo "<p class='text-danger text-center'>Movie not found.</p>";
            }
        } else {
            echo "<p class='text-warning text-center'>No IMDb ID provided.</p>";
        }
    ?>
</div>

<?php include('includes/footer.php'); ?>

<?php
    // Show popup alert based on status (added or already exists)
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {";
        if ($status == 'added') {
            echo "alert('🎉 Movie added to favorites!');";
        } elseif ($status == 'exists') {
            echo "alert('⚠️ Movie is already in your favorites!');";
        }
        echo "});
        </script>";
    }
?>
