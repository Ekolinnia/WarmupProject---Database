<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Location");
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
    <h1>List of Locations</h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of Location -->
                <th>LocationID</th>
                <th>type</th>
                <th>name</th>
                <th>address</th>
                <th>city</th>
                <th>province</th>
                <th>postal_code</th>
                <th>phone_number</th>
                <th>web_address</th>
                <th>maximum_capacity</th>
            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["LocationID"] ?> </td>
                    <td><?= $row["type"] ?> </td>
                    <td><?= $row["name"] ?> </td>
                    <td><?= $row["address"] ?> </td>
                    <td><?= $row["city"] ?> </td>
                    <td><?= $row["province"] ?> </td>
                    <td><?= $row["postal_code"] ?> </td>
                    <td><?= $row["phone_number"] ?> </td>
                    <td><?= $row["web_address"] ?> </td>
                    <td><?= $row["maximum_capacity"] ?> </td>
                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?LocationID=<?= $row["LocationID"] ?>">Delete</a>
                        <a href="./edit.php?LocationID=<?= $row["LocationID"] ?>">Edit</a>
                        <a href="./show.php?LocationID=<?= $row["LocationID"] ?>">Show</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add a Location</a>

</body>

</html>