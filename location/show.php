<?php require_once '../database.php';

$statement = $conn->prepare("SELECT * FROM Location WHERE LocationID = :LocationID");
$statement->bindParam(":LocationID", $_GET["LocationID"], PDO::PARAM_INT);
$statement->execute();
$location = $statement->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $location["title"] ?></title>
</head>

<body>
    <h1><?= $location["LocationID"] ?></h1>
    <h2>Type: <?= $location["type"] ?></h2>
    <h2>Name: <?= $location["name"] ?></h2>
    <h2>Address: <?= $location["address"] ?></h2>
    <h2>City: <?= $location["city"] ?></h2>
    <h2>Province: <?= $location["province"] ?></h2>
    <h2>Postal Code: <?= $location["postal_code"] ?></h2>
    <h2>Phone NUmber: <?= $location["phone_number"] ?></h2>
    <h2>Web Address: <?= $location["web_address"] ?></h2>
    <h2>Maximum Capacity: <?= $location["macimum_capacity"] ?></h2>

</body>
<!-- link to previous page -->
<a href="./">Back to Location list</a>

</html>