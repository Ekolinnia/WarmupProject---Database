<?php require_once '../database.php';

if (!isset($_GET['formationID'])) {
    echo "Missing formationID.";
    exit();
}

$statement = $conn->prepare('DELETE FROM Formation WHERE formationID = :formationID');
$statement->bindParam(':formationID', $_GET['formationID'], PDO::PARAM_INT);
$statement->execute();

header("Location: ./");
exit();
?>