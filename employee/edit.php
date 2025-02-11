<?php require_once("../database.php");

//if user doesnt input all the necessary field prompt them
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["LocationID"]) || empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["date_of_birth"]) ||
        empty($_POST["social_security_number"]) || empty($_POST["medical_card_number"]) || empty($_POST["phone_number"]) ||
        empty($_POST["address"]) || empty($_POST["city"]) || empty($_POST["province"]) || empty($_POST["postal_code"])
        || empty($_POST["email_address"]) || empty($_POST["role"] || empty($_POST["mandate"]))
    ) {
        echo "Missing fields, Please fill in all required fields!";

    }
}

$statement = $conn->prepare("SELECT * FROM Employee WHERE EmployeeID = :EmployeeID");
$statement->bindParam(":EmployeeID", $_GET["EmployeeID"], PDO::PARAM_INT);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);



//check if user inputed all the field
if (
    isset($_POST["LocationID"]) && isset($_POST["first_name"]) && isset($_POST["last_name"])
    && isset($_POST["date_of_birth"]) && isset($_POST["social_security_number"]) && isset($_POST["medical_card_number"])
    && isset($_POST["phone_number"]) && isset($_POST["address"]) && isset($_POST["city"])
    && isset($_POST["province"]) && isset($_POST["postal_code"]) && isset($_POST["email_address"]) && isset($_POST["role"]) && isset($_POST["mandate"])
) {
    //updating
    $updateemployee = $conn->prepare("UPDATE Employee SET 
        LocationID = :LocationID, 
        first_name = :first_name, 
        last_name = :last_name, 
        date_of_birth = :date_of_birth,
        social_security_number = :social_security_number,
        medical_card_number = :medical_card_number, 
        phone_number = :phone_number,
        address = :address, 
        city = :city, 
        province = :province, 
        postal_code = :postal_code, 
        email_address = :email_address,
        role = :role, 
        mandate = :mandate 
    WHERE EmployeeID = :EmployeeID");

    $updateemployee->bindParam(":LocationID", $_POST["LocationID"]);
    $updateemployee->bindParam(":EmployeeID", $_GET["EmployeeID"], PDO::PARAM_INT);
    $updateemployee->bindParam(":first_name", $_POST["first_name"]);
    $updateemployee->bindParam(":last_name", $_POST["last_name"]);
    $updateemployee->bindParam(":date_of_birth", $_POST["date_of_birth"]);
    $updateemployee->bindParam(":social_security_number", $_POST["social_security_number"]);
    $updateemployee->bindParam(":medical_card_number", $_POST["medical_card_number"]);
    $updateemployee->bindParam(":phone_number", $_POST["phone_number"]);
    $updateemployee->bindParam(":address", $_POST["address"]);
    $updateemployee->bindParam(":city", $_POST["city"]);
    $updateemployee->bindParam(":province", $_POST["province"]);
    $updateemployee->bindParam(":postal_code", $_POST["postal_code"]);
    $updateemployee->bindParam(":email_address", $_POST["email_address"]);
    $updateemployee->bindParam(":role", $_POST["role"]);
    $updateemployee->bindParam(":mandate", $_POST["mandate"]);



    //if successful, bring back the user to list of employee
    if ($updateemployee->execute()) {
        header("Location: .");
        exit();
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
</head>
<h1>Update Employee</h1>

<body>
    <!-- Create a form to add to the database  -->
    <form action="edit.php?EmployeeID=<?= $_GET['EmployeeID'] ?>" method="post">


        <label for="LocationID">LocationID</label><br>
        <input type="number" name="LocationID" id="LocationID" value="<?= $employee["LocationID"] ?>"><br>

        <label for="first_name">First Name</label><br>
        <input type="text" name="first_name" id="first_name" value=<?= $employee["first_name"] ?>><br>

        <label for="last_name">Last Name</label><br>
        <input type="text" name="last_name" id="last_name" value=<?= $employee["last_name"] ?>><br>

        <label for="date_of_birth">Date of Birth</label><br>
        <input type="date" name="date_of_birth" id="date_of_birth " value="<?= $employee["date_of_birth"] ?>"><br>

        <label for=" social_security_number"> SSN </label><br>
        <input type="text" name="social_security_number" id="social_security_number"
            value="<?= $employee["social_security_number"] ?>"><br>

        <label for=" medical_card_number">Medical card Number</label><br>
        <input type="text" name="medical_card_number" id="medical_card_number"
            value="<?= $employee["medical_card_number"] ?>"><br>

        <label for=" phone_number">Phone number</label><br>
        <input type="text" name="phone_number" id="phone_number" value="<?= $employee["phone_number"] ?>"><br>

        <label for=" address">Address</label><br>
        <input type="text" name="address" id="address" value="<?= $employee["address"] ?>"><br>

        <label for=" city">City</label><br>
        <input type="text" name="city" id="city" value="<?= $employee["city"] ?>"><br>

        <label for=" province">Province</label><br>
        <input type="text" name="province" id="province" value="<?= $employee["province"] ?>"><br>

        <label for=" postal_code">Postal Code</label><br>
        <input type="text" name="postal_code" id="postal_code" value="<?= $employee["postal_code"] ?>"><br>

        <label for=" email_address">Email Address</label><br>
        <input type="text" name="email_address" id="email_address" value="<?= $employee["email_address"] ?>"><br>

        <label for=" type">Role</label><br>

        <select name="role" id="role" value="<?= $employee["role"] ?>"><br>
            <option value="General Manager">General Manager</option>
            <option value="Deputy Manager">Deputy Manager</option>
            <option value="Treasurer">Treasurer</option>
            <option value="Secretary">Secretary</option>
            <option value="Administrator">Administrator</option>
            <option value="Captain">Captain</option>
            <option value="Coach">Coach</option>
            <option value="Assistant Coach">Assistant Coach</option>
            <option value="Other">Other</option>

        </select><br> <label for="type">Type</label><br>

        <select name="mandate" id="mandate" value="<?= $employee["mandate"] ?>"><br>
            <option value="Salaried">Salaried</option>
            <option value="Volunteer">Volunteer</option>
        </select><br>



        <button type="submit">Update Employee</button>


    </form>
    <!-- link to previous page -->
    <a href="./">Back to Location list</a>



</body>

</html>