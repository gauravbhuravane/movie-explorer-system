<?php include('includes/header.php'); ?>

<!-- Additional CSS for styling and animation -->
<style>
    body {
        background: url('images/bg.png') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        padding-top: 50px;
    }

    .card {
        height: 100%; /* Important: ensures cards are equal height in flex container */
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.3);
    }

    .card-img-top {
        width: 100%;
        height: 445px; /* Equal height for all posters */
        object-fit: cover;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        flex: 1; /* Take up available vertical space in the card */
    }

    .card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card-text {
        flex-grow: 0; /* Prevents description overflow */
    }

    .card-body .btn {
        margin-top: auto; /* Pushes the button to the bottom */
    }

    .btn-primary {
        background: #ff6b81;
        border: none;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #ff4757;
    }

   .fancy-text {
  font-size: 2rem;
  background: linear-gradient(90deg, #ff6a00, #ee0979, #00c6ff, #7b2ff7);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
  animation: colorShift 6s ease-in-out infinite;
}

@keyframes colorShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}


    p.text-danger, p.text-warning {
        font-size: 18px;
        font-weight: bold;
    }
</style>


<div class="container mt-5">
  <?php
    $apiKey = "c71b269b";
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
    $min_rating = isset($_GET['rating']) ? (float) $_GET['rating'] : 0;

    $searchTerm = $query ?: $genre;

    echo "<h2 class='mb-4 text-center fancy-text'>Search Results for: <strong>" . htmlspecialchars($searchTerm) . "</strong></h2>";

    if (!empty($searchTerm)) {
        $url = "http://www.omdbapi.com/?apikey=$apiKey&s=" . urlencode($searchTerm);
        $response = file_get_contents($url);
        $result = json_decode($response, true);

        if ($result['Response'] == "True") {
            $filteredMovies = [];

            foreach ($result['Search'] as $movie) {
                $imdbID = $movie['imdbID'];
                $detailsUrl = "http://www.omdbapi.com/?apikey=$apiKey&i=$imdbID&plot=short";
                $detailsResponse = file_get_contents($detailsUrl);
                $details = json_decode($detailsResponse, true);

                if ($details['Response'] === "True") {
                    $movieGenre = strtolower($details['Genre']);
                    $movieRating = floatval($details['imdbRating']);

                    // Apply Genre filter (if any)
                    $genreMatch = true;
                    if (!empty($genre)) {
                        $genreMatch = strpos($movieGenre, strtolower($genre)) !== false;
                    }

                    // Apply Rating filter (if any)
                    $ratingMatch = $movieRating >= $min_rating;

                    if ($genreMatch && $ratingMatch) {
                        $filteredMovies[] = [
                            'Poster' => $details['Poster'] !== 'N/A' ? $details['Poster'] : 'https://via.placeholder.com/300x445?text=No+Image',
                            'Title' => $details['Title'],
                            'Year' => $details['Year'],
                            'imdbID' => $imdbID,
                            'Rating' => $details['imdbRating']
                        ];
                    }
                }
            }

            if (count($filteredMovies) > 0) {
                echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4'>";
                foreach ($filteredMovies as $movie) {
                    echo "
                    <div class='col animate__animated animate__fadeInUp'>
                      <div class='card h-100 shadow'>
                        <img src='{$movie['Poster']}' class='card-img-top' alt='{$movie['Title']} Poster'>
                        <div class='card-body'>
                          <h5 class='card-title'>{$movie['Title']}</h5>
                          <p class='card-text'>Year: {$movie['Year']}</p>
                          <p class='card-text'>⭐ Rating: {$movie['Rating']}</p>
                          <a href='movie.php?imdbID={$movie['imdbID']}' class='btn btn-primary'>View Details</a>
                        </div>
                      </div>
                    </div>";
                }
                echo "</div>";
            } else {
                echo "<p class='text-danger text-center'>No movies found matching the selected genre and rating. Try different filters.</p>";
            }
        } else {
            echo "<p class='text-danger text-center'>No movies found. Try a different search.</p>";
        }
    } else {
        echo "<p class='text-warning text-center'>No search term provided.</p>";
    }
  ?>
</div>

<?php include('includes/footer.php'); ?>
