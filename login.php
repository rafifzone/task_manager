<?php
session_start();
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger' style='border-radius:12px;'>Please fill all fields.</div>";
    } else {
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        $sql = "SELECT id, full_name FROM users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger' style='border-radius:12px;'>Invalid email or password.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="card-box text-center">
                    <h3 style="color: #d88392; font-weight: bold;">Login</h3>
                    <p style="color: #999;">Welcome back!</p>
                    <hr>
                    <?php echo $message; ?>
                    <form method="post" action="login.php">
                        <div class="form-group text-left">
                            <label style="color: #8a7b80;">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                        </div>
                        <div class="form-group text-left">
                            <label style="color: #8a7b80;">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block" style="margin-top: 20px;">Login</button>
                    </form>
                    <p style="margin-top: 20px; color: #777;">
                        Don't have an account? <a href="register.php" style="color: #d88392; font-weight: 600;">Register</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>