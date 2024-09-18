<?php
require_once 'ManageData.php';
$dbManager = new ManageData();

$year = $_GET['year'];
$period = $_GET['period'];
$code = $_GET['code'];
$email = isset($_GET['email']) ? $_GET['email'] : null;
$course = isset($_GET['course']) ? $_GET['course'] : null;

if ($email) {
  // Add your specific query here
  $query = "
  SELECT
    STUDENT_CONTACT_REF, 
    CONTACT_FIRST_NAME, 
    CONTACT_LAST_NAME, 
    passed
  FROM (
    SELECT 
        GRADE_STUDENT_EPITA_EMAIL_REF, 
        STUDENT_CONTACT_REF, 
        STUDENT_POPULATION_PERIOD_REF, 
        STUDENT_POPULATION_YEAR_REF, 
        STUDENT_POPULATION_CODE_REF, 
        CONTACT_FIRST_NAME, 
        CONTACT_LAST_NAME, 
        COUNT(
            CASE WHEN sum_out > 10 THEN 1 END
            ) AS passed
    FROM (
        SELECT 
            *, 
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
                ) AS cn ON cn.COURSE_CODE = GRADE_COURSE_CODE_REF
            GROUP BY 
                GRADE_COURSE_CODE_REF,
                GRADE_STUDENT_EPITA_EMAIL_REF,
                cn.COURSE_NAME
            ORDER BY 
                GRADE_STUDENT_EPITA_EMAIL_REF
            ) g
        JOIN 
            STUDENTS s ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL
        JOIN 
            CONTACTS c ON s.STUDENT_CONTACT_REF = c.CONTACT_EMAIL
      ) sub
    GROUP BY 
        GRADE_STUDENT_EPITA_EMAIL_REF, 
        STUDENT_CONTACT_REF,
        STUDENT_POPULATION_PERIOD_REF, 
        STUDENT_POPULATION_YEAR_REF, 
        STUDENT_POPULATION_CODE_REF, 
        CONTACT_FIRST_NAME, 
        CONTACT_LAST_NAME
    ) sub2
  WHERE 
    STUDENT_POPULATION_CODE_REF = ?
    AND STUDENT_POPULATION_YEAR_REF = ?
    AND STUDENT_POPULATION_PERIOD_REF = ?
    AND STUDENT_CONTACT_REF = ?
  "; // Placeholder for the specific query

  $data = $dbManager->getData($query, false, [$code, $year, $period, $email]);
} else {
  // Normal query
  $query = "
  SELECT
    STUDENT_CONTACT_REF, 
    CONTACT_FIRST_NAME, 
    CONTACT_LAST_NAME, 
    passed
  FROM (
    SELECT 
        GRADE_STUDENT_EPITA_EMAIL_REF, 
        STUDENT_CONTACT_REF, 
        STUDENT_POPULATION_PERIOD_REF, 
        STUDENT_POPULATION_YEAR_REF, 
        STUDENT_POPULATION_CODE_REF, 
        CONTACT_FIRST_NAME, 
        CONTACT_LAST_NAME, 
        COUNT(
            CASE WHEN sum_out > 10 THEN 1 END
            ) AS passed
    FROM (
        SELECT 
            *, 
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
                ) AS cn ON cn.COURSE_CODE = GRADE_COURSE_CODE_REF
            GROUP BY 
                GRADE_COURSE_CODE_REF,
                GRADE_STUDENT_EPITA_EMAIL_REF,
                cn.COURSE_NAME
            ORDER BY 
                GRADE_STUDENT_EPITA_EMAIL_REF
            ) g
        JOIN 
            STUDENTS s ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL
        JOIN 
            CONTACTS c ON s.STUDENT_CONTACT_REF = c.CONTACT_EMAIL
      ) sub
    GROUP BY 
        GRADE_STUDENT_EPITA_EMAIL_REF, 
        STUDENT_CONTACT_REF,
        STUDENT_POPULATION_PERIOD_REF, 
        STUDENT_POPULATION_YEAR_REF, 
        STUDENT_POPULATION_CODE_REF, 
        CONTACT_FIRST_NAME, 
        CONTACT_LAST_NAME
    ) sub2
  WHERE 
    STUDENT_POPULATION_CODE_REF = ?
    AND STUDENT_POPULATION_YEAR_REF = ?
    AND STUDENT_POPULATION_PERIOD_REF = ?
    "; // Placeholder for the normal query

  $data = $dbManager->getData($query, false, [$code, $year, $period]);
}

