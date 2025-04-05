<?php
require_once("../database.php");

// 1. Check that famID is provided
if (!isset($_GET['famID'])) {
    echo "No famID specified.";
    exit();
}

$famID = $_GET['famID'];

// 2. Fetch all secondary family members for this famID
try {
    $stmt = $conn->prepare("
        SELECT secondary_fm_id, first_name, last_name, telephone_number, famID
        FROM Secondary_family_member
        WHERE famID = :famID
    ");
    $stmt->bindParam(':famID', $famID, PDO::PARAM_INT);
    $stmt->execute();
    $secondaryFamilyMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching secondary family members: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Secondary Family Members</title>
</head>
<body>
    <h1>Secondary Family Members for Family Member #<?= htmlspecialchars($famID) ?></h1>

    <!-- Link to go back to the Family Member listing (adjust the path as needed) -->
    <p>
        <a href="../Family_member/">Back to Family Members</a> |
        <!-- Link to create a new secondary family member -->
        <a href="create.php?famID=<?= htmlspecialchars($famID) ?>">Add Secondary Family Member</a>
    </p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Telephone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($secondaryFamilyMembers): ?>
            <?php foreach ($secondaryFamilyMembers as $sfm): ?>
                <tr>
                    <td><?= htmlspecialchars($sfm['secondary_fm_id']) ?></td>
                    <td><?= htmlspecialchars($sfm['first_name']) ?></td>
                    <td><?= htmlspecialchars($sfm['last_name']) ?></td>
                    <td><?= htmlspecialchars($sfm['telephone_number']) ?></td>
                    <td>
                        <a href="show.php?secondary_fm_id=<?= $sfm['secondary_fm_id'] ?>&famID=<?= $famID ?>">Show</a> |
                        <a href="edit.php?secondary_fm_id=<?= $sfm['secondary_fm_id'] ?>&famID=<?= $famID ?>">Edit</a> |
                        <a href="delete.php?secondary_fm_id=<?= $sfm['secondary_fm_id'] ?>&famID=<?= $famID ?>"
                           onclick="return confirm('Are you sure you want to delete this record?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No secondary family members found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
