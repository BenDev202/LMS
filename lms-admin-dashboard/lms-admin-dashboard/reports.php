<?php
require_once 'functions.php';

$enrollment_stats = get_enrollment_stats();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - LMS Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Reports</h1>

        <div class="card">
            <h2>Enrollment Statistics</h2>
            <canvas id="enrollmentChart" width="400" height="200"></canvas>
        </div>

        <div class="card mt-4">
            <h2>Top 5 Courses by Enrollment</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course Title</th>
                        <th>Enrollment Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollment_stats as $stat): ?>
                        <tr>
                            <td><?php echo $stat['title']; ?></td>
                            <td><?php echo $stat['enrollment_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="js/script.js"></script>
    <script>
        // Enrollment Chart
        var ctx = document.getElementById('enrollmentChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo "'" . implode("', '", array_column($enrollment_stats, 'title')) . "'"; ?>],
                datasets: [{
                    label: 'Enrollments',
                    data: [<?php echo implode(', ', array_column($enrollment_stats, 'enrollment_count')); ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

