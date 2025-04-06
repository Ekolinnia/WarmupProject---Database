<?php
require_once '../database.php';

// 1. Fetch all members from Club_member to populate a dropdown
try {
    $membersStmt = $conn->query("
        SELECT memberID, first_name, last_name
        FROM Club_member
        ORDER BY last_name, first_name
    ");
    $members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching members: " . $e->getMessage();
    exit();
}

// 2. Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    if (
        empty($_POST['memberID']) ||
        empty($_POST['PaymentDate']) ||
        empty($_POST['Amount']) ||
        empty($_POST['PaymentMethod']) ||
        empty($_POST['PaymentYear'])
    ) {
        echo "Please fill in all required fields.";
    } else {
        try {
            // Insert the new payment
            $stmt = $conn->prepare("
                INSERT INTO Payments (memberID, PaymentDate, Amount, PaymentMethod, PaymentYear)
                VALUES (:memberID, :PaymentDate, :Amount, :PaymentMethod, :PaymentYear)
            ");
            $stmt->bindParam(':memberID', $_POST['memberID'], PDO::PARAM_INT);
            $stmt->bindParam(':PaymentDate', $_POST['PaymentDate']);
            $stmt->bindParam(':Amount', $_POST['Amount']);
            $stmt->bindParam(':PaymentMethod', $_POST['PaymentMethod']);
            $stmt->bindParam(':PaymentYear', $_POST['PaymentYear'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Success: go back to index
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            // If your trigger or FK fails, the DB will throw an error
            echo "Error inserting payment: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Payment</title>
</head>
<body>
    <h1>Create Payment</h1>
    <form method="POST">
        <label for="memberID">Member:</label><br>
        <select name="memberID" id="memberID" required>
            <option value="">-- Select Member --</option>
            <?php foreach ($members as $m): ?>
                <option value="<?= $m['memberID'] ?>">
                    <?= htmlspecialchars($m['last_name'] . ", " . $m['first_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="PaymentDate">Payment Date:</label><br>
        <input type="date" name="PaymentDate" id="PaymentDate" required><br><br>

        <label for="Amount">Amount:</label><br>
        <input type="number" step="0.01" name="Amount" id="Amount" required><br><br>

        <label for="PaymentMethod">Payment Method:</label><br>
        <select name="PaymentMethod" id="PaymentMethod" required>
            <option value="">-- Select Method --</option>
            <option value="Cash">Cash</option>
            <option value="Debit">Debit</option>
            <option value="Credit Card">Credit Card</option>
        </select>
        <br><br>

        <label for="PaymentYear">Payment Year:</label><br>
        <input type="number" name="PaymentYear" id="PaymentYear" required><br><br>

        <button type="submit">Create Payment</button>
    </form>

    <br>
    <a href="index.php">Back to Payments</a>
</body>
</html>
