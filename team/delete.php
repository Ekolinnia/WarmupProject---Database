<?php require_once '../database.php';

if (!isset($_GET['team_id'])) {
    echo "Missing team_id.";
    exit();
}

$statement = $conn->prepare('DELETE FROM Team WHERE team_id = :team_id');
$statement->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
$statement->execute();

header("Location: ./");
exit();
?>