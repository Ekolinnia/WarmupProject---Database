<?php require_once '../database.php';

//get the id
if (!isset($_GET['memberID'])) {
    echo "Missing memberID.";
    exit();
}

$statement = $conn->prepare('DELETE FROM Club_member WHERE memberID = :memberID');
$statement->bindParam(':memberID', $_GET['memberID'], PDO::PARAM_INT);
$statement->execute();

header("Location: ./");
exit();
?>