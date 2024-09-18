<?php
require_once 'ManageData.php';

$dbManager = new ManageData();

// Fetch Active Populations
$activePopulationsQuery = "SELECT 
    student_population_code_ref, 
    student_population_period_ref, 
    student_population_year_ref, 
    COUNT(*) as cnt
FROM 
    students
GROUP BY 
    student_population_code_ref, 
    student_population_year_ref, 
    student_population_period_ref
ORDER BY 
    cnt DESC";

$activePopulations = $dbManager->getData($activePopulationsQuery);

// Fetch Overall Attendance
$overallAttendanceQuery = "SELECT 
    s.student_population_code_ref, 
    s.student_population_period_ref, 
    s.student_population_year_ref, 
    SUM(att.attendance_presence)*100/COUNT(*) as percents
FROM 
    attendance as att
INNER JOIN 
    students as s ON s.student_epita_email = att.attendance_student_ref
GROUP BY 
    s.student_population_code_ref, 
    s.student_population_period_ref, 
    s.student_population_year_ref
ORDER BY 
    percents DESC";

$overallAttendance = $dbManager->getData($overallAttendanceQuery);


// Store the data in the session to pass it to welcome.php
session_start();
$_SESSION['activePopulations'] = $activePopulations;
$_SESSION['overallAttendance'] = $overallAttendance;

// Redirect to welcome.php
header('Location: welcome.php');
exit;