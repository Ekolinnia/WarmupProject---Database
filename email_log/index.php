<?php // index.php - List of Email Logs
require_once("../database.php");
$statement = $conn->prepare("SELECT * FROM Email_Log");
$statement->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Email Logs</title>
</head>

<body>
    <h1>Email Logs</h1>
    <a href="../">Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email ID</th>
                <th>Date</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Subject</th>
                <th>Preview</th>
                <th>Status</th>
                <th>Sunday ID</th>
                <th>Deactivation ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['email_log_id'] ?></td>
                    <td><?= $row['email_id'] ?></td>
                    <td><?= $row['email_date'] ?></td>
                    <td><?= $row['sender_id'] ?></td>
                    <td><?= $row['recipient_id'] ?></td>
                    <td><?= $row['subject'] ?></td>
                    <td><?= $row['body_preview'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['sunday_email_id'] ?></td>
                    <td><?= $row['deactivation_email_id'] ?></td>
                    <td>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>