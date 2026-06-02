<?php
header("Location: /rwm/movies/movies.php");
exit;
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <title>Rate Watched Movies</title>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div class="w3-container">
        <div class="w3-row-padding">
            <?php foreach ($movies as $movie): ?>
                <div class="w3-third">
                    <div class="w3-card-4">
                        <div class="w3-container w3-blue">
                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        </div>
                        <div class="w3-container">
                            <p><strong>Genre: </strong><?php echo htmlspecialchars($movie['genre']); ?></p>                            
                            <p><strong>Release Year: </strong><?php echo htmlspecialchars($movie['release_year']); ?></p>
                            <p><strong>Summary: </strong><?php echo htmlspecialchars($movie['summary']); ?></p>                
                            <p><strong>Rating: </strong><?php echo htmlspecialchars($movie['rating']); ?>/10</p>
                            <p><strong>Review: </strong><?php echo htmlspecialchars($movie['review']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</body>
</html> -->