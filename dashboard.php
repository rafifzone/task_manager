<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_id_safe = $conn->real_escape_string($user_id);

$sql = "SELECT id, title, task_date, status
        FROM tasks
        WHERE user_id='$user_id_safe'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Task Manager</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

    <script src="script.js"></script>
</head>

<body>

<div class="container main-container">

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="card-box">

                <div class="dashboard-header">

                    <div>
                        <img src="logo.png" alt="Logo" class="dashboard-logo">
                    </div>

                    <div class="dashboard-actions">
                        <a href="add_task.php" class="btn btn-custom">Add New Task</a>
                        <a href="logout.php" class="btn btn-default">Logout</a>
                    </div>

                </div>

                <h3 class="main-title text-center">
                    Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!
                </h3>

                <p class="small-text text-center">
                    Here are your tasks for today
                </p>

                <hr>

                <div class="table-wrapper">

                    <table class="table table-custom">

                        <thead>
                            <tr>
                                <th>Task Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {

                                echo "<tr>";

                                echo "<td>" . htmlspecialchars($row['title']) . "</td>";

                                echo "<td>" . htmlspecialchars($row['task_date']) . "</td>";

                                echo "<td>";
                                echo "<span class='status-badge'>" . htmlspecialchars($row['status']) . "</span>";
                                echo "</td>";

                                echo "<td>";
                                echo "<a href='edit_task.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                                echo "<a href='delete_task.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Delete</a>";
                                echo "</td>";

                                echo "</tr>";
                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='4' class='text-center'>No tasks found.</td>";
                            echo "</tr>";
                        }
                        ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>