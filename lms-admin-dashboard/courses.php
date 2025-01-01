<?php
require_once 'functions.php';

$courses = get_courses();
$instructors = get_users(); // We'll use this to populate the instructor dropdown

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $instructor_id = $_POST['instructor_id'];
            $status = $_POST['status'];
            
            if (add_course($title, $description, $instructor_id, $status)) {
                $success_message = "Course added successfully.";
                $courses = get_courses(); // Refresh the course list
            } else {
                $error_message = "Error adding course.";
            }
        } elseif ($_POST['action'] === 'delete') {
            $course_id = $_POST['course_id'];
            if (delete_course($course_id)) {
                $success_message = "Course deleted successfully.";
                $courses = get_courses(); // Refresh the course list
            } else {
                $error_message = "Error deleting course.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - LMS Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Courses</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Add New Course</h2>
            <form action="courses.php" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="instructor_id">Instructor</label>
                    <select id="instructor_id" name="instructor_id" required>
                        <?php foreach ($instructors as $instructor): ?>
                            <?php if ($instructor['role'] === 'teacher'): ?>
                                <option value="<?php echo $instructor['id']; ?>"><?php echo $instructor['full_name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Course</button>
            </form>
        </div>

        <div class="card mt-4">
            <h2>Course List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Instructor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?php echo $course['id']; ?></td>
                            <td><?php echo $course['title']; ?></td>
                            <td><?php echo $course['instructor_name']; ?></td>
                            <td><?php echo ucfirst($course['status']); ?></td>
                            <td>
                                <form action="courses.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
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

