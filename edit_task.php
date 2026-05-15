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

$sql = "SELECT title, task_date, status FROM tasks WHERE id='$task_id_safe' AND user_id='$user_id_safe'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: dashboard.php");
    exit();
}

$row = $result->fetch_assoc();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $task_date = trim($_POST['task_date']);
    $status = trim($_POST['status']);

    if (empty($title) || empty($task_date) || empty($status)) {
        $message = "<div class='alert alert-danger'>Please fill all fields.</div>";
    } else {
        $title = $conn->real_escape_string($title);
        $task_date = $conn->real_escape_string($task_date);
        $status = $conn->real_escape_string($status);

        $update_sql = "UPDATE tasks SET title='$title', task_date='$task_date', status='$status' WHERE id='$task_id_safe' AND user_id='$user_id_safe'";

        if ($conn->query($update_sql) === TRUE) {
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Task - Task Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="card-box">
                    <h3 class="text-center" style="color: #5bc0de;">Edit Task</h3>
                    <hr>
                    <?php echo $message; ?>
                    <form method="post" action="edit_task.php?id=<?php echo htmlspecialchars($task_id); ?>">
                        <div class="form-group">
                            <label>Task Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="task_date" class="form-control" value="<?php echo htmlspecialchars($row['task_date']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="In Progress" <?php if($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                <option value="Completed" <?php if($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">Update Task</button>
                        <a href="dashboard.php" class="btn btn-default btn-block" style="margin-top: 10px;">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>