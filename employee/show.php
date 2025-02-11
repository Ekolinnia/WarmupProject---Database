<?php
require_once '../database.php';

if (isset($_GET['EmployeeID'])) {
    // Prepare the query to fetch all work history records for the given EmployeeID
    $statement = $conn->prepare("SELECT * FROM Employee_history WHERE EmployeeID = :EmployeeID");
    $statement->bindParam(":EmployeeID", $_GET["EmployeeID"], PDO::PARAM_INT);
    $statement->execute();
} else {
    echo "EmployeeID not provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work History of Employee</title>
</head>

<body>
    <h1>Work History of Employee</h1>
    <a href="./">Back to List</a>

    <table border="1">
        <thead>
            <tr>
                <th>LocationID</th>
                <th>EmployeeID</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>

            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["LocationID"] ?></td>
                    <td><?= $row["EmployeeID"] ?></td>
                    <td><?= $row["start_date"] ?></td>
                    <td><?= $row["end_date"] ?></td>
                    <td>
                        <a href="./delete.php?ContractID=<?= $row["ContractID"] ?>">Delete</a>
                        <a href="./edit.php?ContractID=<?= $row["ContractID"] ?>">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="./create.php">Add a date</a>
</body>

</html>