<?php
require_once '../database.php';

if (isset($_GET['famID'])) {
    // Prepare the query to fetch all history records for the given famID
    $statement = $conn->prepare("SELECT * FROM Family_member_history WHERE famID = :famID");
    $statement->bindParam(":famID", $_GET["famID"], PDO::PARAM_INT);
    $statement->execute();
} else {
    echo "famID not provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History of Family Member</title>
</head>
<body>
    <h1>History of Family Member</h1>
    <a href="./">Back to List</a>

    <table border="1">
        <thead>
            <tr>
                <th>LocationID</th>
                <th>famID</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["LocationID"] ?></td>
                    <td><?= $row["famID"] ?></td>
                    <td><?= $row["start_date"] ?></td>
                    <td><?= $row["end_date"] ?></td>
                    <td>
                        <a href="./delete.php?HistoryID=<?= $row["HistoryID"] ?>">Delete</a>
                        <a href="./edit.php?HistoryID=<?= $row["HistoryID"] ?>">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="./create.php">Add a Record</a>
</body>
</html>
