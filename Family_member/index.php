<?php
require_once("../database.php");

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
                    <td><?= htmlspecialchars($row["famID"]) ?></td>
                    <td><?= htmlspecialchars($row["first_name"]) ?></td>
                    <td><?= htmlspecialchars($row["last_name"]) ?></td>
                    <td><?= htmlspecialchars($row["date_of_birth"]) ?></td>
                    <td><?= htmlspecialchars($row["social_security_number"]) ?></td>
                    <td><?= htmlspecialchars($row["medical_card_number"]) ?></td>
                    <td><?= htmlspecialchars($row["phone_number"]) ?></td>
                    <td><?= htmlspecialchars($row["address"]) ?></td>
                    <td><?= htmlspecialchars($row["city"]) ?></td>
                    <td><?= htmlspecialchars($row["province"]) ?></td>
                    <td><?= htmlspecialchars($row["postal_code"]) ?></td>
                    <td><?= htmlspecialchars($row["email_address"]) ?></td>
                    <td><?= htmlspecialchars($row["location_id"]) ?></td>
                    <td><?= htmlspecialchars($row["secondary_id"]) ?></td>
                    <td>
                        <a href="./delete.php?famID=<?= $row["famID"] ?>">Delete</a>
                        <a href="./edit.php?famID=<?= $row["famID"] ?>">Edit</a>
                        <a href="./show.php?famID=<?= $row["famID"] ?>">Show</a>
                        <!-- Link to manage secondary family members -->
                        <a href="../secondary_family_member/index.php?famID=<?= $row["famID"] ?>">Manage Secondary Family
                            Members</a>
                        <!-- Direct link to add a new secondary family member -->
                        <a href="../secondary_family_member/create.php?famID=<?= $row["famID"] ?>">Add Secondary Family
                            Member</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <a href="./create.php">Add a Family Member</a>
</body>

</html>