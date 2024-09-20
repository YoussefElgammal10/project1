<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
require 'Manager.php';

if (isset($_POST['add_employee'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Handle file upload
    $picture = $_FILES['picture']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($picture);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $valid_extensions = array("jpg", "jpeg", "png", "gif");

    // Check if uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }

    // Validate image file type
    if (in_array($imageFileType, $valid_extensions)) {
        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
            // Add employee to database
            $manager = new Manager($db);
            if ($manager->addEmployee($name, $email, $phone, $target_file, $_SESSION['manager_id'])) {
                header("Location: employees.php");
                exit;
            } else {
                $error = "Failed to add employee to the database.";
            }
        } else {
            $error = "Failed to upload picture.";
        }
    } else {
        $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Add New Employee</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Picture</label>
                <input type="file" name="picture" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
</body>
</html>
