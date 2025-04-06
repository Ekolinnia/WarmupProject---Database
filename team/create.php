<?php require_once("../database.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["team_name"]) || empty($_POST["LocationID"]) || empty($_POST["captain_id"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
        echo "<a href='javascript:history.back()' style='color: blue; text-decoration: underline;'>Go Back</a></br>";
    }
}

// Check if all required fields are set
if (isset($_POST["team_name"]) && isset($_POST["LocationID"]) && isset($_POST["captain_id"])) {
    try {
        $stmt = $conn->prepare("INSERT INTO Team 
            (team_name, LocationID, captain_id)
            VALUES (:team_name, :LocationID, :captain_id);");

        $stmt->bindParam(":team_name", $_POST["team_name"]);
        $stmt->bindParam(":LocationID", $_POST["LocationID"]);
        $stmt->bindParam(":captain_id", $_POST["captain_id"]);

        if ($stmt->execute()) {
            header("Location: ./");
            exit();
        } else {
            echo "An error occurred while adding the team.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('This team already exists or references invalid IDs.');</script>";
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
    <title>Add Team</title>
</head>

<body>
    <h1>Add a New Team</h1>

    <form action="./create.php" method="post">
        <label for="team_name">Team Name</label><br>
        <input type="text" name="team_name" id="team_name" required><br>

        <label for="LocationID">Location ID</label><br>
        <input type="number" name="LocationID" id="LocationID" required><br>

        <label for="captain_id">Captain ID</label><br>
        <input type="number" name="captain_id" id="captain_id" required><br>

        <button type="submit">Add Team</button>
    </form>

    <a href="./">Back to Team List</a>
</body>

</html>