<?php
require_once("../database.php");

// If the form was submitted via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present:
    if (
        empty($_POST["famID"]) ||
        empty($_POST["first_name"]) ||
        empty($_POST["last_name"]) ||
        empty($_POST["date_of_birth"]) ||
        empty($_POST["social_security_number"]) ||
        empty($_POST["medical_card_number"]) ||
        empty($_POST["phone_number"]) ||
        empty($_POST["address"]) ||
        empty($_POST["city"]) ||
        empty($_POST["province"]) ||
        empty($_POST["postal_code"]) ||
        empty($_POST["email_address"]) ||
        empty($_POST["location_id"]) ||
        empty($_POST["secondary_id"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
    }
}

// If all required fields are set, proceed with insertion
if (
    isset($_POST["famID"]) &&
    isset($_POST["first_name"]) &&
    isset($_POST["last_name"]) &&
    isset($_POST["date_of_birth"]) &&
    isset($_POST["social_security_number"]) &&
    isset($_POST["medical_card_number"]) &&
    isset($_POST["phone_number"]) &&
    isset($_POST["address"]) &&
    isset($_POST["city"]) &&
    isset($_POST["province"]) &&
    isset($_POST["postal_code"]) &&
    isset($_POST["email_address"]) &&
    isset($_POST["location_id"]) &&
    isset($_POST["secondary_id"])
) {
    try {
        // Prepare an INSERT statement using PDO
        $stmt = $conn->prepare("
            INSERT INTO Family_member (
                famID,
                first_name,
                last_name,
                date_of_birth,
                social_security_number,
                medical_card_number,
                phone_number,
                address,
                city,
                province,
                postal_code,
                email_address,
                location_id,
                secondary_id
            ) VALUES (
                :famID,
                :first_name,
                :last_name,
                :date_of_birth,
                :social_security_number,
                :medical_card_number,
                :phone_number,
                :address,
                :city,
                :province,
                :postal_code,
                :email_address,
                :location_id,
                :secondary_id
            )
        ");

        // Bind parameters (use PDO::PARAM_INT for integer fields)
        $stmt->bindParam(":famID", $_POST["famID"], PDO::PARAM_INT);
        $stmt->bindParam(":first_name", $_POST["first_name"]);
        $stmt->bindParam(":last_name", $_POST["last_name"]);
        $stmt->bindParam(":date_of_birth", $_POST["date_of_birth"]); 
        $stmt->bindParam(":social_security_number", $_POST["social_security_number"]);
        $stmt->bindParam(":medical_card_number", $_POST["medical_card_number"]);
        $stmt->bindParam(":phone_number", $_POST["phone_number"]);
        $stmt->bindParam(":address", $_POST["address"]);
        $stmt->bindParam(":city", $_POST["city"]);
        $stmt->bindParam(":province", $_POST["province"]);
        $stmt->bindParam(":postal_code", $_POST["postal_code"]);
        $stmt->bindParam(":email_address", $_POST["email_address"]);
        $stmt->bindParam(":location_id", $_POST["location_id"], PDO::PARAM_INT);
        $stmt->bindParam(":secondary_id", $_POST["secondary_id"], PDO::PARAM_INT);

        // Attempt to execute the statement
        if ($stmt->execute()) {
            // If successful, redirect to a list page or anywhere you prefer
            header("Location: ."); // e.g., back to Family_member listing
            exit();
        }
    } catch (PDOException $e) {
        // Check for duplicate entry or other errors
        if ($e->getCode() == 23000) {  // 23000 = unique constraint violation
            echo "<script>alert('This family member already exists!');</script>";
            echo "<script>window.location.href = './create.php';</script>";
        } else {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Family Member</title>
</head>
<body>
    <h1>Add Family Member</h1>
    <form action="./create.php" method="post">

        <label for="famID">famID</label><br>
        <input type="number" name="famID" id="famID"><br>

        <label for="first_name">First Name</label><br>
        <input type="text" name="first_name" id="first_name"><br>

        <label for="last_name">Last Name</label><br>
        <input type="text" name="last_name" id="last_name"><br>

        <label for="date_of_birth">Date of Birth</label><br>
        <input type="date" name="date_of_birth" id="date_of_birth"><br>

        <label for="social_security_number">SSN</label><br>
        <input type="text" name="social_security_number" id="social_security_number"><br>

        <label for="medical_card_number">Medical Card Number</label><br>
        <input type="text" name="medical_card_number" id="medical_card_number"><br>

        <label for="phone_number">Phone Number</label><br>
        <input type="text" name="phone_number" id="phone_number"><br>

        <label for="address">Address</label><br>
        <input type="text" name="address" id="address"><br>

        <label for="city">City</label><br>
        <input type="text" name="city" id="city"><br>

        <label for="province">Province</label><br>
        <input type="text" name="province" id="province"><br>

        <label for="postal_code">Postal Code</label><br>
        <input type="text" name="postal_code" id="postal_code"><br>

        <label for="email_address">Email Address</label><br>
        <input type="text" name="email_address" id="email_address"><br>

        <label for="location_id">Location ID</label><br>
        <input type="number" name="location_id" id="location_id"><br>

        <label for="secondary_id">Secondary ID</label><br>
        <input type="number" name="secondary_id" id="secondary_id"><br><br>

        <button type="submit">Add Family Member</button>
    </form>

    <!-- Link back or anywhere else -->
    <a href="./">Back to Family Member List</a>
</body>
</html>
