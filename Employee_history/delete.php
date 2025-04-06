<?php
require_once '../database.php';

if (!isset($_GET['ContractID'])) {
    echo "Missing ContractID.";
    exit();
}

$contractID = $_GET['ContractID'];

$fetchStmt = $conn->prepare('SELECT EmployeeID FROM Employee_history WHERE ContractID = :ContractID');
$fetchStmt->bindParam(':ContractID', $contractID, PDO::PARAM_INT);
$fetchStmt->execute();
$record = $fetchStmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    echo "Record not found.";
    exit();
}

$employeeID = $record['EmployeeID'];

$deleteStmt = $conn->prepare('DELETE FROM Employee_history WHERE ContractID = :ContractID');
$deleteStmt->bindParam(':ContractID', $contractID, PDO::PARAM_INT);
$deleteStmt->execute();

header("Location: ../employee/show.php?EmployeeID=" . $employeeID);
exit();
?>