<?php
require_once("../database.php");

// 1. Check that famID and secondary_fm_id are present
if (!isset($_GET['famID']) || !isset($_GET['secondary_fm_id'])) {
    echo "Missing parameters (famID or secondary_fm_id).";
    exit();
}

$famID = $_GET['famID'];
$secondary_fm_id = $_GET['secondary_fm_id'];

// 2. Fetch the existing record
try {
    $stmt = $conn->prepare("
        SELECT * 
        FROM Secondary_family_member
        WHERE secondary_fm_id = :secondary_fm_id
    ");
    $stmt->bindParam(':secondary_fm_id', $secondary_fm_id, PDO::PARAM_INT);
    $stmt->execute();
    $secondaryMember = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$secondaryMember) {
        echo "Secondary family member not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching secondary family member: " . $e->getMessage();
    exit();
}

// 3. If form submitted, process updates
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["telephone_number"])) {
        echo "Please fill in all required fields.";
    } else {
        try {
            $updateStmt = $conn->prepare("
                UPDATE Secondary_family_member
                SET first_name = :first_name,
                    last_name = :last_name,
                    telephone_number = :telephone_number
                WHERE secondary_fm_id = :secondary_fm_id
            ");
            $updateStmt->bindParam(':first_name', $_POST['first_name']);
            $updateStmt->bindParam(':last_name', $_POST['last_name']);
            $updateStmt->bindParam(':telephone_number', $_POST['telephone_number']);
            $updateStmt->bindParam(':secondary_fm_id', $secondary_fm_id, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                // Redirect back to the index for this famID
                header("Location: index.php?famID=" . urlencode($famID));
                exit();
            } else {
                echo "Error updating record.";
            }
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Secondary Family Member</title>
</head>
<body>
    <h1>Edit Secondary Family Member #<?= htmlspecialchars($secondary_fm_id) ?></h1>

    <form method="POST">
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" id="first_name"
               value="<?= htmlspecialchars($secondaryMember['first_name']) ?>"><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" id="last_name"
               value="<?= htmlspecialchars($secondaryMember['last_name']) ?>"><br><br>

        <label for="telephone_number">Telephone Number:</label><br>
        <input type="text" name="telephone_number" id="telephone_number"
               value="<?= htmlspecialchars($secondaryMember['telephone_number']) ?>"><br><br>

        <button type="submit">Update</button>
    </form>

    <p>
        <a href="index.php?famID=<?= htmlspecialchars($famID) ?>">Back to Secondary Family Members</a>
    </p>
</body>
</html>
