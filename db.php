<?php
// Database connection using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=project1', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>