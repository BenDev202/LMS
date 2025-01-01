<?php
require_once 'functions.php';

$schedules = get_schedules();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - LMS Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Schedule</h1>

        <div class="card">
            <h2>Upcoming Classes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Class Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                        <tr>
                            <td><?php echo $schedule['course_title']; ?></td>
                            <td><?php echo $schedule['title']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($schedule['start_date'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($schedule['end_date'])); ?></td>
                            <td><?php echo $schedule['max_students']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>
</html>

