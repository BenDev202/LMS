<?php
require_once 'functions.php';

$classes = get_classes();
$courses = get_courses(); // We'll use this to populate the course dropdown

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $max_students = $_POST['max_students'];
            
            if (add_class($course_id, $title, $start_date, $end_date, $max_students)) {
                $success_message = "Class added successfully.";
                $classes = get_classes(); // Refresh the class list
            } else {
                $error_message = "Error adding class.";
            }
        } elseif ($_POST['action'] === 'delete') {
            $class_id = $_POST['class_id'];
            if (delete_class($class_id)) {
                $success_message = "Class deleted successfully.";
                $classes = get_classes(); // Refresh the class list
            } else {
                $error_message = "Error deleting class.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes - LMS Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Classes</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Add New Class</h2>
            <form action="classes.php" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select id="course_id" name="course_id" required>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo $course['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Class Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>
                <div class="form-group">
                    <label for="max_students">Max Students</label>
                    <input type="number" id="max_students" name="max_students" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Class</button>
            </form>
        </div>

        <div class="card mt-4">
            <h2>Class List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Students</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td><?php echo $class['id']; ?></td>
                            <td><?php echo $class['course_title']; ?></td>
                            <td><?php echo $class['title']; ?></td>
                            <td><?php echo $class['start_date']; ?></td>
                            <td><?php echo $class['end_date']; ?></td>
                            <td><?php echo $class['max_students']; ?></td>
                            <td>
                                <form action="classes.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>
</html>

