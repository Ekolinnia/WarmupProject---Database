<?php 
require_once("../database.php");

// 1. If the form is submitted, check for missing fields:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
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
        exit();
    }
    
    // 2. Validate that the provided secondary_id exists in Secondary_family_member
    $checkSecondaryStmt = $conn->prepare("SELECT 1 FROM Secondary_family_member WHERE secondary_fm_id = :secondary_id");
    $checkSecondaryStmt->bindParam(":secondary_id", $_POST["secondary_id"], PDO::PARAM_INT);
    $checkSecondaryStmt->execute();
    if (!$checkSecondaryStmt->fetch()) {
        echo "Error: The provided secondary_id (" . htmlspecialchars($_POST["secondary_id"]) . ") does not exist in Secondary_family_member.";
        exit();
    }
    
    // 3. If all fields are set and valid, update the record
    try {
        // Prepare the UPDATE statement
        $update_stmt = $conn->prepare("
            UPDATE Family_member
            SET
                first_name              = :first_name,
                last_name               = :last_name,
                date_of_birth           = :date_of_birth,
                social_security_number  = :social_security_number,
                medical_card_number     = :medical_card_number,
                phone_number            = :phone_number,
                address                 = :address,
                city                    = :city,
                province                = :province,
                postal_code             = :postal_code,
                email_address           = :email_address,
                location_id             = :location_id,
                secondary_id            = :secondary_id
            WHERE famID = :famID
        ");

        // Bind parameters
        $update_stmt->bindParam(":famID", $_GET["famID"], PDO::PARAM_INT);
        $update_stmt->bindParam(":first_name", $_POST["first_name"]);
        $update_stmt->bindParam(":last_name", $_POST["last_name"]);
        $update_stmt->bindParam(":date_of_birth", $_POST["date_of_birth"]);
        $update_stmt->bindParam(":social_security_number", $_POST["social_security_number"]);
        $update_stmt->bindParam(":medical_card_number", $_POST["medical_card_number"]);
        $update_stmt->bindParam(":phone_number", $_POST["phone_number"]);
        $update_stmt->bindParam(":address", $_POST["address"]);
        $update_stmt->bindParam(":city", $_POST["city"]);
        $update_stmt->bindParam(":province", $_POST["province"]);
        $update_stmt->bindParam(":postal_code", $_POST["postal_code"]);
        $update_stmt->bindParam(":email_address", $_POST["email_address"]);
        $update_stmt->bindParam(":location_id", $_POST["location_id"], PDO::PARAM_INT);
        $update_stmt->bindParam(":secondary_id", $_POST["secondary_id"], PDO::PARAM_INT);

        // Execute and redirect if successful
        if ($update_stmt->execute()) {
            header("Location: ."); // redirect back to the listing page
            exit();
        }
    } catch (PDOException $e) {
        echo "Error updating family member: " . $e->getMessage();
    }
}

// 4. Fetch the existing record to populate the form (if not POST or in case of errors)
$statement = $conn->prepare("SELECT * FROM Family_member WHERE famID = :famID");
$statement->bindParam(":famID", $_GET["famID"], PDO::PARAM_INT);
$statement->execute();
$family_member = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Family Member</title>
</head>
<body>
    <h1>Update Family Member</h1>

    <!-- The form populates with current values from $family_member -->
    <form action="edit.php?famID=<?= $_GET['famID'] ?>" method="post">

        <label for="first_name">First Name</label><br>
        <input type="text" name="first_name" id="first_name"
               value="<?= htmlspecialchars($family_member["first_name"]) ?>"><br>

        <label for="last_name">Last Name</label><br>
        <input type="text" name="last_name" id="last_name"
               value="<?= htmlspecialchars($family_member["last_name"]) ?>"><br>

        <label for="date_of_birth">Date of Birth</label><br>
        <input type="date" name="date_of_birth" id="date_of_birth"
               value="<?= htmlspecialchars($family_member["date_of_birth"]) ?>"><br>

        <label for="social_security_number">SSN</label><br>
        <input type="text" name="social_security_number" id="social_security_number"
               value="<?= htmlspecialchars($family_member["social_security_number"]) ?>"><br>

        <label for="medical_card_number">Medical Card Number</label><br>
        <input type="text" name="medical_card_number" id="medical_card_number"
               value="<?= htmlspecialchars($family_member["medical_card_number"]) ?>"><br>

        <label for="phone_number">Phone Number</label><br>
        <input type="text" name="phone_number" id="phone_number"
               value="<?= htmlspecialchars($family_member["phone_number"]) ?>"><br>

        <label for="address">Address</label><br>
        <input type="text" name="address" id="address"
               value="<?= htmlspecialchars($family_member["address"]) ?>"><br>

        <label for="city">City</label><br>
        <input type="text" name="city" id="city"
               value="<?= htmlspecialchars($family_member["city"]) ?>"><br>

        <label for="province">Province</label><br>
        <input type="text" name="province" id="province"
               value="<?= htmlspecialchars($family_member["province"]) ?>"><br>

        <label for="postal_code">Postal Code</label><br>
        <input type="text" name="postal_code" id="postal_code"
               value="<?= htmlspecialchars($family_member["postal_code"]) ?>"><br>

        <label for="email_address">Email Address</label><br>
        <input type="text" name="email_address" id="email_address"
               value="<?= htmlspecialchars($family_member["email_address"]) ?>"><br>

        <label for="location_id">Location ID</label><br>
        <input type="number" name="location_id" id="location_id"
               value="<?= htmlspecialchars($family_member["location_id"]) ?>"><br>

        <label for="secondary_id">Secondary ID</label><br>
        <input type="number" name="secondary_id" id="secondary_id"
               value="<?= htmlspecialchars($family_member["secondary_id"]) ?>"><br><br>

        <button type="submit">Update Family Member</button>
    </form>

    <!-- Link back to your listing page or elsewhere -->
    <a href="./">Back to Family Member List</a>
</body>
</html>
