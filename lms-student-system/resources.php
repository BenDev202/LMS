<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get all resources for the student
$resources = get_student_resources($student_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-6">Resources</h1>

        <?php if (empty($resources)): ?>
            <p class="text-gray-600">No resources available.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($resources as $resource): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($resource['title']); ?></h2>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($resource['description']); ?></p>
                        <a href="<?php echo htmlspecialchars($resource['file_url']); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors" target="_blank">
                            Download Resource
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
