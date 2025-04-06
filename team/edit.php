<?php require_once("../database.php");

// Fetch the current team
$statement = $conn->prepare("SELECT * FROM Team WHERE team_id = :team_id");
$statement->bindParam(":team_id", $_GET["team_id"], PDO::PARAM_INT);
$statement->execute();
$team = $statement->fetch(PDO::FETCH_ASSOC);

// If form submitted, update the team
if (
    isset($_POST["team_id"]) &&
    isset($_POST["team_name"]) &&
    isset($_POST["LocationID"]) &&
    isset($_POST["captain_id"])
) {
    $update = $conn->prepare("UPDATE Team SET 
        team_name = :team_name, 
        LocationID = :LocationID, 
        captain_id = :captain_id
        WHERE team_id = :team_id");

    $update->bindParam(":team_name", $_POST["team_name"]);
    $update->bindParam(":LocationID", $_POST["LocationID"]);
    $update->bindParam(":captain_id", $_POST["captain_id"]);
    $update->bindParam(":team_id", $_POST["team_id"]);

    if ($update->execute()) {
        header("Location: ./");
        exit();
    } else {
        header("Location: ./edit.php?team_id=" . $_POST["team_id"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Team</title>
</head>

<body>
    <h1>Update Team</h1>

    <form action="./edit.php?team_id=<?= $_GET['team_id'] ?>" method="post">
        <label for="team_name">Team Name</label><br>
        <input type="text" name="team_name" id="team_name" value="<?= $team["team_name"] ?>" required><br>

        <label for="LocationID">Location ID</label><br>
        <input type="number" name="LocationID" id="LocationID" value="<?= $team["LocationID"] ?>" required><br>

        <label for="captain_id">Captain ID</label><br>
        <input type="number" name="captain_id" id="captain_id" value="<?= $team["captain_id"] ?>" required><br>

        <input type="hidden" name="team_id" value="<?= $team["team_id"] ?>">

        <button type="submit">Update Team</button>
    </form>

    <a href="./">Back to Team List</a>
</body>

</html>