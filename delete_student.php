<?php
require_once 'ManageData.php';
$dbManager = new ManageData();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];

    $deleteGradesQuery = "DELETE FROM GRADES WHERE GRADE_STUDENT_EPITA_EMAIL_REF = ?";
    $dbManager->executeQuery($deleteGradesQuery, [$studentId]);

    $deleteStudentQuery = "DELETE FROM STUDENTS WHERE STUDENT_EPITA_EMAIL = ?";
    $dbManager->executeQuery($deleteStudentQuery, [$studentId]);

    header('Location: grade.php');
    exit;
}
?>

<html>
<head>
    <title>Delete Student</title>
</head>
<body>
    <form method="post" action="delete_student.php">
        <input type="hidden" name="student_id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <p>Are you sure you want to delete this student?</p>
        <input type="submit" value="Yes">
        <a href="grade.php"><button type="button">No</button></a>
    </form>
</body>
</html>