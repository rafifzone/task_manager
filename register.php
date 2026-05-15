<?php
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($full_name) || empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger' style='border-radius:12px;'>Please fill all fields.</div>";
    } else {
        $full_name = $conn->real_escape_string($full_name);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert alert-success' style='border-radius:12px;'>Account created! <a href='login.php'>Login here</a></div>";
        } else {
            $message = "<div class='alert alert-danger' style='border-radius:12px;'>Error: " . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Task Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="card-box text-center">
                    <h3 style="color: #d88392; font-weight: bold;">Join Us</h3>
                    <p style="color: #999;">Start organizing your tasks today.</p>
                    <hr>
                    <?php echo $message; ?>
                    <form method="post" action="register.php">
                        <div class="form-group text-left">
                            <label style="color: #8a7b80;">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group text-left">
                            <label style="color: #8a7b80;">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                        </div>
                        <div class="form-group text-left">
                            <label style="color: #8a7b80;">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block" style="margin-top: 20px;">Register</button>
                    </form>
                    <p style="margin-top: 20px; color: #777;">
                        Already have an account? <a href="login.php" style="color: #d88392; font-weight: 600;">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>