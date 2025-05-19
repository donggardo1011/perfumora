<?php
session_start();

require 'includes/db.php';

//only redirect the user if the code is verified and email is passed
if (!isset($_SESSION['email']) || !isset($_SESSION['reset_code_verified']) || !$_SESSION['reset_code_verified']) {
    header('Location: enter_code.php');
    exit();
}

//this is where we will reset our password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //password the value of our form below into new variables
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        //hash the password if the user enters the exact same password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        //to update the user to the new password
        $stmt = $pdo->prepare("UPDATE users SET password =? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_SESSION['reset_email']]);

        //unset the variables and clear
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_code_verified']);

        //redirect to login page after reset
        $_SESSION['success'] = 'Your password has been reset successfully.';
        header('Location: login.php');
        exit();

    } else {
        $_SESSION['error'] = 'Passwords do not match. Please try again.';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="images/image.png">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('loginbg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .wrapper {
            width: 420px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
            text-align: center;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 80px;
        }

        .title {
            text-align: center;
            font-size: 26px;
            margin-bottom: 20px;
            color: #fff;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 40px;
            padding: 15px 45px 15px 20px;
            font-size: 16px;
            color: #fff;
            outline: none;
        }

        .input-box input::placeholder {
            color: #fff;
        }

        .btn-primary {
            width: 100%;
            height: 45px;
            background: #5c6bc0;
            color: #fff;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #3f51b5;
            border-color: #3f51b5;
        }

        .btn-primary:focus {
            outline: none;
        }

        .alert {
            margin: 10px 0;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #ff4d4f;
            color: white;
        }

        .alert-success {
            background-color: #4caf50;
            color: white;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14.5px;
            text-align: center;
        }

        .register-link p a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .wrapper {
                width: 90%;
                padding: 20px;
            }
            .input-box input {
                padding: 10px 30px 10px 10px;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <img src="images/logo.png" alt="Logo" class="logo">
    <h1 class="title">Reset Password</h1>

    <!-- Display success or error messages -->
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    ?>

    <!-- Password Reset Form -->
    <form action="reset_password.php" method="POST">
        <div class="input-box">
            <input type="password" name="password" placeholder="Enter New Password" required>
        </div>
        <div class="input-box">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset</button>
    </form>

    <div class="register-link">
        <p>Back to <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
