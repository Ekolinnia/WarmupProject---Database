<?php require_once("../database.php");

// Fetch the current formation
$statement = $conn->prepare("SELECT * FROM Formation WHERE formationID = :formationID");
$statement->bindParam(":formationID", $_GET["formationID"], PDO::PARAM_INT);
$statement->execute();
$formation = $statement->fetch(PDO::FETCH_ASSOC);

// Update if form submitted
if (
    isset($_POST["formationID"]) && isset($_POST["formation_date"]) &&
    isset($_POST["formation_time"]) && isset($_POST["formation_address"]) &&
    isset($_POST["team1_id"]) && isset($_POST["team2_id"]) && isset($_POST["nature"])
) {
    $stmt = $conn->prepare("UPDATE Formation SET 
        formation_date = :formation_date,
        formation_time = :formation_time,
        score_team1 = :score_team1,
        score_team2 = :score_team2,
        formation_address = :formation_address,
        team1_id = :team1_id,
        team2_id = :team2_id,
        nature = :nature
        WHERE formationID = :formationID");

    $stmt->bindParam(":formation_date", $_POST["formation_date"]);
    $stmt->bindParam(":formation_time", $_POST["formation_time"]);
    $stmt->bindParam(":score_team1", $_POST["score_team1"]);
    $stmt->bindParam(":score_team2", $_POST["score_team2"]);
    $stmt->bindParam(":formation_address", $_POST["formation_address"]);
    $stmt->bindParam(":team1_id", $_POST["team1_id"]);
    $stmt->bindParam(":team2_id", $_POST["team2_id"]);
    $stmt->bindParam(":nature", $_POST["nature"]);
    $stmt->bindParam(":formationID", $_POST["formationID"]);

    if ($stmt->execute()) {
        header("Location: ./");
        exit();
    } else {
        header("Location: ./edit.php?formationID=" . $_POST["formationID"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Formation</title>
</head>

<body>
    <h1>Edit Formation</h1>

    <form action="./edit.php?formationID=<?= $_GET['formationID'] ?>" method="post">
        <label>Date</label><br>
        <input type="date" name="formation_date" value="<?= $formation["formation_date"] ?>"><br>

        <label>Time</label><br>
        <input type="time" name="formation_time" value="<?= $formation["formation_time"] ?>"><br>

        <label>Score Team 1</label><br>
        <input type="number" name="score_team1" value="<?= $formation["score_team1"] ?>"><br>

        <label>Score Team 2</label><br>
        <input type="number" name="score_team2" value="<?= $formation["score_team2"] ?>"><br>

        <label>Address</label><br>
        <input type="text" name="formation_address" value="<?= $formation["formation_address"] ?>"><br>

        <label>Team 1 ID</label><br>
        <input type="number" name="team1_id" value="<?= $formation["team1_id"] ?>"><br>

        <label>Team 2 ID</label><br>
        <input type="number" name="team2_id" value="<?= $formation["team2_id"] ?>"><br>

        <label>Nature</label><br>
        <select name="nature">
            <?php
            $natures = ['training', 'game'];
            foreach ($natures as $n) {
                $selected = $formation["nature"] === $n ? "selected" : "";
                echo "<option value='$n' $selected>" . ucfirst($n) . "</option>";
            }
            ?>
        </select><br>

        </select><br>

        <input type="hidden" name="formationID" value="<?= $formation["formationID"] ?>">

        <button type="submit">Update Formation</button>
    </form>

    <a href="./">Back to Formation List</a>
</body>

</html>