<?php require_once("../database.php");

// If user didn't input necessary fields, prompt them
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["location_id"]) || empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["date_of_birth"]) ||
        empty($_POST["social_security_number"]) || empty($_POST["medical_card_number"]) || empty($_POST["phone_number"]) ||
        empty($_POST["address"]) || empty($_POST["city"]) || empty($_POST["province"]) || empty($_POST["postal_code"]) ||
        empty($_POST["gender"]) || empty($_POST["membership_start_date"])
    ) {
        echo "Missing fields, please fill in all required fields!";
    }
}

// Fetch member data for pre-filling
$statement = $conn->prepare("SELECT * FROM Club_member WHERE memberID = :memberID");
$statement->bindParam(":memberID", $_GET["memberID"], PDO::PARAM_INT);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);

// If form submitted and all required fields are set, update
if (
    isset($_POST["location_id"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) &&
    isset($_POST["date_of_birth"]) && isset($_POST["social_security_number"]) && isset($_POST["medical_card_number"]) &&
    isset($_POST["phone_number"]) && isset($_POST["address"]) && isset($_POST["city"]) &&
    isset($_POST["province"]) && isset($_POST["postal_code"]) && isset($_POST["gender"]) && isset($_POST["membership_start_date"])
) {
    $update = $conn->prepare("UPDATE Club_member SET 
        location_id = :location_id, 
        family_member_id = :family_member_id,
        first_name = :first_name, 
        last_name = :last_name, 
        date_of_birth = :date_of_birth,
        age = :age,
        height = :height,
        weight = :weight,
        social_security_number = :social_security_number,
        medical_card_number = :medical_card_number, 
        phone_number = :phone_number,
        address = :address, 
        city = :city, 
        province = :province, 
        postal_code = :postal_code, 
        relationship = :relationship,
        status = :status,
        secondary_fm_id = :secondary_fm_id,
        relationship2 = :relationship2,
        gender = :gender,
        membership_start_date = :membership_start_date
    WHERE memberID = :memberID");

    $update->bindParam(":location_id", $_POST["location_id"]);
    $update->bindParam(":family_member_id", $_POST["family_member_id"]);
    $update->bindParam(":first_name", $_POST["first_name"]);
    $update->bindParam(":last_name", $_POST["last_name"]);
    $update->bindParam(":date_of_birth", $_POST["date_of_birth"]);
    $update->bindParam(":age", $_POST["age"]);
    $update->bindParam(":height", $_POST["height"]);
    $update->bindParam(":weight", $_POST["weight"]);
    $update->bindParam(":social_security_number", $_POST["social_security_number"]);
    $update->bindParam(":medical_card_number", $_POST["medical_card_number"]);
    $update->bindParam(":phone_number", $_POST["phone_number"]);
    $update->bindParam(":address", $_POST["address"]);
    $update->bindParam(":city", $_POST["city"]);
    $update->bindParam(":province", $_POST["province"]);
    $update->bindParam(":postal_code", $_POST["postal_code"]);
    $update->bindParam(":relationship", $_POST["relationship"]);
    $update->bindParam(":status", $_POST["status"]);
    $update->bindParam(":secondary_fm_id", $_POST["secondary_fm_id"]);
    $update->bindParam(":relationship2", $_POST["relationship2"]);
    $update->bindParam(":gender", $_POST["gender"]);
    $update->bindParam(":membership_start_date", $_POST["membership_start_date"]);
    $update->bindParam(":memberID", $_GET["memberID"]);

    if ($update->execute()) {
        header("Location: ./");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Club Member</title>
</head>

<body>
    <h1>Update Club Member</h1>

    <form action="edit.php?memberID=<?= $_GET['memberID'] ?>" method="post">

        <label>Location ID</label><br>
        <input type="number" name="location_id" value="<?= $member["location_id"] ?>"><br>

        <label>Family Member ID</label><br>
        <input type="number" name="family_member_id" value="<?= $member["family_member_id"] ?>"><br>

        <label>First Name</label><br>
        <input type="text" name="first_name" value="<?= $member["first_name"] ?>"><br>

        <label>Last Name</label><br>
        <input type="text" name="last_name" value="<?= $member["last_name"] ?>"><br>

        <label>Date of Birth</label><br>
        <input type="date" name="date_of_birth" value="<?= $member["date_of_birth"] ?>"><br>

        <label>Age</label><br>
        <input type="number" name="age" value="<?= $member["age"] ?>"><br>

        <label>Height (cm)</label><br>
        <input type="number" name="height" value="<?= $member["height"] ?>"><br>

        <label>Weight (kg)</label><br>
        <input type="number" name="weight" value="<?= $member["weight"] ?>"><br>

        <label>Gender</label><br>
        <select name="gender">
            <option value="f" <?= $member["gender"] === "f" ? "selected" : "" ?>>Female</option>
            <option value="m" <?= $member["gender"] === "m" ? "selected" : "" ?>>Male</option>
        </select><br>

        <label>Social Security Number</label><br>
        <input type="text" name="social_security_number" value="<?= $member["social_security_number"] ?>"><br>

        <label>Medical Card Number</label><br>
        <input type="text" name="medical_card_number" value="<?= $member["medical_card_number"] ?>"><br>

        <label>Phone Number</label><br>
        <input type="text" name="phone_number" value="<?= $member["phone_number"] ?>"><br>

        <label>Address</label><br>
        <input type="text" name="address" value="<?= $member["address"] ?>"><br>

        <label>City</label><br>
        <input type="text" name="city" value="<?= $member["city"] ?>"><br>

        <label>Province</label><br>
        <input type="text" name="province" value="<?= $member["province"] ?>"><br>

        <label>Postal Code</label><br>
        <input type="text" name="postal_code" value="<?= $member["postal_code"] ?>"><br>

        <label>Relationship</label><br>
        <select name="relationship">
            <?php
            $relationships = ['Father', 'Mother', 'Grandfather', 'Grandmother', 'Tutor', 'Partner', 'Friend', 'Other'];
            foreach ($relationships as $r) {
                echo "<option value=\"$r\" " . ($member["relationship"] === $r ? "selected" : "") . ">$r</option>";
            }
            ?>
        </select><br>

        <label>Status</label><br>
        <select name="status">
            <option value="Active" <?= $member["status"] === "Active" ? "selected" : "" ?>>Active</option>
            <option value="Inactive" <?= $member["status"] === "Inactive" ? "selected" : "" ?>>Inactive</option>
        </select><br>

        <label>Secondary Family Member ID</label><br>
        <input type="number" name="secondary_fm_id" value="<?= $member["secondary_fm_id"] ?>"><br>

        <label>Secondary Relationship</label><br>
        <select name="relationship2">
            <?php
            foreach ($relationships as $r) {
                echo "<option value=\"$r\" " . ($member["relationship2"] === $r ? "selected" : "") . ">$r</option>";
            }
            ?>
        </select><br>

        <label>Membership Start Date</label><br>
        <input type="date" name="membership_start_date" value="<?= $member["membership_start_date"] ?>"><br><br>

        <button type="submit">Update Member</button>
    </form>

    <a href="./">Back to Member List</a>
</body>

</html>