<?php
require_once 'ManageData.php';
$dbManager = new ManageData();

$year = $_GET['year'];
$period = $_GET['period'];
$code = $_GET['code'];
$course = $_GET['course'];

$query = "
SELECT 
    CONTACT_EMAIL,  
    CONTACT_FIRST_NAME, 
    CONTACT_LAST_NAME, 
    COURSE_NAME, 
    sum_in/cnt AS sum_out
FROM (
    SELECT 
        GRADE_STUDENT_EPITA_EMAIL_REF, 
        GRADE_COURSE_CODE_REF,
        cn.COURSE_NAME, 
        SUM(GRADE_SCORE) AS sum_in, 
        COUNT(GRADE_SCORE) AS cnt
    FROM 
        GRADES
    JOIN (
        SELECT 
            COURSE_CODE, 
            COURSE_NAME  
        FROM 
            COURSES
    ) AS cn ON cn.COURSE_CODE  = GRADE_COURSE_CODE_REF
    GROUP BY 
        GRADE_COURSE_CODE_REF, 
        GRADE_STUDENT_EPITA_EMAIL_REF,
        cn.COURSE_NAME
) g
JOIN 
    STUDENTS s ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL
JOIN 
    CONTACTS c ON s.STUDENT_CONTACT_REF = c.CONTACT_EMAIL
WHERE 
    s.STUDENT_POPULATION_PERIOD_REF = ?
    AND s.STUDENT_POPULATION_YEAR_REF = ?
    AND s.STUDENT_POPULATION_CODE_REF = ?
    AND g.GRADE_COURSE_CODE_REF = ?
ORDER BY 
    g.GRADE_STUDENT_EPITA_EMAIL_REF
";

$grades = $dbManager->getData($query, false, array($period, $year, $code, $course));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grades Page</title>
  <link rel="stylesheet" href="css/population.css">

</head>

<body>
  <h1>
    <header>Population - <?= strtoupper(htmlspecialchars($code)) ?> <?= substr(strtoupper(htmlspecialchars($period)), 0, 1) ?><?= strtoupper(htmlspecialchars($year)) ?></header>
  </h1>
  <div style="display: flex; justify-content: space-between; margin-top: 0px;">
    <h3>Grades - <?= htmlspecialchars($course) ?></h3>
  </div>
  <table style="display: flex; justify-content: space-between; margin-top: 0px;">
    <tr>
      <th>ID</th>
      <th>Email</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Course</th>
      <th>Grade (/20)</th>
      <th>Action</th>
    </tr>
    <?php $loopIndex = 0;
    foreach ($grades as $grade) : $loopIndex++ ?>
      <tr>
        <td><?= $loopIndex ?></td>
        <td><?= htmlspecialchars($grade['CONTACT_EMAIL']) ?></td>
        <td><?= htmlspecialchars($grade['CONTACT_FIRST_NAME']) ?></td>
        <td><?= htmlspecialchars($grade['CONTACT_LAST_NAME']) ?></td>
        <td><?= htmlspecialchars($grade['COURSE_NAME']) ?></td>
        <td><?= round(htmlspecialchars($grade['sum_out']), 2) ?>/20</td>
        <td>
          <button>Edit</button>
          <button>Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>