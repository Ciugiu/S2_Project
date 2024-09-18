<?php
session_start();
require_once 'User.php';
$userDetails = User::getUser();
$username = $userDetails['username'] ?? 'Guest';
$activePopulations = $_SESSION['activePopulations'] ?? [];
$overallAttendance = $_SESSION['overallAttendance'] ?? [];
?>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="css/welcome_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pass PHP data to JavaScript
        const activePopulations = <?= json_encode($activePopulations) ?>;
        const overallAttendance = <?= json_encode($overallAttendance) ?>;
    </script>
    <script src="js/population_chart.js"></script>
    <script src="js/attendance_chart.js"></script>
</head>
<body>
    <!-- This is the header -->
    <div id="header">
        <h1>
            <header>Welcome, <?php echo htmlspecialchars($username); ?></header>
        </h1>
    </div>
    <!-- This is the body -->
    <div style="display: flex; justify-content: space-between; margin-top: 200px;">
    <table>
        <tr>
            <th>
                <div>
                    <h2>Active Populations</h2>
                    <?php foreach ($activePopulations as $population) : ?>
                        <?php 
                            $year = $population['student_population_year_ref'];
                            $period = strtolower($population['student_population_period_ref']);
                            $code = strtolower($population['student_population_code_ref']);
                            $link = "population.php?year={$year}&period={$period}&code={$code}";
                        ?>
                        <li><a href="<?= $link ?>"><?= "{$population['student_population_code_ref']} - " . substr($population['student_population_period_ref'], 0, 1) . "{$population['student_population_year_ref']} ({$population['cnt']})"; ?></a></li>
                    <?php endforeach; ?>
                </div>
            </th>
            <th>
                <div class="chart-container">
                    <canvas id="activePopulationsChart"></canvas>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <div>
                    <h2>Overall Attendance</h2>
                    <?php foreach ($overallAttendance as $attendance) : ?>
                        <li><?= "{$attendance['student_population_code_ref']} - " . substr($attendance['student_population_period_ref'], 0, 1) . "{$attendance['student_population_year_ref']} (" . round($attendance['percents']) . "%)"; ?></li>
                    <?php endforeach; ?>
                </div>
            </th>
            <th>
                <div class="chart-container">
                    <canvas id="overallAttendanceChart"></canvas>
                </div>
            </th>
        </tr>
    </table>
</div>
<!-- This is the footer -->
<div id="footer">
    <footer>Website last generation: </footer>
</div>
<script rel="text/javascript" src="js/footer.js"></script>
</body>
</html>