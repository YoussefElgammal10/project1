<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
require 'Manager.php';

if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];
    $manager = new Manager($db);

    if (isset($_POST['update_employee'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $picture = $_FILES['picture']['name'];
        $target = "uploads/" . basename($picture);
        
        if (!empty($picture)) {
            move_uploaded_file($_FILES['picture']['tmp_name'], $target);
            $manager->updateEmployee($employeeId, $name, $email, $phone, $target);
        } else {
            $manager->updateEmployee($employeeId, $name, $email, $phone, $_POST['current_picture']);
        }
        
        header("Location: employees.php");
        exit;
    } else {
        $stmt = $db->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$employeeId]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: employees.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Employee</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_picture" value="<?= ($employee['picture']) ?>">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= ($employee['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= ($employee['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= ($employee['phone']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Picture (Leave empty to keep current)</label>
                <input type="file" name="picture" class="form-control">
                <?php if ($employee['picture']): ?>
                    <img src="<?= ($employee['picture']) ?>" width="50" class="mt-2">
                <?php endif; ?>
            </div>
            <button type="submit" name="update_employee" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
</body>
</html> 