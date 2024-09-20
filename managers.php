<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
require 'Manager.php';

$manager = new Manager($db);
$managers = $manager->getManagers(); // Implement this method in Manager.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Bankwebsite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="managers.php">Managers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="employees.php">Employees</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    <a href="logout.php" class="btn btn-outline-danger">Logout <i class="bi bi-box-arrow-right"></i></a>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Managers</h2>
        <a href="add_manager.php" class="btn btn-primary mb-3">Add Manager</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($managers as $manager): ?>
                <tr>
                    <td><?= ($manager['name']) ?></td>
                    <td><?= ($manager['email']) ?></td>
                    <td>
                        <a href="edit_manager.php?id=<?= $manager['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_manager.php?id=<?= $manager['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this manager?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
