<?php require_once("../database.php");

//Fetch Location table from the server 
$statement = $conn->prepare("SELECT * FROM Formation");
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Formation </title>
</head>

<body>
    <h1>List of Formation </h1>
    <a href="../"> Back to Homepage</a>
    <table border="1">
        <thead>
            <tr>
                <!-- Fields of players -->
                <th>formationID</th>
                <th>formation_date</th>
                <th>formation_time</th>
                <th>score_team1</th>
                <th>score_team2</th>
                <th>formation_address</th>
                <th>team1_id</th>
                <th>team2_id</th>
                <th>nature</th>
            </tr>
        </thead>
        <tbody>
            <!-- fetch table from database -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row["formationID"] ?> </td>
                    <td><?= $row["formation_date"] ?> </td>
                    <td><?= $row["formation_time"] ?> </td>
                    <td><?= $row["score_team1"] ?> </td>
                    <td><?= $row["score_team2"] ?> </td>
                    <td><?= $row["formation_address"] ?> </td>
                    <td><?= $row["team1_id"] ?> </td>
                    <td><?= $row["team2_id"] ?> </td>
                    <td><?= $row["nature"] ?> </td>


                    <!-- Actions u can apply on the tuples -->
                    <td> <a href="./delete.php?formationID=<?= $row["formationID"] ?>">Delete</a>
                        <a href="./edit.php?formationID=<?= $row["formationID"] ?>">Edit</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <a href="./create.php">Add an a Formation</a>

</body>

</html>