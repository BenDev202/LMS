<?php
// Existing functions...

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

function get_site_settings() {
    global $conn;
    $result = $conn->query("SELECT * FROM site_settings");
    return $result->fetch_assoc();
}

function update_site_settings($site_name, $site_description, $contact_email, $max_upload_size) {
    global $conn;
    $stmt = $conn->prepare("UPDATE site_settings SET site_name = ?, site_description = ?, contact_email = ?, max_upload_size = ?");
    $stmt->bind_param("sssi", $site_name, $site_description, $contact_email, $max_upload_size);
    return $stmt->execute();
}

