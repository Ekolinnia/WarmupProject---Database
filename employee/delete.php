<?php require_once '../database.php';
//Delete user from database but history of that ID still there
$statement = $conn->prepare('DELETE FROM Employee WHERE EmployeeID = :EmployeeID;');
$statement->bindParam('EmployeeID', $_GET['EmployeeID']);
$statement->execute();
header("Location: .");


?>