<?php
require_once '../database.php';

try {
    // 1. Retrieve the associated memberID from Family_member 
    //    (assuming 'secondary_id' holds the Club_member.memberID)
    $getMemberIdStmt = $conn->prepare("
        SELECT secondary_id 
        FROM Family_member 
        WHERE famID = :famID
    ");
    $getMemberIdStmt->bindParam(':famID', $_GET['famID'], PDO::PARAM_INT);
    $getMemberIdStmt->execute();
    $familyRow = $getMemberIdStmt->fetch(PDO::FETCH_ASSOC);

    if (!$familyRow) {
        echo "No Family_member found with famID = " . htmlspecialchars($_GET['famID']);
        exit();
    }

    $memberID = $familyRow['secondary_id'];
    echo "Retrieved memberID: " . $memberID . "<br>";

    // 2. Delete the related record from Club_member.
    //    (ON DELETE CASCADE in Member_Location will automatically delete dependent rows)
    $deleteClubMember = $conn->prepare("DELETE FROM Club_member WHERE memberID = :memberID");
    $deleteClubMember->bindParam(':memberID', $memberID, PDO::PARAM_INT);
    $deleteClubMember->execute();
    echo "Deleted " . $deleteClubMember->rowCount() . " row(s) from Club_member.<br>";

    // 3. Finally, delete the Family_member record itself.
    $deleteFamily = $conn->prepare("DELETE FROM Family_member WHERE famID = :famID");
    $deleteFamily->bindParam(':famID', $_GET['famID'], PDO::PARAM_INT);
    $deleteFamily->execute();
    echo "Deleted " . $deleteFamily->rowCount() . " row(s) from Family_member.<br>";

    // Redirect to the listing page (or display a success message)
    header("Location: .");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>Trying to delete famID: " . htmlspecialchars($_GET['famID']);
    echo "<br><a href='.'>Go back to list</a>";
}
?>
