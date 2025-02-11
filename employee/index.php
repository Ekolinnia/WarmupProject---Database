<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Employee");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Locations</title>
</head>

<body>
    <h1>List of Employees</h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of Employees -->
                <th>LocationID</th>
                <th>EmployeeID</th>
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
                <th>role</th>
                <th>mandate</th>

            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["LocationID"] ?> </td>
                    <td><?= $row["EmployeeID"] ?> </td>
                    <td><?= $row["first_name"] ?> </td>
                    <td><?= $row["last_name"] ?> </td>
                    <td><?= $row["date_of_birth"] ?> </td>
                    <td><?= $row["social_security_number"] ?> </td>
                    <td><?= $row["medical_card_number"] ?> </td>
                    <td><?= $row["phone_number"] ?> </td>
                    <td><?= $row["address"] ?> </td>
                    <td><?= $row["city"] ?> </td>
                    <td><?= $row["province"] ?> </td>
                    <td><?= $row["postal_code"] ?> </td>
                    <td><?= $row["email_address"] ?> </td>
                    <td><?= $row["role"] ?> </td>
                    <td><?= $row["mandate"] ?> </td>
                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?EmployeeID=<?= $row["EmployeeID"] ?>">Delete</a>
                        <a href="./edit.php?EmployeeID=<?= $row["EmployeeID"] ?>">Edit</a>
                        <a href="./show.php?EmployeeID=<?= $row["EmployeeID"] ?>">Show History</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add an Employee</a>

</body>

</html>