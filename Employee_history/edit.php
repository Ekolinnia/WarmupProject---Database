<?php
require_once("../database.php");

$existingData = null;

if (isset($_GET['ContractID'])) {
    $stmt = $conn->prepare("SELECT * FROM Employee_history WHERE ContractID = :ContractID");
    $stmt->bindParam(":ContractID", $_GET["ContractID"], PDO::PARAM_INT);
    $stmt->execute();
    $existingData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingData) {
        echo "No record found with that ContractID.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["LocationID"]) || empty($_POST["EmployeeID"]) || empty($_POST["start_date"]) || empty($_POST["end_date"]) ||
        empty($_POST["ContractID"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
    } else {
        try {
            $stmt = $conn->prepare("UPDATE Employee_history 
                SET LocationID = :LocationID, EmployeeID = :EmployeeID, start_date = :start_date, end_date = :end_date
                WHERE ContractID = :ContractID");

            $stmt->bindParam(":LocationID", $_POST["LocationID"]);
            $stmt->bindParam(":EmployeeID", $_POST["EmployeeID"]);
            $stmt->bindParam(":start_date", $_POST["start_date"]);
            $stmt->bindParam(":end_date", $_POST["end_date"]);
            $stmt->bindParam(":ContractID", $_POST["ContractID"]);

            if ($stmt->execute()) {
                header("Location: ../employee/show.php?EmployeeID=" . $_POST['EmployeeID']);
                exit();
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Modify Employee History</title>
</head>

<body>
    <h1>Modify Employee History</h1>

    <form action="./edit.php?ContractID=<?= $_GET['ContractID'] ?>" method="post">

        <label for="LocationID">LocationID</label><br>
        <input type="number" name="LocationID" id="LocationID" value="<?= $existingData['LocationID'] ?? '' ?>"><br>

        <label for="EmployeeID">EmployeeID</label><br>
        <input type="number" name="EmployeeID" id="EmployeeID" value="<?= $existingData['EmployeeID'] ?? '' ?>"
            readonly><br>

        <label for="start_date">Start Date</label><br>
        <input type="date" name="start_date" id="start_date" value="<?= $existingData['start_date'] ?? '' ?>"><br>

        <label for="end_date">End Date</label><br>
        <input type="date" name="end_date" id="end_date" value="<?= $existingData['end_date'] ?? '' ?>"><br>

        <input type="hidden" name="ContractID" value="<?= $_GET['ContractID'] ?>">

        <button type="submit">Update Employee History</button>
    </form>

    <a href="../employee/show.php?EmployeeID=<?= $existingData['EmployeeID'] ?? '' ?>">Back to Employee History</a>
</body>

</html>