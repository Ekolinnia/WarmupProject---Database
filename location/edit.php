<?php require_once("../database.php");

$statement = $conn->prepare("SELECT * FROM Location WHERE LocationID = :LocationID");
$statement->bindParam(":LocationID", $_GET["LocationID"], PDO::PARAM_INT);
$statement->execute();
$location = $statement->fetch(PDO::FETCH_ASSOC);


//check if user inputed all the field
if (isset($_POST["type"]) && isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["city"]) && isset($_POST["province"]) && isset($_POST["postal_code"]) && isset($_POST["phone_number"]) && isset($_POST["maximum_capacity"]) && isset($_POST['LocationID'])) {

    //if set update it to the data base
    $updatelocation = $conn->prepare("UPDATE Location SET type = :type, name = :name, address = :address, city = :city, province = :province,
    postal_code = :postal_code, phone_number = :phone_number,
    web_address = :web_address, maximum_capacity = :maximum_capacity
    WHERE LocationID = :LocationID;");


    //bind the data entered by the user to the database 
    $updatelocation->bindParam(":type", $_POST["type"]);
    $updatelocation->bindParam(":name", $_POST["name"]);
    $updatelocation->bindParam(":address", $_POST["address"]);
    $updatelocation->bindParam(":city", $_POST["city"]);
    $updatelocation->bindParam(":province", $_POST["province"]);
    $updatelocation->bindParam(":postal_code", $_POST["postal_code"]);
    $updatelocation->bindParam(":phone_number", $_POST["phone_number"]);
    $updatelocation->bindParam(":web_address", $_POST["web_address"]);
    $updatelocation->bindParam(":maximum_capacity", $_POST["maximum_capacity"]);
    $updatelocation->bindParam(":LocationID", $_POST["LocationID"]);


    //if successful, bring back the user to list of book
    if ($updatelocation->execute()) {
        header("Location: .");
    } else {
        header("Location: ./edit.php?LocationID=" . $_POST["LocationID"]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Location</title>
</head>
<h1>Update Location</h1>

<body>
    <!-- Create a form to update to the database  -->
    <form action="./edit.php?LocationID=<?= $row["LocationID"] ?>" method="post">
        <label for="type">Type</label><br>

        <select name="type" id="type">
            <option value="Head" <?= ($location["type"] == "Head") ? "selected" : "" ?>>Head</option>
            <option value="Branch" <?= ($location["type"] == "Branch") ? "selected" : "" ?>>Branch</option>
        </select>
        <br>

        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" value="<?= $location["name"] ?>"> <br>

        <label for="address">Address</label><br>
        <input type="text" name="address" id="address" value="<?= $location["address"] ?>"><br>

        <label for="city">City</label><br>
        <input type="text" name="city" id="city" value="<?= $location["city"] ?>"><br>

        <label for="province">Province</label><br>
        <input type="text" name="province" id="province" value="<?= $location["province"] ?>"><br>

        <label for="postal_code">Postal Code</label><br>
        <input type="text" name="postal_code" id="postal_code" value="<?= $location["postal_code"] ?>"><br>


        <label for="phone_number">Phone Number</label><br>
        <input type="number" name="phone_number" id="phone_number" value="<?= $location["phone_number"] ?>"><br>

        <label for="web_address">Web Address</label><br>
        <input type="text" name="web_address" id="web_address" value="<?= $location["web_address"] ?>"><br>

        <label for="maximum_capacity">Maximum Capacity</label><br>
        <input type="number" name="maximum_capacity" id="maximum_capacity"
            value="<?= $location["maximum_capacity"] ?>"><br>

        <!-- hidden parameter for id  -->

        <input type="hidden" name="LocationID" id="LocationID" value="<?= $location["LocationID"] ?>"><br>

        <button type="submit">Update Location</button>


        </>
        <!-- link to previous page -->
        <a href="./">Back to Location list</a>



</body>

</html>