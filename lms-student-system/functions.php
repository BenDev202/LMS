<?php
require_once 'config.php';

function register_student($username, $password, $email, $full_name) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO students (username, password, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $full_name);
    
    if ($stmt->execute()) {
        return $conn->insert_id;
    } else {
        return false;
    }
}

function login_student($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, password FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            return $student['id'];
        }
    }
    
    return false;
}

function get_student_courses($student_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT c.* FROM courses c JOIN enrollments e ON c.id = e.course_id WHERE e.student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function enroll_in_course($student_id, $course_id) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $student_id, $course_id);
    
    return $stmt->execute();
}

function get_student_assignments($student_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT a.*, c.title as course_title FROM assignments a JOIN courses c ON a.course_id = c.id JOIN enrollments e ON c.id = e.course_id WHERE e.student_id = ? ORDER BY a.due_date ASC");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function submit_assignment($student_id, $assignment_id, $content) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO submissions (student_id, assignment_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $student_id, $assignment_id, $content);
    
    return $stmt->execute();
}

function get_schedules($limit = 10, $offset = 0) {
    global $conn;
    $result = $conn->query("SELECT classes.*, courses.title as course_title FROM classes LEFT JOIN courses ON classes.course_id = courses.id ORDER BY classes.start_date ASC LIMIT $limit OFFSET $offset");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_enrollment_stats() {
    global $conn;
    $result = $conn->query("SELECT courses.title, COUNT(enrollments.id) as enrollment_count FROM courses LEFT JOIN classes ON courses.id = classes.course_id LEFT JOIN enrollments ON classes.id = enrollments.class_id GROUP BY courses.id ORDER BY enrollment_count DESC LIMIT 5");
    return $result->fetch_all(MYSQLI_ASSOC);
}
