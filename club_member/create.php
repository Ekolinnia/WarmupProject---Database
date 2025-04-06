<?php require_once("../database.php");

// If user submits the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic validation (add more as needed)
    $requiredFields = ["first_name", "last_name", "date_of_birth", "social_security_number", "medical_card_number", "phone_number", "address", "city", "province", "postal_code", "gender", "membership_start_date"];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo "Missing fields, please fill in all required fields!";
            exit();
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO Club_member (
            family_member_id, first_name, last_name, date_of_birth, age, height, weight, social_security_number, 
            medical_card_number, phone_number, address, city, province, postal_code, relationship, 
            location_id, status, secondary_fm_id, relationship2, gender, membership_start_date
        ) VALUES (
            :family_member_id, :first_name, :last_name, :date_of_birth, :age, :height, :weight, :social_security_number, 
            :medical_card_number, :phone_number, :address, :city, :province, :postal_code, :relationship, 
            :location_id, :status, :secondary_fm_id, :relationship2, :gender, :membership_start_date
        )");

        $stmt->execute([
            ":family_member_id" => $_POST["family_member_id"] ?? null,
            ":first_name" => $_POST["first_name"],
            ":last_name" => $_POST["last_name"],
            ":date_of_birth" => $_POST["date_of_birth"],
            ":age" => $_POST["age"] ?? null,
            ":height" => $_POST["height"] ?? null,
            ":weight" => $_POST["weight"] ?? null,
            ":social_security_number" => $_POST["social_security_number"],
            ":medical_card_number" => $_POST["medical_card_number"],
            ":phone_number" => $_POST["phone_number"],
            ":address" => $_POST["address"],
            ":city" => $_POST["city"],
            ":province" => $_POST["province"],
            ":postal_code" => $_POST["postal_code"],
            ":relationship" => $_POST["relationship"] ?? null,
            ":location_id" => $_POST["location_id"] ?? null,
            ":status" => $_POST["status"] ?? "Active",
            ":secondary_fm_id" => $_POST["secondary_fm_id"] ?? null,
            ":relationship2" => $_POST["relationship2"] ?? null,
            ":gender" => $_POST["gender"],
            ":membership_start_date" => $_POST["membership_start_date"]
        ]);

        header("Location: ./");
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Club Member</title>
</head>

<body>
    <h1>Add Club Member</h1>

    <form action="./create.php" method="post">
        <label>First Name:</label><br>
        <input type="text" name="first_name"><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name"><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="date_of_birth"><br>

        <label>Age:</label><br>
        <input type="number" name="age"><br>

        <label>Height (cm):</label><br>
        <input type="number" name="height"><br>

        <label>Weight (kg):</label><br>
        <input type="number" name="weight"><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="">-- Select Gender --</option>
            <option value="f">Female</option>
            <option value="m">Male</option>
        </select><br>


        <label>SSN:</label><br>
        <input type="text" name="social_security_number"><br>

        <label>Medical Card Number:</label><br>
        <input type="text" name="medical_card_number"><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone_number"><br>

        <label>Address:</label><br>
        <input type="text" name="address"><br>

        <label>City:</label><br>
        <input type="text" name="city"><br>

        <label>Province:</label><br>
        <input type="text" name="province"><br>

        <label>Postal Code:</label><br>
        <input type="text" name="postal_code"><br>

        <label>Relationship:</label><br>
        <select name="relationship" required>
            <option value="">-- Select Relationship --</option>
            <option value="Father">Father</option>
            <option value="Mother">Mother</option>
            <option value="Grandfather">Grandfather</option>
            <option value="Grandmother">Grandmother</option>
            <option value="Tutor">Tutor</option>
            <option value="Partner">Partner</option>
            <option value="Friend">Friend</option>
            <option value="Other">Other</option>
        </select><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br>

        <label>Family Member ID:</label><br>
        <input type="number" name="family_member_id"><br>

        <label>Location ID:</label><br>
        <input type="number" name="location_id"><br>

        <label>Secondary Family Member ID:</label><br>
        <input type="number" name="secondary_fm_id"><br>

        <label>Secondary Relationship:</label><br>
        <select name="relationship" required>
            <option value="">-- Select Relationship --</option>
            <option value="Father">Father</option>
            <option value="Mother">Mother</option>
            <option value="Grandfather">Grandfather</option>
            <option value="Grandmother">Grandmother</option>
            <option value="Tutor">Tutor</option>
            <option value="Partner">Partner</option>
            <option value="Friend">Friend</option>
            <option value="Other">Other</option>
        </select><br>

        <label>Membership Start Date:</label><br>
        <input type="date" name="membership_start_date"><br><br>

        <button type="submit">Add Member</button>
    </form>

    <a href="./">Back to Member List</a>
</body>

</html>