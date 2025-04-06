<?php require_once("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["member_id"]) || empty($_POST["team_id"]) || empty($_POST["player_role"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
        echo "<a href='javascript:history.back()' style='color: blue; text-decoration: underline;'>Go Back</a></br>";
    }
}

if (isset($_POST["member_id"]) && isset($_POST["team_id"]) && isset($_POST["player_role"])) {
    try {
        $stmt = $conn->prepare("INSERT INTO Player 
            (member_id, team_id, player_role)
            VALUES (:member_id, :team_id, :player_role);");

        $stmt->bindParam(":member_id", $_POST["member_id"]);
        $stmt->bindParam(":team_id", $_POST["team_id"]);
        $stmt->bindParam(":player_role", $_POST["player_role"]);

        if ($stmt->execute()) {
            header("Location: ./");
            exit();
        } else {
            echo "An error occurred while adding the player.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {  // Unique constraint violation
            echo "<script>alert('This player already exists in the team!');</script>";
            echo "<script>window.location.href = './create.php';</script>";
        } else {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Player</title>
</head>

<body>
    <h1>Add a New Player</h1>

    <form action="./create.php" method="post">
        <label for="member_id">Member ID</label><br>
        <input type="number" name="member_id" id="member_id" required><br>

        <label for="team_id">Team ID</label><br>
        <input type="number" name="team_id" id="team_id" required><br>

        <label for="player_role">Player Role</label><br>
        <select name="player_role" id="player_role" required><br>
            <option value="">-- Select Role --</option>
            <option value="outside hitter">Outside Hitter</option>
            <option value="opposite">Opposite</option>
            <option value="setter">Setter</option>
            <option value="middle blocker">Middle Blocker</option>
            <option value="libero">Libero</option>
            <option value="defensive specialist">Defensive Specialist</option>
            <option value="serving specialist">Serving Specialist</option>
        </select><br>

        <button type="submit">Add Player</button>
    </form>

    <a href="./">Back to Player List</a>
</body>

</html>