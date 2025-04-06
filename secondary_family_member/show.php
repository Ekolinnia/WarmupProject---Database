<?php
require_once("../database.php");

// 1. Check that famID and secondary_fm_id are present
if (!isset($_GET['famID']) || !isset($_GET['secondary_fm_id'])) {
    echo "Missing parameters (famID or secondary_fm_id).";
    exit();
}

$famID = $_GET['famID'];
$secondary_fm_id = $_GET['secondary_fm_id'];

// 2. Fetch the record
try {
    $stmt = $conn->prepare("
        SELECT *
        FROM Secondary_family_member
        WHERE secondary_fm_id = :secondary_fm_id
    ");
    $stmt->bindParam(':secondary_fm_id', $secondary_fm_id, PDO::PARAM_INT);
    $stmt->execute();
    $sfm = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sfm) {
        echo "Secondary family member not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching record: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Show Secondary Family Member</title>
</head>
<body>
    <h1>Secondary Family Member Details</h1>

    <p><strong>ID:</strong> <?= htmlspecialchars($sfm['secondary_fm_id']) ?></p>
    <p><strong>First Name:</strong> <?= htmlspecialchars($sfm['first_name']) ?></p>
    <p><strong>Last Name:</strong> <?= htmlspecialchars($sfm['last_name']) ?></p>
    <p><strong>Telephone Number:</strong> <?= htmlspecialchars($sfm['telephone_number']) ?></p>
    <p><strong>famID:</strong> <?= htmlspecialchars($sfm['famID']) ?></p>

    <p>
        <a href="edit.php?secondary_fm_id=<?= $sfm['secondary_fm_id'] ?>&famID=<?= $famID ?>">Edit</a> |
        <a href="delete.php?secondary_fm_id=<?= $sfm['secondary_fm_id'] ?>&famID=<?= $famID ?>"
           onclick="return confirm('Are you sure you want to delete this record?');">Delete</a> |
        <a href="index.php?famID=<?= htmlspecialchars($famID) ?>">Back to Secondary Family Members</a>
    </p>
</body>
</html>
