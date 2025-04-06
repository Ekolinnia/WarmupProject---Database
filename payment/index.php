<?php
require_once '../database.php';  // Adjust path as needed

try {
    // Join with Club_member to show the member’s name
    $stmt = $conn->query("
        SELECT p.*, c.first_name, c.last_name
        FROM Payments p
        JOIN Club_member c ON p.memberID = c.memberID
        ORDER BY p.PaymentDate DESC
    ");
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error retrieving payments: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments</title>
</head>
<body>
    <h1>All Payments</h1>
    <p><a href="create.php">Add New Payment</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Member</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($payments as $pay): ?>
            <tr>
                <td><?= htmlspecialchars($pay['PaymentID']) ?></td>
                <td>
                    <?= htmlspecialchars($pay['first_name'] . " " . $pay['last_name']) ?>
                    (ID: <?= htmlspecialchars($pay['memberID']) ?>)
                </td>
                <td><?= htmlspecialchars($pay['PaymentDate']) ?></td>
                <td><?= htmlspecialchars($pay['Amount']) ?></td>
                <td><?= htmlspecialchars($pay['PaymentMethod']) ?></td>
                <td><?= htmlspecialchars($pay['PaymentYear']) ?></td>
                <td>
                    <a href="show.php?PaymentID=<?= $pay['PaymentID'] ?>">Show</a> |
                    <a href="edit.php?PaymentID=<?= $pay['PaymentID'] ?>">Edit</a> |
                    <a href="delete.php?PaymentID=<?= $pay['PaymentID'] ?>"
                       onclick="return confirm('Are you sure you want to delete this payment?');">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="../index.php">Back to Main Menu</a>
</body>
</html>
