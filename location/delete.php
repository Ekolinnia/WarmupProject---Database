<?php require_once '../database.php';

$statement = $conn->prepare('DELETE FROM Location WHERE LocationID = :LocationID;');
$statement->bindParam('LocationID', $_GET['LocationID']);
$statement->execute();
header("Location: .");


?>