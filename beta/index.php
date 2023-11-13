<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ancho-Orange Chicken Recipe</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav>
        <h2>Cookify</h2>
    </nav>
    <div>
        <a href="" class="back-button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    </div>
    <?php
    require_once './includes/fun.php';
    consoleMsg("fun.php is loaded");

  // Include env.php that holds global vars with secret info
    require_once './env.php';

  // Include the database connection code
    require_once './includes/database.php';
    ?>

    <div class="recipe_container">
    <div class="recipe_info">
    <?php
    $query = "SELECT * FROM `recipes` WHERE `id` = 1";
    $results = mysqli_query($db_connection, $query);
    $recipe = array();

    if ($results->num_rows > 0) {
        $recipe = mysqli_fetch_assoc($results);
    } else {
        echo '<p>No recipes found.</p>';
    }
    ?>
        <h2><?php echo ($recipe['Title']); ?></h2>
        <h3><?php echo ($recipe['Subtitle']); ?></h3>
        <p><?php echo ($recipe['Description']); ?></p>
    </div>
    <div class="recipe_img">
        <img src="images/<?php echo ($recipe['Main IMG']); ?>" alt="">
    </div>

    <div class="recipe_stats">
        <div class="recipe_time">
            <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 354 354"><defs><style>.cls-1,.cls-2{fill:none;stroke:#fff;stroke-width:35px;}.cls-1{stroke-miterlimit:10;}.cls-2{stroke-linecap:round;stroke-linejoin:round;}</style></defs><title>recipe_time</title><circle class="cls-1" cx="177" cy="177" r="159.5"/><polyline class="cls-2" points="176.5 69.5 176.5 175.5 281.5 175.5"/></svg>
            <h4><?php echo ($recipe['Cook Time']); ?></h4>
        </div>
        <div class="recipe_serv">
            <svg id="Layer_5" data-name="Layer 5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 378 325"><defs><style>.cls-1,.cls-2{fill:none;stroke:#fff;stroke-linecap:round;stroke-width:35px;}.cls-1{stroke-miterlimit:10;}.cls-2{stroke-linejoin:round;}</style></defs><title>recipe_servings</title><line class="cls-1" x1="17.5" y1="307.5" x2="358.5" y2="307.5"/><path class="cls-2" d="M100.5,340.5h341s-1-187-170-187C111.5,153.5,100.5,340.5,100.5,340.5Z" transform="translate(-81 -84)"/><polyline class="cls-2" points="132.5 17.5 189 17.5 242.5 17.5"/><line class="cls-2" x1="187.5" y1="54.5" x2="187.5" y2="17.5"/></svg>
            <h4><?php echo ($recipe['Servings']); ?> servings</h4>
        </div>
        <div class="recipe_cal">
            <svg id="Layer_6" data-name="Layer 6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 444.64 334.02"><defs><style>.cls-1,.cls-2,.cls-3,.cls-4,.cls-5,.cls-6{fill:none;}.cls-2,.cls-3,.cls-4,.cls-5,.cls-6{stroke:#fff;stroke-miterlimit:10;}.cls-2{stroke-width:30px;}.cls-3{stroke-width:25px;}.cls-4,.cls-5{stroke-width:20px;}.cls-5,.cls-6{stroke-linecap:round;}.cls-6{stroke-width:15px;}</style></defs><title>recipe_cal</title><circle class="cls-1" cx="227.4" cy="164.02" r="133.5"/><circle class="cls-2" cx="227.4" cy="164.02" r="133.5"/><circle class="cls-3" cx="227.7" cy="164.39" r="72.37"/><path class="cls-4" d="M444.5,287.5s-4,107-3,116,8,11,14,11,14-5,14-12-2-115-2-115,11-90,9-113-25-66-29-68S444.5,287.5,444.5,287.5Z" transform="translate(-42.1 -96.48)"/><path class="cls-5" d="M52.5,119.5s-2,64,3,74a125.74,125.74,0,0,0,10,16.36,10.09,10.09,0,0,1,1.88,6.08c-.53,25.77-3.85,188-2.93,192.56,1,5,3,12,13,12" transform="translate(-42.1 -96.48)"/><line class="cls-6" x1="37.9" y1="22.52" x2="37.9" y2="90.52"/><path class="cls-5" d="M105.57,119.51s2,64-3,74a127,127,0,0,1-10.06,16.37,10.05,10.05,0,0,0-1.87,6c.53,25.72,3.85,188,2.93,192.59-1,5-3,12-13,12" transform="translate(-42.1 -96.48)"/></svg>
            <h4><?php echo ($recipe['Cal/Serving']); ?> cal/serving</h4>
        </div>
    </div>
    <?php
    $ingredients = explode('*', $recipe['All Ingredients']);

    function wrapNumbersWithSpan($string) {
        return preg_replace('/(\d+\/\d+|\d+)/', '<span class="number">$1</span>', $string);
    }
    ?>
    </div>
        <h2 class="title">Ingredients</h2>
        <div class="ingredients_container">
        <div class="ingredients">
            <div>
                <img src="images/<?php echo ($recipe['Ingredients IMG']);?>" alt="">
            </div>
            <div class="ingr_list">
                <ul>
                <?php foreach ($ingredients as $ingredient): ?>
                <li><?php echo (wrapNumbersWithSpan(trim($ingredient))); ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        </div>
        <h2 class="title">Instructions</h2>
        <div class="instructions">
            <figure class="step">
                <figcaption class="step_num">Step 1</figcaption>
                <figcaption class="step_name">Cook the Rice</figcaption>
                <figcaption class="step_desc">Place an oven rack in the center of the oven, then preheat to 450°F. In a medium pot, combine the <strong>rice, a big pinch of salt,</strong> and <strong>1 1/2 cups of water.</strong> Heat to boiling on high. Once boiling, cover and reduce the heat to low. Cook 12 to 14 minutes, or until the water has been absorbed and the rice is tender. Turn off the heat and fluff with a fork. Cover to keep warm.</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18594_WEB_retina_feature.jpg" alt="Step 1">
                <figcaption class="step_num">Step 2</figcaption>
                <figcaption class="step_name">Prepare the ingredients & make the glaze</figcaption>
                <figcaption class="step_desc">While the rice cooks, wash and dry the fresh produce. Peel the <strong>carrots;</strong> quarter lengthwise, then halve crosswise. Peel and roughly chop the <strong>garlic.</strong> Remove and discard the stems of the <strong>kale;</strong> finely chop the leaves. Using a peeler, remove the <strong>lime</strong> rind, avoiding the white pith; mince to get 2 teaspoons of zest (or use a zester). Halve the lime crosswise. Halve the <strong>orange;</strong> squeeze the juice into a bowl, straining out any seeds. Whisk in the <strong>chile paste</strong> and <strong>2 tablespoons of water</strong> until smooth.</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18622_WEB_retina_feature.jpg" alt="Step 2">
                <figcaption class="step_num">Step 3</figcaption>
                <figcaption class="step_name">Prep & roast the carrots</figcaption>
                <figcaption class="step_desc">Place the <strong>sliced carrots</strong> on a sheet pan. Drizzle with olive oil and season with salt and pepper; toss to coat. Arrange in an even layer. Roast 15 to 17 minutes, or until tender when pierced with a fork. Remove from the oven.</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18626_WEB_retina_feature.jpg" alt="Step 3">
                <figcaption class="step_num">Step 4</figcaption>
                <figcaption class="step_name">Cook the kale</figcaption>
                <figcaption class="step_desc">While the carrots roast, in a large pan (nonstick, if you have one), heat 2 teaspoons of olive oil on medium-high until hot. Add the <strong>chopped garlic</strong> and cook, stirring constantly, 30 seconds to 1 minute, or until fragrant. Add the <strong>chopped kale;</strong> season with salt and pepper. Cook, stirring occasionally, 3 to 4 minutes, or until slightly wilted. Add <strong>1/3 cup of water;</strong> season with salt and pepper. Cook, stirring occasionally, 3 to 4 minutes, or until the kale has wilted and the water has cooked off. Transfer to the pot of <strong>cooked rice.</strong> Stir to combine; season with salt and pepper to taste. Cover to keep warm. Wipe out the pan.</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18609_WEB_retina_feature.jpg" alt="Step 4">
                <figcaption class="step_num">Step 5</figcaption>
                <figcaption class="step_name">Cook & glaze the chicken</figcaption>
                <figcaption class="step_desc">While the carrots continue to roast, pat the <strong>chicken</strong> dry with paper towels; season with salt and pepper on both sides. In the same pan, heat 2 teaspoons of olive oil on medium-high until hot. Add the seasoned chicken and cook 4 to 6 minutes on the first side, or until browned. Flip and cook 2 to 3 minutes, or until lightly browned. Add the <strong>glaze</strong> and cook, frequently spooning the glaze over the chicken, 2 to 3 minutes, or until the chicken is coated and cooked through. Turn off the heat; stir the <strong>butter</strong> and <strong>the juice of 1 lime half</strong> into the glaze until the butter has melted. Season with salt and pepper to taste.</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18639_WEB_retina_feature.jpg" alt="Step 5">
                <figcaption class="step_num">Step 6</figcaption>
                <figcaption class="step_name">Finish the rice & serve your dish</figcaption>
                <figcaption class="step_desc">To the pot of <strong>cooked rice and kale,</strong> add the <strong>lime zest, crème fraîche, raisins,</strong> and <strong>the juice of the remaining lime half.</strong> Stir to combine; season with salt and pepper to taste. Serve the <strong>glazed chicken</strong> with the finished rice and <strong>roasted carrots.</strong> Top the chicken with the remaining glaze from the pan. Enjoy!</figcaption>
                <img src="images/0101_FPP_Chicken-Rice_18630_WEB_retina_feature.jpg" alt="Step 6">
            </figure>
        </div>
        <div>
        <a href="" class="back-button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
        </div>
        <footer class="footer">
            <p>&copy; 2023 Michelle Le - Cookify</p>
        </footer>
</body>
</html>