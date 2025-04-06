<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Player");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of current Players </title>
</head>

<body>
    <h1>List of current Players</h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of players -->
                <th>player_id</th>
                <th>member_id</th>
                <th>team_id</th>
                <th>player_role</th>

            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["player_id"] ?> </td>
                    <td><?= $row["member_id"] ?> </td>
                    <td><?= $row["team_id"] ?> </td>
                    <td><?= $row["player_role"] ?> </td>

                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?player_id=<?= $row["player_id"] ?>">Delete</a>
                        <a href="./edit.php?player_id=<?= $row["player_id"] ?>">Edit</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add an a Player</a>

</body>

</html>