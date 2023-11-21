<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Recipe Page</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
    require_once './includes/fun.php';
    consoleMsg("fun.php is loaded");

  // Include env.php that holds global vars with secret info
    require_once './env.php';

  // Include the database connection code
    require_once './includes/database.php';
    ?>

    <nav>
        <h2>Cookify</h2>
    </nav>
    <div>
        <a href="" class="back-button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    </div>

    <?php
      $query = "SELECT * FROM recipes WHERE id=1";
      $results = mysqli_query($db_connection, $query);
      if ($results->num_rows > 0) {
        consoleMsg("Query successful! number of rows: $results->num_rows");
        while ($oneRecipe = mysqli_fetch_array($results)) {
        
            echo '<div class="recipe_container">';
            // Recipe Info
            echo '<div class="recipe_info">';
            echo '<h2>' .$oneRecipe['Title']. '</h2>';
            echo '<h3>' .$oneRecipe['Subtitle']. '</h3>';
            echo '<p>' .$oneRecipe['Description']. '</p>';
            echo '</div>';
            // Recipe IMG
            echo '<div class="recipe_img">';
            echo '<img src="images/' .$oneRecipe['Main IMG']. '" alt="Dish Image">';
            echo '</div>';

            echo '<div class="recipe_stats">';
            // Cook Time
            echo '<div class="recipe_time">';
            echo '<svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 354 354"><defs><style>.cls-1,.cls-2{fill:none;stroke:#fff;stroke-width:35px;}.cls-1{stroke-miterlimit:10;}.cls-2{stroke-linecap:round;stroke-linejoin:round;}</style></defs><title>recipe_time</title><circle class="cls-1" cx="177" cy="177" r="159.5"/><polyline class="cls-2" points="176.5 69.5 176.5 175.5 281.5 175.5"/>';
            echo '</svg>';
            echo '<h4>' .$oneRecipe['Cook Time']. '</h4>';
            echo '</div>';
            // Servings
            echo '<div class="recipe_serv">';
            echo '<svg id="Layer_5" data-name="Layer 5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 378 325"><defs><style>.cls-1,.cls-2{fill:none;stroke:#fff;stroke-linecap:round;stroke-width:35px;}.cls-1{stroke-miterlimit:10;}.cls-2{stroke-linejoin:round;}</style></defs><title>recipe_servings</title><line class="cls-1" x1="17.5" y1="307.5" x2="358.5" y2="307.5"/><path class="cls-2" d="M100.5,340.5h341s-1-187-170-187C111.5,153.5,100.5,340.5,100.5,340.5Z" transform="translate(-81 -84)"/><polyline class="cls-2" points="132.5 17.5 189 17.5 242.5 17.5"/><line class="cls-2" x1="187.5" y1="54.5" x2="187.5" y2="17.5"/>';
            echo '</svg>';
            echo '<h4>' .$oneRecipe['Servings']. ' servings</h4>';
            echo '</div>';
            // Calories per Serving
            echo '<div class="recipe_cal">';
            echo '<svg id="Layer_6" data-name="Layer 6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 444.64 334.02"><defs><style>.cls-1,.cls-2,.cls-3,.cls-4,.cls-5,.cls-6{fill:none;}.cls-2,.cls-3,.cls-4,.cls-5,.cls-6{stroke:#fff;stroke-miterlimit:10;}.cls-2{stroke-width:30px;}.cls-3{stroke-width:25px;}.cls-4,.cls-5{stroke-width:20px;}.cls-5,.cls-6{stroke-linecap:round;}.cls-6{stroke-width:15px;}</style></defs><title>recipe_cal</title><circle class="cls-1" cx="227.4" cy="164.02" r="133.5"/><circle class="cls-2" cx="227.4" cy="164.02" r="133.5"/><circle class="cls-3" cx="227.7" cy="164.39" r="72.37"/><path class="cls-4" d="M444.5,287.5s-4,107-3,116,8,11,14,11,14-5,14-12-2-115-2-115,11-90,9-113-25-66-29-68S444.5,287.5,444.5,287.5Z" transform="translate(-42.1 -96.48)"/><path class="cls-5" d="M52.5,119.5s-2,64,3,74a125.74,125.74,0,0,0,10,16.36,10.09,10.09,0,0,1,1.88,6.08c-.53,25.77-3.85,188-2.93,192.56,1,5,3,12,13,12" transform="translate(-42.1 -96.48)"/><line class="cls-6" x1="37.9" y1="22.52" x2="37.9" y2="90.52"/><path class="cls-5" d="M105.57,119.51s2,64-3,74a127,127,0,0,1-10.06,16.37,10.05,10.05,0,0,0-1.87,6c.53,25.72,3.85,188,2.93,192.59-1,5-3,12-13,12" transform="translate(-42.1 -96.48)"/>';
            echo '</svg>';
            echo '<h4>' .$oneRecipe['Cal/Serving']. ' cal/serving</h4>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';

            // Ingredients Img and List
        $ingredients = explode('*', $oneRecipe['All Ingredients']);

        function wrapNumbersWithSpan($string) {
            return preg_replace('/(\d+\/\d+|\d+)/', '<span class="number">$1</span>', $string);
        }
            echo '<h2 class="title">Ingredients</h2>';
            echo '<div class="ingredients_container">';
            echo '<div class="ingredients">';
            echo '<div>';
            echo '<img src="images/ing/' .$oneRecipe['Ingredients IMG']. '" alt="Ingredients">';
            echo '</div>';
            echo '<div class="ingr_list">';
            echo '<ul>';
            foreach ($ingredients as $ingredient):
                echo '<li>' .wrapNumbersWithSpan(trim($ingredient)). '</li>';
            endforeach;
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // Instructions
            echo '<h2 class="title">Instructions</h2>';
            echo '<div class="instructions">';
            echo '<figure class="step">';

        $imageUrls = explode('*', $oneRecipe['Step IMGs']);

        for ($i = 1; $i <= 6; $i++) {
            $stepTitleKey = 'Step Title #' . $i;
            $stepDescKey = 'Step Desc #' . $i;
        
            if (!empty($oneRecipe[$stepTitleKey]) && !empty($oneRecipe[$stepDescKey])) {
                $stepName = preg_replace('/^\d+\s*/', '', $oneRecipe[$stepTitleKey]);
                
                // Echo the step number if title and description exist
                echo '<figcaption class="step_num">Step ' . $i . '</figcaption>';
                
                // Echo the modified step title (without the number) and description
                echo '<figcaption class="step_name">' . $stepName . '</figcaption>';
                echo '<figcaption class="step_desc">' . $oneRecipe[$stepDescKey] . '</figcaption>';
            
                // Step IMG
                if (isset($imageUrls[$i - 1])) {
                    echo '<img src="images/step/' . $imageUrls[$i - 1] . '"/>';
                }
            }
        }

            echo '</figure>';
            echo '</div>';
        }

      } else {
        consoleMsg("QUERY ERROR");
      }
    ?>

        <div>
        <a href="" class="back-button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
        </div>
        <footer class="footer">
            <p>&copy; 2023 Michelle Le - Cookify</p>
        </footer>
</body>
</html>