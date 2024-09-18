<?php
require_once 'ManageData.php';
$dbManager = new ManageData();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    $updateQuery = "UPDATE CONTACTS SET CONTACT_FIRST_NAME = ?, CONTACT_LAST_NAME = ? WHERE CONTACT_EMAIL = ?";
    $dbManager->executeQuery($updateQuery, [$firstName, $lastName, $studentId]);

    header('Location: grade.php');
    exit;
} else {
    $studentId = $_GET['id'];
    $studentQuery = "SELECT CONTACT_FIRST_NAME, CONTACT_LAST_NAME FROM CONTACTS WHERE CONTACT_EMAIL = ?";
    $student = $dbManager->getData($studentQuery, true, [$studentId]);
}
?>

<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <form method="post" action="edit_student.php">
        <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentId) ?>">
        <label>First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($student['CONTACT_FIRST_NAME']) ?>"></label><br>
        <label>Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($student['CONTACT_LAST_NAME']) ?>"></label><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>