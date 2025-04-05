<?php
require_once '../database.php';

if (!isset($_GET['PaymentID'])) {
    echo "No PaymentID specified.";
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM Payments WHERE PaymentID = :pid");
    $stmt->bindParam(':pid', $_GET['PaymentID'], PDO::PARAM_INT);
    $stmt->execute();

    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "Error deleting payment: " . $e->getMessage();
    echo "<br><a href='index.php'>Back to Payments</a>";
}
?>
