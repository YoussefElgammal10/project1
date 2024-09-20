<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
require 'Manager.php';

$manager = new Manager($db);
$manager_id = $_SESSION['manager_id']; // الحصول على معرف المدير من الجلسة
$employees = $manager->getEmployees($manager_id); // تمرير المعامل المطلوب

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Employees</h2>
        <a href="add_employee.php" class="btn btn-primary mb-3">Add Employee</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Picture</th> <!-- إضافة عمود للصورة -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td><?= htmlspecialchars($employee['email']) ?></td>
                    <td><?= htmlspecialchars($employee['phone']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($employee['picture']) ?>" alt="Employee Picture" style="width: 50px; height: 50px;"> <!-- عرض الصورة -->
                    </td>
                    <td>
                        <a href="edit_employee.php?id=<?= $employee['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_employee.php?id=<?= $employee['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
