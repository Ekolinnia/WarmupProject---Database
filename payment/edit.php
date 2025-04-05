<?php
require_once '../database.php';

if (!isset($_GET['PaymentID'])) {
    echo "No PaymentID specified.";
    exit();
}

// 1. Fetch the existing Payment record
try {
    $stmt = $conn->prepare("
        SELECT *
        FROM Payments
        WHERE PaymentID = :pid
    ");
    $stmt->bindParam(':pid', $_GET['PaymentID'], PDO::PARAM_INT);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$payment) {
        echo "Payment not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching payment: " . $e->getMessage();
    exit();
}

// 2. Fetch members for the dropdown
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

// 3. Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $updateStmt = $conn->prepare("
                UPDATE Payments
                SET memberID = :memberID,
                    PaymentDate = :PaymentDate,
                    Amount = :Amount,
                    PaymentMethod = :PaymentMethod,
                    PaymentYear = :PaymentYear
                WHERE PaymentID = :pid
            ");
            $updateStmt->bindParam(':memberID', $_POST['memberID'], PDO::PARAM_INT);
            $updateStmt->bindParam(':PaymentDate', $_POST['PaymentDate']);
            $updateStmt->bindParam(':Amount', $_POST['Amount']);
            $updateStmt->bindParam(':PaymentMethod', $_POST['PaymentMethod']);
            $updateStmt->bindParam(':PaymentYear', $_POST['PaymentYear'], PDO::PARAM_INT);
            $updateStmt->bindParam(':pid', $_GET['PaymentID'], PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error updating payment.";
            }
        } catch (PDOException $e) {
            echo "Error updating payment: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Payment</title>
</head>
<body>
    <h1>Edit Payment</h1>
    <form method="POST">
        <label for="memberID">Member:</label><br>
        <select name="memberID" id="memberID" required>
            <option value="">-- Select Member --</option>
            <?php foreach ($members as $m): ?>
                <option value="<?= $m['memberID'] ?>"
                    <?= ($m['memberID'] == $payment['memberID']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['last_name'] . ", " . $m['first_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="PaymentDate">Payment Date:</label><br>
        <input type="date" name="PaymentDate" id="PaymentDate"
               value="<?= htmlspecialchars($payment['PaymentDate']) ?>" required><br><br>

        <label for="Amount">Amount:</label><br>
        <input type="number" step="0.01" name="Amount" id="Amount"
               value="<?= htmlspecialchars($payment['Amount']) ?>" required><br><br>

        <label for="PaymentMethod">Payment Method:</label><br>
        <select name="PaymentMethod" id="PaymentMethod" required>
            <option value="Cash"        <?= ($payment['PaymentMethod'] === 'Cash')        ? 'selected' : '' ?>>Cash</option>
            <option value="Debit"       <?= ($payment['PaymentMethod'] === 'Debit')       ? 'selected' : '' ?>>Debit</option>
            <option value="Credit Card" <?= ($payment['PaymentMethod'] === 'Credit Card') ? 'selected' : '' ?>>Credit Card</option>
        </select>
        <br><br>

        <label for="PaymentYear">Payment Year:</label><br>
        <input type="number" name="PaymentYear" id="PaymentYear"
               value="<?= htmlspecialchars($payment['PaymentYear']) ?>" required><br><br>

        <button type="submit">Update Payment</button>
    </form>

    <br>
    <a href="index.php">Back to Payments</a>
</body>
</html>
