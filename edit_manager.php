<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
require 'Manager.php';

if (isset($_GET['id'])) {
    $managerId = $_GET['id'];
    $manager = new Manager($db);

    if (isset($_POST['update_manager'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Keep the existing password
            $hashedPassword = $_POST['current_password'];
        }

        if ($manager->updateManager($managerId, $name, $email, $hashedPassword)) {
            header("Location: managers.php");
            exit;
        } else {
            $error = "Failed to update manager.";
        }
    } else {
        $stmt = $db->prepare("SELECT * FROM managers WHERE id = ?");
        $stmt->execute([$managerId]);
        $managerData = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: managers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Manager</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="current_password" value="<?= ($managerData['password']) ?>">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= ($managerData['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= ($managerData['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Password (Leave empty to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" name="update_manager" class="btn btn-primary">Update Manager</button>
        </form>
    </div>
</body>
</html> 