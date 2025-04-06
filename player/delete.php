<?php require_once '../database.php';

if (!isset($_GET['player_id'])) {
    echo "Missing player_id.";
    exit();
}

$statement = $conn->prepare('DELETE FROM Player WHERE player_id = :player_id');
$statement->bindParam(':player_id', $_GET['player_id'], PDO::PARAM_INT);
$statement->execute();

header("Location: ./");
exit();
?>