<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Team");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of current Teams </title>
</head>

<body>
    <h1>List of current Teams</h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of players -->
                <th>team_id</th>
                <th>team_name</th>
                <th>LocationID</th>
                <th>captain_id</th>

            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["team_id"] ?> </td>
                    <td><?= $row["team_name"] ?> </td>
                    <td><?= $row["team_id"] ?> </td>
                    <td><?= $row["captain_id"] ?> </td>

                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?team_id=<?= $row["team_id"] ?>">Delete</a>
                        <a href="./edit.php?team_id=<?= $row["team_id"] ?>">Edit</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add an a Team</a>

</body>

</html>