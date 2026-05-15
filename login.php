<?php
session_start();
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $message = "<div class='alert alert-danger'>Please fill all fields.</div>";

    } else {

        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        $sql = "SELECT id, full_name 
                FROM users 
                WHERE email='$email' AND password='$password'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "<div class='alert alert-danger'>Invalid email or password.</div>";

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

    <script src="script.js"></script>

</head>

<body>

<div class="container main-container">

    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="card-box text-center">

                <img src="logo.png" alt="Logo" class="page-logo">

                <h3 class="main-title">Login</h3>

                <p class="small-text">Welcome back</p>

                <hr>

                <?php echo $message; ?>

                <p id="errorMessage"></p>

                <form method="post" action="login.php" onsubmit="return validateLogin()">

                    <div class="form-group text-left">

                        <label>Email</label>

                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control"
                               placeholder="example@mail.com">

                    </div>

                    <div class="form-group text-left">

                        <label>Password</label>

                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter password">

                    </div>

                    <button type="submit" class="btn btn-custom btn-block">
                        Login
                    </button>

                </form>

                <br>

                <p>
                    Don't have an account?
                    <a href="register.php">Register</a>
                </p>

                <p>
                    <a href="index.php">Back to Home</a>
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>