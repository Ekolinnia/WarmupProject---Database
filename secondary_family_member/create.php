<?php
require_once("../database.php");

// 1. Ensure famID is present in the URL
if (!isset($_GET['famID'])) {
    echo "No famID specified.";
    exit();
}

$famID = $_GET['famID'];

// 2. If the form is submitted, process it
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate required fields
    if (empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["telephone_number"])) {
        echo "Please fill in all required fields (first name, last name, telephone).";
    } else {
        try {
            // Insert the new secondary family member
            $stmt = $conn->prepare("
                INSERT INTO Secondary_family_member (first_name, last_name, telephone_number, famID)
                VALUES (:first_name, :last_name, :telephone_number, :famID)
            ");
            $stmt->bindParam(':first_name', $_POST['first_name']);
            $stmt->bindParam(':last_name', $_POST['last_name']);
            $stmt->bindParam(':telephone_number', $_POST['telephone_number']);
            $stmt->bindParam(':famID', $famID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Redirect back to the index for this famID
                header("Location: index.php?famID=" . urlencode($famID));
                exit();
            }
        } catch (PDOException $e) {
            echo "Error creating secondary family member: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Secondary Family Member</title>
</head>
<body>
    <h1>Add Secondary Family Member for Family Member #<?= htmlspecialchars($famID) ?></h1>

    <form method="POST">
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" id="first_name"><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" id="last_name"><br><br>

        <label for="telephone_number">Telephone Number:</label><br>
        <input type="text" name="telephone_number" id="telephone_number"><br><br>

        <!-- famID is already known from GET, so we don't need an extra input for it -->

        <button type="submit">Create Secondary Family Member</button>
    </form>

    <p>
        <a href="index.php?famID=<?= htmlspecialchars($famID) ?>">Back to Secondary Family Members</a>
    </p>
</body>
</html>
