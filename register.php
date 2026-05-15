<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($full_name) || empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger'>Please fill all fields.</div>";
    } else {
        $full_name = $conn->real_escape_string($full_name);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        $sql = "INSERT INTO users (full_name, email, password)
                VALUES ('$full_name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert alert-success'>Account created successfully. <a href='login.php'>Login here</a></div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
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
    <script src="script.js"></script>
</head>
<body>

<div class="container main-container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="card-box text-center">
                <img src="logo.png" alt="Task Manager Logo" class="page-logo">

                <h3 class="main-title">Register</h3>
                <p class="small-text">Create your account</p>
                <hr>

                <?php echo $message; ?>
                <p id="errorMessage"></p>

                <form method="post" action="register.php" onsubmit="return validateRegister()">

                    <div class="form-group text-left">
                        <label>Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter your name">
                    </div>

                    <div class="form-group text-left">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com">
                    </div>

                    <div class="form-group text-left">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                    </div>

                    <button type="submit" class="btn btn-custom btn-block">Register</button>

                </form>

                <br>
                <p>Already have an account? <a href="login.php">Login</a></p>
                <p><a href="index.php">Back to Home</a></p>

            </div>
        </div>
    </div>
</div>

</body>
</html>