<?php require_once("../database.php");

//if user doesnt input all the necessary field prompt them
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["type"]) || empty($_POST["name"]) || empty($_POST["address"]) ||
        empty($_POST["city"]) || empty($_POST["province"]) || empty($_POST["postal_code"]) ||
        empty($_POST["phone_number"]) || empty($_POST["maximum_capacity"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
        echo "<a href='javascript:history.back()' style='color: blue; text-decoration: underline;'>Go Back</a></br>";

    }
}

//check if user inputed all the field
if (isset($_POST["type"]) && isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["city"]) && isset($_POST["province"]) && isset($_POST["postal_code"]) && isset($_POST["phone_number"]) && isset($_POST["maximum_capacity"]) && isset($_POST["postal_code"])) {

    $location = $conn->prepare("INSERT INTO Location 
    (type, name, address, city, province, postal_code, phone_number, web_address, maximum_capacity)
    VALUES (:type, :name, :address, :city, :province, :postal_code, :phone_number, :web_address, :maximum_capacity)");


    $location->bindParam(":type", $_POST["type"]);
    $location->bindParam(":name", $_POST["name"]);
    $location->bindParam(":address", $_POST["address"]);
    $location->bindParam(":city", $_POST["city"]);
    $location->bindParam(":province", $_POST["province"]);
    $location->bindParam(":postal_code", $_POST["postal_code"]);
    $location->bindParam(":phone_number", $_POST["phone_number"]);
    $location->bindParam(":web_address", $_POST["web_address"]);
    $location->bindParam(":maximum_capacity", $_POST["maximum_capacity"]);

    //if successful, bring back the user to list of book
    if ($location->execute()) {
        header("Location: .");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
</head>
<h1>Add Location</h1>

<body>
    <!-- Create a form to add to the database  -->
    <form action="./create.php" method="post">
        <label for="type">Type</label><br>

        <select name="type" id="type"><br>
            <option value="Head">Head</option>
            <option value="Branch">Branch</option>
        </select><br>

        <label for="name">Name</label><br>
        <input type="text" name="name" id="name"><br>

        <label for="address">Address</label><br>
        <input type="text" name="address" id="address"><br>

        <label for="city">City</label><br>
        <input type="text" name="city" id="city"><br>

        <label for="province">Province</label><br>
        <input type="text" name="province" id="province"><br>

        <label for="postal_code">Postal Code</label><br>
        <input type="text" name="postal_code" id="postal_code"><br>


        <label for="phone_number">Phone Number</label><br>
        <input type="number" name="phone_number" id="phone_number"><br>

        <label for="web_address">Web Address</label><br>
        <input type="text" name="web_address" id="web_address"><br>

        <label for="maximum_capacity">Maximum Capacity</label><br>
        <input type="number" name="maximum_capacity" id="maximum_capacity"><br>

        <button type="submit">Add Location</button>


    </form>
    <!-- link to previous page -->
    <a href="./">Back to Location list</a>



</body>

</html>