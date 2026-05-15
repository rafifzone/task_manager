<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = isset($_GET['id']) ? $_GET['id'] : 0;

$user_id_safe = $conn->real_escape_string($user_id);
$task_id_safe = $conn->real_escape_string($task_id);

$sql = "DELETE FROM tasks
        WHERE id='$task_id_safe' AND user_id='$user_id_safe'";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>