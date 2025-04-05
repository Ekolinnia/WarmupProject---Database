<?php
require_once '../database.php';

if (!isset($_GET['PaymentID'])) {
    echo "No PaymentID specified.";
    exit();
}

try {
    // Join with Club_member to show the member’s name
    $stmt = $conn->prepare("
        SELECT p.*, c.first_name, c.last_name
        FROM Payments p
        JOIN Club_member c ON p.memberID = c.memberID
        WHERE p.PaymentID = :pid
    ");
    $stmt->bindParam(':pid', $_GET['PaymentID'], PDO::PARAM_INT);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$payment) {
        echo "Payment not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error retrieving payment: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Show Payment</title>
</head>
<body>
    <h1>Payment Details</h1>
    <p><strong>Payment ID:</strong> <?= htmlspecialchars($payment['PaymentID']) ?></p>
    <p><strong>Member:</strong> 
       <?= htmlspecialchars($payment['first_name'] . " " . $payment['last_name']) ?>
       (ID: <?= htmlspecialchars($payment['memberID']) ?>)
    </p>
    <p><strong>Date:</strong> <?= htmlspecialchars($payment['PaymentDate']) ?></p>
    <p><strong>Amount:</strong> <?= htmlspecialchars($payment['Amount']) ?></p>
    <p><strong>Method:</strong> <?= htmlspecialchars($payment['PaymentMethod']) ?></p>
    <p><strong>Year:</strong> <?= htmlspecialchars($payment['PaymentYear']) ?></p>

    <br>
    <a href="edit.php?PaymentID=<?= $payment['PaymentID'] ?>">Edit</a> |
    <a href="delete.php?PaymentID=<?= $payment['PaymentID'] ?>"
       onclick="return confirm('Are you sure you want to delete this payment?');">
       Delete
    </a> |
    <a href="index.php">Back to Payments</a>
</body>
</html>
