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

    if ($manager->deleteManager($managerId)) {
        header("Location: managers.php");
        exit;
    } else {
        echo "Failed to delete manager.";
    }
} else {
    header("Location: managers.php");
    exit;
}
?>