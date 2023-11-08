<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookify</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="hero-img">
        <picture>
            <source media="(min-width: 700px)" srcset="assets/herobanner_desktop2.png">
            <img src="assets/herobanner_desktop.png" alt="Hero Banner">
        </picture>
        <div class="site-logo">
            <h2>Cookify</h2>
        </div>
        <div class="overlay-text">
            <h1>Cookify</h1>
            <h4>Recipes made easy</h4>
        </div>
    </div>
    <div class="search-container">
        <form>
        <input type="search" placeholder="Search for recipes">
        <button type="submit" class="search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        </form>
    </div>
    <div class="recipe-container">
    <div class="filter">
        <div>
        <div class="filter-text">
            <h3>Protein</h3>
        </div>
        <div class="protein-filter">
        <button class="filter-button">Beef</button>
        <button class="filter-button">Chicken</button>
        <button class="filter-button">Fish</button>
        <button class="filter-button">Pork</button>
        <button class="filter-button">Steak</button>
        <button class="filter-button">Vegetarian</button>
        <button class="filter-button">Clear All</button>
        </div>
        </div>
        <div class="cook-time-filter">
        <div class="filter-text">
            <h3>Cook Time</h3>
        </div>
        <button class="filter-button">&le; 30min</button>
        <button class="filter-button">30 - 40min</button>
        <button class="filter-button">40 - 50min</button>
        <button class="filter-button">50min +</button>
        </div>
    </div>
    <?php
  require_once './includes/fun.php';
  consoleMsg("yehhhh");

  // Include env.php that holds global vars with secret info
  require_once './env.php';


  // Include the database connection code
  require_once './includes/database.php';
?>
    <div class="recipes">
    <?php
    $query = "SELECT * FROM recipes";
    $results = mysqli_query($db_connection, $query);

    if ($results && mysqli_num_rows($results) > 0) {
        while ($recipe = mysqli_fetch_assoc($results)) {
            echo '<div class="recipe-card">';
            echo '<img src="images/' . ($recipe['Main IMG']) . '" alt="' . ($recipe['Title']) . '">';
            echo '<h2>' . ($recipe['Title']) . '</h2>';
            echo '<h3>' . ($recipe['Subtitle']) . '</h3>';
            echo '</div>';
        }
    } else {
        echo '<p>No recipes found.</p>';
    }
    ?>
    </div>
    </div>
    <footer class="footer">
        <p>&copy; 2023 Michelle Le - Cookify</p>
    </footer>
</body>
</html>

