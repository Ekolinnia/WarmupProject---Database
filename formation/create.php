<?php require_once("../database.php");

// If form submitted with missing fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["formation_date"]) || empty($_POST["formation_time"]) ||
        empty($_POST["formation_address"]) || empty($_POST["team1_id"]) ||
        empty($_POST["team2_id"]) || empty($_POST["nature"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
        echo "<a href='javascript:history.back()' style='color: blue; text-decoration: underline;'>Go Back</a></br>";
    }
}

// Check if required fields are set
if (
    isset($_POST["formation_date"]) && isset($_POST["formation_time"]) &&
    isset($_POST["formation_address"]) && isset($_POST["team1_id"]) &&
    isset($_POST["team2_id"]) && isset($_POST["nature"])
) {
    try {
        $stmt = $conn->prepare("INSERT INTO Formation (
            formation_date, formation_time, score_team1, score_team2,
            formation_address, team1_id, team2_id, nature
        ) VALUES (
            :formation_date, :formation_time, :score_team1, :score_team2,
            :formation_address, :team1_id, :team2_id, :nature
        );");

        $stmt->bindParam(":formation_date", $_POST["formation_date"]);
        $stmt->bindParam(":formation_time", $_POST["formation_time"]);
        $stmt->bindParam(":score_team1", $_POST["score_team1"]);
        $stmt->bindParam(":score_team2", $_POST["score_team2"]);
        $stmt->bindParam(":formation_address", $_POST["formation_address"]);
        $stmt->bindParam(":team1_id", $_POST["team1_id"]);
        $stmt->bindParam(":team2_id", $_POST["team2_id"]);
        $stmt->bindParam(":nature", $_POST["nature"]);

        if ($stmt->execute()) {
            header("Location: ./");
            exit();
        } else {
            echo "An error occurred while adding the formation.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Formation</title>
</head>

<body>
    <h1>Add a New Formation</h1>

    <form action="./create.php" method="post">
        <label>Date</label><br>
        <input type="date" name="formation_date" required><br>

        <label>Time</label><br>
        <input type="time" name="formation_time" required><br>

        <label>Score Team 1</label><br>
        <input type="number" name="score_team1"><br>

        <label>Score Team 2</label><br>
        <input type="number" name="score_team2"><br>

        <label>Formation Address</label><br>
        <input type="text" name="formation_address" required><br>

        <label>Team 1 ID</label><br>
        <input type="number" name="team1_id" required><br>

        <label>Team 2 ID</label><br>
        <input type="number" name="team2_id" required><br>

        <label>Nature</label><br>
        <select name="nature" required>
            <option value="">-- Select Nature --</option>
            <option value="training">training</option>
            <option value="game">Game</option>
        </select><br>



        <button type="submit">Add Formation</button>
    </form>

    <a href="./">Back to Formation List</a>
</body>

</html>