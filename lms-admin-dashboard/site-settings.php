<?php
require_once 'functions.php';

$settings = get_site_settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = $_POST['site_name'];
    $site_description = $_POST['site_description'];
    $contact_email = $_POST['contact_email'];
    $max_upload_size = $_POST['max_upload_size'];

    if (update_site_settings($site_name, $site_description, $contact_email, $max_upload_size)) {
        $success_message = "Site settings updated successfully.";
        $settings = get_site_settings(); // Refresh settings
    } else {
        $error_message = "Error updating site settings.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - LMS Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Site Settings</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Update Site Settings</h2>
            <form action="site-settings.php" method="POST">
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" value="<?php echo $settings['site_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="site_description">Site Description</label>
                    <textarea id="site_description" name="site_description" required><?php echo $settings['site_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_email">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="<?php echo $settings['contact_email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="max_upload_size">Max Upload Size (MB)</label>
                    <input type="number" id="max_upload_size" name="max_upload_size" value="<?php echo $settings['max_upload_size']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Settings</button>
            </form>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>
</html>

