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
    $stmt = $db->prepare("SELECT picture FROM employees WHERE id = ?");
    $stmt->execute([$employeeId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($manager->deleteEmployee($employeeId)) {
        if (file_exists($employee['picture'])) {
            unlink($employee['picture']); // Delete the picture file
        }
        header("Location: employees_list.php");
        exit;
    } else {
        echo "Failed to delete employee.";
    }
} else {
    header("Location: employees_list.php");
    exit;
}
?>  