if ($course) {
  // Add your specific query here
  $coursequery = "
  SELECT
    courses.course_code,
    courses.duration,
    sessions.session_prof_ref
  FROM
    courses
  JOIN
    sessions ON courses.course_code = sessions.session_course_ref
  GROUP BY
    courses.course_code;
  WHERE
    courses.course_code = ?
  "; // Placeholder for the specific query

  $coursedata = $dbManager->getData($coursequery, false, [$code, $year, $period, $email]);
} else {
  // Normal query
  $coursequery = "
  SELECT
    courses.course_code,
    courses.duration,
    sessions.session_prof_ref
  FROM
    courses
  JOIN
    sessions ON courses.course_code = sessions.session_course_ref
  GROUP BY
    courses.course_code;
  "; // Placeholder for the normal query

  $coursedata = $dbManager->getData($coursequery, false);
}

$coursequery = "
SELECT
    courses.course_code,
    courses.duration,
    sessions.session_prof_ref
FROM
    courses
JOIN
    sessions ON courses.course_code = sessions.session_course_ref
GROUP BY
    courses.course_code;
";

$coursedata = $dbManager->getData($coursequery, false);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Population</title>
  <link rel="stylesheet" href="css/population.css">
  <script src="js/buttons.js"></script>
</head>

<body>
  <h1 style="display: flex; justify-content: space-between; margin-top: 0px;">
    <header>Population - <?= strtoupper(htmlspecialchars($code)) ?> <?= substr(strtoupper(htmlspecialchars($period)), 0, 1) ?><?= strtoupper(htmlspecialchars($year)) ?></header>
  </h1>
  <div style="display: flex; justify-content: space-between; margin-top: -35px;">
    <h3>Students</h3>
  </div>
  <button>&#128394;</button>
  <button onclick="showEmailInput('<?= htmlspecialchars($year) ?>', '<?= htmlspecialchars($period) ?>', '<?= htmlspecialchars($code) ?>')">&#128269;</button>
  <table style="display: flex; justify-content: space-between; margin-top: 0px;">
    <tr>
      <th>ID</th>
      <th>Contact Ref</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Passed</th>
      <th>Action</th>
    </tr>
    <?php $loopIndex = 0;
    foreach ($data as $student) : $loopIndex++ ?>
      <tr>
        <td><?= $loopIndex ?></td>
        <td><?= htmlspecialchars($student['STUDENT_CONTACT_REF']) ?></td>
        <td><?= htmlspecialchars($student['CONTACT_FIRST_NAME']) ?></td>
        <td><?= htmlspecialchars($student['CONTACT_LAST_NAME']) ?></td>
        <td><?= htmlspecialchars($student['passed']) ?>/10</td>
        <td>
          <button>&#128295;</button>
          <button>&#128296;</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <div style="display: flex; justify-content: space-between; margin-top: -15px;">
    <h3>Courses</h3>
  </div>
  <button>&#128394;</button>
  <button>&#128269;</button>
  <table style="display: flex; justify-content: space-between; margin-top: 0px;">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Sessions Count</th>
      <th>Assigned teacher</th>
    </tr>
    <?php $loopIndex = 0;
    foreach ($coursedata as $course) : $loopIndex++ ?>
      <?php
      $link = "grade.php?year={$year}&period={$period}&code={$code}&course={$course['course_code']}";
      ?>
      <tr>
        <td><?= $loopIndex ?></td>
        <td>
          <a href="<?= $link ?>">
            <?= htmlspecialchars($course['course_code']) ?>
          </a>
        </td>
        <td><?= htmlspecialchars($course['duration']) ?></td>
        <td><?= htmlspecialchars($course['session_prof_ref']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>