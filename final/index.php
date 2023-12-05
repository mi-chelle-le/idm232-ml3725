<?php
  require_once './includes/fun.php';
  consoleMsg("yehhhh");

  // Include env.php that holds global vars with secret info
  require_once './env.php';


  // Include the database connection code
  require_once './includes/database.php';
?>
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
            <h2><a href="index.php">Cookify</a></h2>
        </div>
        <div class="overlay-text">
            <h1>Cookify</h1>
            <h4>Recipes made easy</h4>
        </div>
    </div>
    <div class="search-container">
        <form action="index.php" method="POST">
        <input id="search" name="search" value="<?php echoSearchValue(); ?>" type="search" placeholder="Search for recipes">
        <button type="submit" name="submit" value="submit" class="search-btn">
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
        <button class="filter-button" data-filter="beef" onclick="toggleFilter('beef', this)">Beef</button>
        <button class="filter-button" data-filter="chicken" onclick="toggleFilter('chicken', this)">Chicken</button>
        <button class="filter-button" data-filter="fish" onclick="toggleFilter('fish', this)">Fish</button>
        <button class="filter-button" data-filter="pork" onclick="toggleFilter('pork', this)">Pork</button>
        <button class="filter-button" data-filter="steak" onclick="toggleFilter('steak', this)">Steak</button>
        <button class="filter-button" data-filter="vegitarian" onclick="toggleFilter('vegitarian', this)">Vegetarian</button>
        <button class="filter-button clear-btn" type="button" onclick="clearFilters()">Clear All</button>
        </div>
        </div>
        <!-- <div class="cook-time-filter">
        <div class="filter-text">
            <h3>Cook Time</h3>
        </div>
        <button class="filter-button"><a href="index.php?filter=30 min">&le; 30min</button>
        <button class="filter-button"><a href="index.php?filter=40 min">30 - 40min</button>
        <button class="filter-button"><a href="index.php?filter=50 min">40 - 50min</button>
        <button class="filter-button">50min +</button>
        </div> -->
    </div>

    <div class="recipes">
    <?php

      // STEP 05 Build Search Query
      $search = $_POST['search'];
      consoleMsg("Search is: $search");

      // STEP 06 Build Filter Query
      // Get filter info if passed in URL
      $filter = $_GET['filter'];
      consoleMsg("Filter is: $filter");

      if (!empty($search)) {
        consoleMsg("Doing a SEARCH");
        // $query = "select * FROM recipes WHERE title LIKE '%{$search}%'";
        $query = "select * FROM recipes WHERE title LIKE '%{$search}%' OR subtitle LIKE '%{$search}%'";
        $result = mysqli_query($connection, $query);
      } else {
        consoleMsg("Loading ALL RECIPES");
        $query = "SELECT * FROM recipes";
      }


  
$filterString = $_GET['filters'] ?? '';
$filters = explode(',', $filterString);
$filters = array_filter($filters);

$filterQueryParts = [];
foreach ($filters as $filter) {
    $filterQueryParts[] = "proteine LIKE '%{$filter}%'";
}
$filterQuery = implode(" OR ", $filterQueryParts);

if (!empty($search)) {
 
} elseif (!empty($filterQuery)) {
    $query = "SELECT * FROM recipes WHERE " . $filterQuery;
} else {
    $query = "SELECT * FROM recipes";
}


    $results = mysqli_query($db_connection, $query);

    if ($results && mysqli_num_rows($results) > 0) {
        while ($oneRecipe = mysqli_fetch_assoc($results)) {
            
            $id = $oneRecipe['id'];

            echo '<a href="./detail.php?recID='. $id .'">';
            echo '<div class="recipe-card">';
            echo '<img src="images/' . ($oneRecipe['Main IMG']) . '" alt="' . ($oneRecipe['Title']) . '">';
            echo '<h2>' . ($oneRecipe['Title']) . '</h2>';
            echo '<h3>' . ($oneRecipe['Subtitle']) . '</h3>';
            echo '</div>';
            echo '</a>';
        }
    } else {
        echo '<div class="no-recipes-msg">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 473.54 225.86"><defs><style>.cls-1{fill:none;stroke-width:10px;}.cls-1,.cls-2{stroke:gray;stroke-miterlimit:10;}.cls-2{fill:gray;stroke-width:2px;}</style></defs><title>norecipes_graphic</title><g id="Layer_9" data-name="Layer 9"><path class="cls-1" d="M88.4,159.23s-27.46,35.82-7.16,59.7,28.65,27.47,23.88,45.38S92,296.55,84.82,304.91" transform="translate(-33.46 -156.19)"/><path class="cls-1" d="M139.74,159.23s-27.46,35.82-7.16,59.7,28.66,27.47,23.88,45.38-13.13,32.24-20.3,40.6" transform="translate(-33.46 -156.19)"/><path class="cls-1" d="M192.28,159.23s-27.46,35.82-7.16,59.7S213.77,246.4,209,264.31s-13.14,32.24-20.3,40.6" transform="translate(-33.46 -156.19)"/><path class="cls-1" d="M244.82,159.23s-27.46,35.82-7.16,59.7,28.65,27.47,23.88,45.38-13.14,32.24-20.3,40.6" transform="translate(-33.46 -156.19)"/></g><g id="Layer_8" data-name="Layer 8"><path class="cls-2" d="M34.5,319.55H302s-3.33,30.85-7.76,41.2c-5.38,12.54-19.11,20.3-23.89,20.3s-202.39-.6-202.39-.6-18.5-3-24.47-16.12C40.47,357.76,35.69,349.41,34.5,319.55Z" transform="translate(-33.46 -156.19)"/><path class="cls-2" d="M309.73,332.09l-6,21.49,41.79-7.16s6,4.78,10.75,4.78c4.58,0,128.13-25.34,137.89-27.34a6.55,6.55,0,0,0,1.3-.41c2.21-.95,9.06-4.27,10.06-9.27.47-2.34,1.1-5.94-1.19-14.33-3.58-13.13-9.55-13.13-14.33-13.13s-133.73,25.07-139.7,27.46-9.56,13.14-9.56,13.14Z" transform="translate(-33.46 -156.19)"/></g>';
        echo '</svg>';
        echo '<h2>No recipes found</h2>';
        echo '</div>';
    }


    ?>
    </div>
    </div>
    <footer class="footer">
        <p>&copy; 2023 Michelle Le - Cookify</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>

