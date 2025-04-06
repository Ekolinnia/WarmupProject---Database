<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Club_member");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Club Members</title>
</head>

<body>
    <h1>List of Club Members</h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of Employees -->
                <th>memberID</th>
                <th>family_member_id</th>
                <th>first_name</th>
                <th>last_name</th>
                <th>date_of_birth</th>
                <th>age</th>
                <th>height</th>
                <th>weight</th>
                <th>social_security_number</th>
                <th>medical_card_number</th>
                <th>phone_number</th>
                <th>address</th>
                <th>city</th>
                <th>province</th>
                <th>postal_code</th>
                <th>relationship</th>
                <th>location_id</th>
                <th>status</th>
                <th>secondary_fm_id</th>
                <th>relationship2</th>
                <th>gender</th>
                <th>membership_start_date</th>

            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["memberID"] ?></td>
                    <td><?= $row["family_member_id"] ?></td>
                    <td><?= $row["first_name"] ?></td>
                    <td><?= $row["last_name"] ?></td>
                    <td><?= $row["date_of_birth"] ?></td>
                    <td><?= $row["age"] ?></td>
                    <td><?= $row["height"] ?></td>
                    <td><?= $row["weight"] ?></td>
                    <td><?= $row["social_security_number"] ?></td>
                    <td><?= $row["medical_card_number"] ?></td>
                    <td><?= $row["phone_number"] ?></td>
                    <td><?= $row["address"] ?></td>
                    <td><?= $row["city"] ?></td>
                    <td><?= $row["province"] ?></td>
                    <td><?= $row["postal_code"] ?></td>
                    <td><?= $row["relationship"] ?></td>
                    <td><?= $row["location_id"] ?></td>
                    <td><?= $row["status"] ?></td>
                    <td><?= $row["secondary_fm_id"] ?></td>
                    <td><?= $row["relationship2"] ?></td>
                    <td><?= $row["gender"] ?></td>
                    <td><?= $row["membership_start_date"] ?></td>
                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?memberID=<?= $row["memberID"] ?>">Delete</a>
                        <a href="./edit.php?memberID=<?= $row["memberID"] ?>">Edit</a>

                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add an Club_member</a>

</body>

</html>