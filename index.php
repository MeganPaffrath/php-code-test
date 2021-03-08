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
    $database = Database::getInstance();

    // CANDY
    echo "<h2>Candy Comments: </h2>";
    $candyComments = ["candy", "sweets", "caramelo", "dulce", "smarties", "taffy", "tootsie", "bit o honey", "fireball", "fire ball", "mint"];
    $database->getCommentsContaining($candyComments);

    // CALL / DONT CALL
    echo "<h2>Call Comments: </h2>";
    $callComments = ["call", "mobile", "phone", "móvil", "teléfono", "llamada", "llámame"];
    $database->getCommentsContaining($callComments);

    // REFERRED
    echo "<h2>Referred Comments: </h2>";
    $referredComments = ["referred", "refirió", "refiero"];
    $database->getCommentsContaining($referredComments);

    // SIGNATURE REQ
    echo "<h2>Signature Comments: </h2>";
    $signatureComments = ["signature", "firma"];
    $database->getCommentsContaining($signatureComments);

    // Misc Comments
    echo "<h2>Misc Comments: </h2>";
    $miscComments = array_merge($candyComments, $callComments, $referredComments, $signatureComments);
    $database->getCommentsExcluding($miscComments);

    // Update shipdate
    echo "<h1>Calling populateExpectedShipdate...</h1>";
    $database->populateExpectedShipdate();
  ?>
</body>
</html>