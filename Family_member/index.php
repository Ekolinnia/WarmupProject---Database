<?php require_once("../database.php");

// Fetch all rows from the Family_member table
$statement = $conn->prepare("SELECT * FROM Family_member");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Family Members</title>
</head>
<body>
    <h1>List of Family Members</h1>
    <a href="../">Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Columns in Family_member -->
                <th>famID</th>
                <th>first_name</th>
                <th>last_name</th>
                <th>date_of_birth</th>
                <th>social_security_number</th>
                <th>medical_card_number</th>
                <th>phone_number</th>
                <th>address</th>
                <th>city</th>
                <th>province</th>
                <th>postal_code</th>
                <th>email_address</th>
                <th>location_id</th>
                <th>secondary_id</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["famID"] ?></td>
                    <td><?= $row["first_name"] ?></td>
                    <td><?= $row["last_name"] ?></td>
                    <td><?= $row["date_of_birth"] ?></td>
                    <td><?= $row["social_security_number"] ?></td>
                    <td><?= $row["medical_card_number"] ?></td>
                    <td><?= $row["phone_number"] ?></td>
                    <td><?= $row["address"] ?></td>
                    <td><?= $row["city"] ?></td>
                    <td><?= $row["province"] ?></td>
                    <td><?= $row["postal_code"] ?></td>
                    <td><?= $row["email_address"] ?></td>
                    <td><?= $row["location_id"] ?></td>
                    <td><?= $row["secondary_id"] ?></td>
                    <td>
                        <a href="./delete.php?famID=<?= $row["famID"] ?>">Delete</a>
                        <a href="./edit.php?famID=<?= $row["famID"] ?>">Edit</a>
                        <!-- If you have a show.php or similar page, link it here -->
                        <a href="./show.php?famID=<?= $row["famID"] ?>">Show</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <a href="./create.php">Add a Family Member</a>
</body>
</html>
