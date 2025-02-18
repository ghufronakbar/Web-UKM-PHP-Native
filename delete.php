<?php
include_once 'utils/layout.php';
include_once 'utils/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM ukm WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: ukm.php");
    exit;
} else {
    header("Location: ukm.php");
    exit;
}

