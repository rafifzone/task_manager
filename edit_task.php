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

$sql = "SELECT title, task_date, status
        FROM tasks
        WHERE id='$task_id_safe' AND user_id='$user_id_safe'";

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

        $update_sql = "UPDATE tasks
                       SET title='$title', task_date='$task_date', status='$status'
                       WHERE id='$task_id_safe' AND user_id='$user_id_safe'";

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
    <script src="script.js"></script>
</head>
<body>

<div class="container main-container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="card-box text-center">
                <img src="logo.png" alt="Task Manager Logo" class="page-logo">

                <h3 class="main-title">Edit Task</h3>
                <hr>

                <?php echo $message; ?>
                <p id="errorMessage"></p>

                <form method="post" action="edit_task.php?id=<?php echo htmlspecialchars($task_id); ?>" onsubmit="return validateTask()">

                    <div class="form-group text-left">
                        <label>Task Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>

                    <div class="form-group text-left">
                        <label>Date</label>
                        <input type="date" id="task_date" name="task_date" class="form-control" value="<?php echo htmlspecialchars($row['task_date']); ?>">
                    </div>

                    <div class="form-group text-left">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                            <option value="In Progress" <?php if ($row['status'] == "In Progress") echo "selected"; ?>>In Progress</option>
                            <option value="Completed" <?php if ($row['status'] == "Completed") echo "selected"; ?>>Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-custom btn-block">Update Task</button>
                    <br>
                    <a href="dashboard.php" class="btn btn-default btn-block">Back</a>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>