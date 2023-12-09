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
        <button class="filter-button" data-filter="turkey" onclick="toggleFilter('turkey', this)">Turkey</button>
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

    //   if (!empty($search)) {
    //     consoleMsg("Doing a SEARCH");
    //     // $query = "select * FROM recipes WHERE title LIKE '%{$search}%'";
    //     $query = "select * FROM recipes WHERE title LIKE '%{$search}%' OR subtitle LIKE '%{$search}%'";
    //     $result = mysqli_query($connection, $query);
    //   } else {
    //     consoleMsg("Loading ALL RECIPES");
    //     $query = "SELECT * FROM recipes";
    //   }
    if (!empty($search)) {
        consoleMsg("Doing a SEARCH");
        // $query = "select * FROM recipes WHERE title LIKE '%{$search}%'";
        $query = "select * FROM recipes WHERE title LIKE '%{$search}%' OR subtitle LIKE '%{$search}%'";
        // $result = mysqli_query($connection, $query);
      } elseif (!empty($filter)) {
        consoleMsg("Doing a FILTER");
        $query = "select * FROM recipes WHERE proteine LIKE '%{$filter}%'";
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
        echo '<svg width="474" height="199" viewBox="0 0 474 199" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1.03998 136.36H268.54C268.54 136.36 265.21 167.21 260.78 177.56C255.4 190.1 241.67 197.86 236.89 197.86C232.11 197.86 34.5 197.26 34.5 197.26C34.5 197.26 16 194.26 10.03 181.14C7.00998 174.57 2.22998 166.22 1.03998 136.36Z" fill="#808080" stroke="#808080" stroke-width="2" stroke-miterlimit="10"/>
        <path d="M276.27 148.9L270.27 170.39L312.06 163.23C312.06 163.23 318.06 168.01 322.81 168.01C327.39 168.01 450.94 142.67 460.7 140.67C461.146 140.579 461.582 140.442 462 140.26C464.21 139.31 471.06 135.99 472.06 130.99C472.53 128.65 473.16 125.05 470.87 116.66C467.29 103.53 461.32 103.53 456.54 103.53C451.76 103.53 322.81 128.6 316.84 130.99C310.87 133.38 307.28 144.13 307.28 144.13L276.27 148.9Z" fill="#808080" stroke="#808080" stroke-width="2" stroke-miterlimit="10"/>
        <path d="M106.621 36.7319C106.051 42.8119 105.651 53.5719 109.241 58.1519C109.241 58.1519 107.551 46.3319 122.701 31.5019C128.801 25.5319 130.211 17.4119 128.081 11.3219C126.871 7.87185 124.661 5.02185 122.741 3.03185C121.621 1.86185 122.481 -0.0681474 124.111 0.00185257C133.971 0.441853 149.951 3.18185 156.741 20.2219C159.721 27.7019 159.941 35.4319 158.521 43.2919C157.621 48.3119 154.421 59.4719 161.721 60.8419C166.931 61.8219 169.451 57.6819 170.581 54.7019C171.051 53.4619 172.681 53.1519 173.561 54.1419C182.361 64.1519 183.111 75.9419 181.291 86.0919C177.771 105.712 157.901 119.992 138.161 119.992C113.501 119.992 93.8709 105.882 88.7809 80.3419C86.7309 70.0318 87.7709 49.6319 103.671 35.2319C104.851 34.1519 106.781 35.1119 106.621 36.7319Z" fill="#808080"/>
        <path d="M147.171 74.4221C138.081 62.7221 142.151 49.3721 144.381 44.0521C144.681 43.3521 143.881 42.6921 143.251 43.1221C139.341 45.7821 131.331 52.0421 127.601 60.8521C122.551 72.7621 122.911 78.5921 125.901 85.7121C127.701 90.0021 125.611 90.9121 124.561 91.0721C123.541 91.2321 122.601 90.5521 121.851 89.8421C119.693 87.7707 118.156 85.1388 117.411 82.2421C117.251 81.6221 116.441 81.4521 116.071 81.9621C113.271 85.8321 111.821 92.0421 111.751 96.4321C111.531 110.002 122.741 121.002 136.301 121.002C153.391 121.002 165.841 102.102 156.021 86.3021C153.171 81.7021 150.491 78.6921 147.171 74.4221Z" fill="#FFFBF1"/>
        <path d="M210.439 94.5611C210.628 93.5945 211.006 92.6746 211.55 91.8539C212.095 91.0332 212.796 90.3278 213.613 89.7779C214.43 89.2281 215.347 88.8445 216.313 88.6492C217.278 88.4539 218.272 88.4507 219.239 88.6397C220.206 88.8287 221.126 89.2062 221.946 89.7508C222.767 90.2953 223.472 90.9961 224.022 91.8133C224.572 92.6304 224.956 93.5478 225.151 94.5132C225.346 95.4786 225.349 96.4729 225.16 97.4395C224.779 99.3917 223.637 101.112 221.987 102.223C220.337 103.333 218.313 103.743 216.361 103.361C214.408 102.979 212.688 101.838 211.577 100.187C210.467 98.5371 210.057 96.5133 210.439 94.5611ZM219.803 50.5017C219.887 49.5539 220.168 48.6343 220.63 47.8025C221.092 46.9707 221.724 46.2453 222.484 45.6733C223.245 45.1014 224.117 44.6957 225.044 44.4826C225.971 44.2695 226.933 44.2538 227.867 44.4363C228.801 44.6189 229.685 44.9958 230.464 45.5424C231.243 46.0891 231.898 46.7934 232.387 47.6096C232.876 48.4258 233.188 49.3357 233.302 50.2802C233.417 51.2247 233.332 52.1828 233.052 53.0922L225.429 78.4022C225.128 79.3825 224.475 80.2168 223.596 80.7441C222.717 81.2715 221.673 81.4544 220.667 81.2576C219.661 81.0609 218.763 80.4984 218.147 79.6787C217.531 78.8591 217.241 77.8403 217.332 76.8191L219.803 50.5017Z" fill="#808080"/>
        <path d="M51.3501 97.5441C51.0248 96.6144 50.8859 95.6298 50.9411 94.6464C50.9964 93.6631 51.2448 92.7002 51.6722 91.8128C52.0995 90.9255 52.6975 90.131 53.4319 89.4747C54.1663 88.8185 55.0228 88.3133 55.9525 87.988C56.8821 87.6628 57.8668 87.5238 58.8501 87.5791C59.8335 87.6343 60.7963 87.8827 61.6837 88.3101C62.5711 88.7375 63.3656 89.3354 64.0218 90.0699C64.6781 90.8043 65.1833 91.6608 65.5085 92.5904C66.1654 94.468 66.0496 96.5295 65.1864 98.3216C64.3233 100.114 62.7836 101.49 60.9061 102.146C59.0286 102.803 56.967 102.687 55.1749 101.824C53.3828 100.961 52.007 99.4216 51.3501 97.5441ZM37.1706 54.7906C36.7638 53.9305 36.5425 52.9944 36.5208 52.0432C36.4992 51.092 36.6778 50.1469 37.045 49.2692C37.4123 48.3915 37.9599 47.6008 38.6525 46.9484C39.345 46.296 40.167 45.7964 41.0651 45.4822C41.9631 45.168 42.9172 45.0461 43.8654 45.1245C44.8137 45.2028 45.7348 45.4796 46.5691 45.937C47.4035 46.3943 48.1323 47.0219 48.7084 47.7792C49.2845 48.5364 49.695 49.4062 49.9132 50.3323L56.1216 76.026C56.3577 77.0238 56.2159 78.0736 55.7235 78.9729C55.2311 79.8722 54.423 80.5573 53.4553 80.8959C52.4875 81.2345 51.4286 81.2026 50.483 80.8064C49.5373 80.4102 48.7719 79.6778 48.3345 78.7505L37.1706 54.7906Z" fill="#808080"/>';        
        echo '</svg>';
        echo '<h2>' . 'No recipes found for "' . $search . '." Try another keyword.</h2>';
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