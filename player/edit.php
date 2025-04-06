<?php require_once("../database.php");

$statement = $conn->prepare("SELECT * FROM Player WHERE player_id = :player_id");
$statement->bindParam(":player_id", $_GET["player_id"], PDO::PARAM_INT);
$statement->execute();
$player = $statement->fetch(PDO::FETCH_ASSOC);

if (
    isset($_POST["player_id"]) && isset($_POST["member_id"]) &&
    isset($_POST["team_id"]) && isset($_POST["player_role"])
) {
    $update = $conn->prepare("UPDATE Player SET 
        member_id = :member_id,
        team_id = :team_id,
        player_role = :player_role
        WHERE player_id = :player_id");

    $update->bindParam(":member_id", $_POST["member_id"]);
    $update->bindParam(":team_id", $_POST["team_id"]);
    $update->bindParam(":player_role", $_POST["player_role"]);
    $update->bindParam(":player_id", $_POST["player_id"]);

    if ($update->execute()) {
        header("Location: ./");
        exit();
    } else {
        header("Location: ./edit.php?player_id=" . $_POST["player_id"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Player</title>
</head>

<body>
    <h1>Update Player</h1>

    <form action="./edit.php?player_id=<?= $_GET["player_id"] ?>" method="post">

        <label for="member_id">Member ID</label><br>
        <input type="number" name="member_id" id="member_id" value="<?= $player["member_id"] ?>"><br>

        <label for="team_id">Team ID</label><br>
        <input type="number" name="team_id" id="team_id" value="<?= $player["team_id"] ?>"><br>

        <label for="player_role">Player Role</label><br>
        <select name="player_role" id="player_role">
            <?php
            $roles = [
                'outside hitter',
                'opposite',
                'setter',
                'middle blocker',
                'libero',
                'defensive specialist',
                'serving specialist'
            ];
            foreach ($roles as $role) {
                $selected = ($player["player_role"] === $role) ? "selected" : "";
                echo "<option value=\"$role\" $selected>" . ucwords($role) . "</option>";
            }
            ?>
        </select><br>

        <input type="hidden" name="player_id" value="<?= $player["player_id"] ?>">

        <button type="submit">Update Player</button>
    </form>

    <a href="./">Back to Player List</a>
</body>

</html>