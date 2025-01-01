<?php
require_once 'functions.php';

$total_users = get_user_count();
$active_courses = get_course_count();
$total_classes = get_class_count();
$active_students = get_active_student_count();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="page-title">Dashboard Overview</h1>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Users</div>
                <div class="stat-value"><?php echo $total_users; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Active Courses</div>
                <div class="stat-value"><?php echo $active_courses; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Total Classes</div>
                <div class="stat-value"><?php echo $total_classes; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Active Students</div>
                <div class="stat-value"><?php echo $active_students; ?></div>
            </div>
        </div>

        <!-- Add more dashboard content here -->

    </main>

    <script src="js/script.js"></script>
</body>
</html>

