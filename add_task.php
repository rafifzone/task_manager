<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $task_date = trim($_POST['task_date']);
    $status = trim($_POST['status']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($task_date) || empty($status)) {
        $message = "<div class='alert alert-danger'>Please fill all fields.</div>";
    } else {
        $title = $conn->real_escape_string($title);
        $task_date = $conn->real_escape_string($task_date);
        $status = $conn->real_escape_string($status);
        $user_id = $conn->real_escape_string($user_id);

        $sql = "INSERT INTO tasks (user_id, title, task_date, status)
                VALUES ('$user_id', '$title', '$task_date', '$status')";

        if ($conn->query($sql) === TRUE) {
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
    <title>Add Task - Task Manager</title>
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

                <h3 class="main-title">New Task</h3>
                <hr>

                <?php echo $message; ?>
                <p id="errorMessage"></p>

                <form method="post" action="add_task.php" onsubmit="return validateTask()">

                    <div class="form-group text-left">
                        <label>Task Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter task title">
                    </div>

                    <div class="form-group text-left">
                        <label>Date</label>
                        <input type="date" id="task_date" name="task_date" class="form-control">
                    </div>

                    <div class="form-group text-left">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-custom btn-block">Add Task</button>
                    <br>
                    <a href="dashboard.php" class="btn btn-default btn-block">Back</a>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>