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
    include "database/DatabaseReader.php";
    include "database/DatabaseWritter.php";
    $database = Database::getInstance();
    $databaseReader = new DatabaseReader();
    $databaseWritter = new DatabaseWritter();

    // CANDY
    echo "<h2>Candy Comments: </h2>";
    $candyComments = ["candy", "sweets", "caramelo", "dulce", "smarties", "taffy", "tootsie", "bit o honey", "fireball", "fire ball", "mint"];
    $databaseReader->getCommentsContaining($candyComments);

    // CALL / DONT CALL
    echo "<h2>Call Comments: </h2>";
    $callComments = ["call[[:blank:]]", "call[,]", "call[.]", "call[!]", "calls[,]", "calls[[:blank:]]", "calls[.]", "calls[!]","mobile", "phone", "móvil", "teléfono", "llamada", "llámame"];
    $databaseReader->getCommentsContaining($callComments);

    // REFERRED
    echo "<h2>Referred Comments: </h2>";
    $referredComments = ["referred", "referral", "refirió", "refiero"];
    $databaseReader->getCommentsContaining($referredComments);

    // SIGNATURE REQ
    echo "<h2>Signature Comments: </h2>";
    $signatureComments = ["signature", "[[:blank:]]sign[[:blank:]]", "[[:blank:]]sign[.]", "[[:blank:]]sign[!]", "[[:blank:]]sign[,]", "firma"];
    $databaseReader->getCommentsContaining($signatureComments);

    // Misc Comments
    echo "<h2>Misc Comments: </h2>";
    $miscComments = array_merge($candyComments, $callComments, $referredComments, $signatureComments);
    $databaseReader->getCommentsExcluding($miscComments);

    // Update shipdate
    echo "<h1>Calling populateExpectedShipdate...</h1>";
    $databaseWritter->populateExpectedShipdate();
  ?>
</body>
</html>