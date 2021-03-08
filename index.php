<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sweetwater Is Awesome</title>
</head>
<body>
  <h1>Comment Report:</h1>
  <?php 
    include "database/Database.php";
    // $database = new Database();
    $database = Database::getInstance();
    // $database->openConnection();

    // CANDY
    echo "<h2>Candy Comments: </h2>";
    $candyComments = ["candy", "sweets", "smarties", "taffy", "tootsie", "bit o honey", "fireball", "fire ball", "mint"];
    $database->getCommentsContaining($candyComments);

    // CALL / DONT CALL
    echo "<h2>Call Comments: </h2>";
    $callComments = ["call ", "call."];
    $database->getCommentsContaining($callComments);
  ?>
</body>
</html>