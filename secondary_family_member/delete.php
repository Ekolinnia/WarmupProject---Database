<?php
require_once("../database.php");

// 1. Check that famID and secondary_fm_id are present
if (!isset($_GET['famID']) || !isset($_GET['secondary_fm_id'])) {
    echo "Missing parameters (famID or secondary_fm_id).";
    exit();
}

$famID = $_GET['famID'];
$secondary_fm_id = $_GET['secondary_fm_id'];

// 2. Perform the delete
try {
    $stmt = $conn->prepare("DELETE FROM Secondary_family_member WHERE secondary_fm_id = :secondary_fm_id");
    $stmt->bindParam(':secondary_fm_id', $secondary_fm_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the index for this famID
    header("Location: index.php?famID=" . urlencode($famID));
    exit();
} catch (PDOException $e) {
    echo "Error deleting secondary family member: " . $e->getMessage();
}
?>
