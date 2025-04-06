<?php require_once("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["LocationID"]) || empty($_POST["EmployeeID"]) || empty($_POST["start_date"]) || empty($_POST["end_date"]) ||
        empty($_POST["ContractID"])
    ) {
        echo "Missing fields, Please fill in all required fields!";
    } else {
        try {
            $EmployeeHistory = $conn->prepare("INSERT INTO Employee_history 
                (LocationID, EmployeeID, start_date, end_date, ContractID)
                VALUES (:LocationID, :EmployeeID, :start_date, :end_date, :ContractID)");

            $EmployeeHistory->bindParam(":LocationID", $_POST["LocationID"]);
            $EmployeeHistory->bindParam(":EmployeeID", $_POST["EmployeeID"]);
            $EmployeeHistory->bindParam(":start_date", $_POST["start_date"]);
            $EmployeeHistory->bindParam(":end_date", $_POST["end_date"]);
            $EmployeeHistory->bindParam(":ContractID", $_POST["ContractID"]);

            if ($EmployeeHistory->execute()) {
                header("Location: ../employee/show.php?EmployeeID=" . $_POST['EmployeeID']);
                exit();
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "<script>alert('Employee cannot work at two places at the same time');</script>";
                echo "<script>window.location.href = './create.php?EmployeeID=" . $_POST['EmployeeID'] . "';</script>";
            } else {
                echo "Database error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Employee History</title>
</head>

<body>
    <h1>Add Employee History</h1>

    <form action="./create.php?EmployeeID=<?= $_GET['EmployeeID'] ?>" method="post">

        <label for="LocationID">LocationID</label><br>
        <input type="number" name="LocationID" id="LocationID"><br>

        <label for="EmployeeID">EmployeeID</label><br>
        <input type="number" name="EmployeeID" id="EmployeeID" value="<?= $_GET['EmployeeID'] ?? '' ?>" readonly><br>

        <label for="start_date">Start Date</label><br>
        <input type="date" name="start_date" id="start_date"><br>

        <label for="end_date">End Date</label><br>
        <input type="date" name="end_date" id="end_date"><br>

        <label for="ContractID">ContractID</label><br>
        <input type="number" name="ContractID" id="ContractID"><br>

        <button type="submit">Add Employee History</button>
    </form>

    <a href="../employee/show.php?EmployeeID=<?= $_GET['EmployeeID'] ?? $_POST['EmployeeID'] ?>">Back to Employee
        History List</a>
</body>

</html>