<?php 

session_start();

require 'includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user =$stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $reset_code = rand(100000, 999999);

        $update = $pdo->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
        $update->execute([$reset_code, $email]);

        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);

        try {
          $mail->isSMTP();
          $mail->Host =  'smtp.gmail.com';
          $mail->SMTPAuth = 'true';
          $mail->Username = 'ccelmacasling@gmail.com';
          $mail->Password = 'kkgl gpvc lekt odss';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;

          $mail->setFrom('ccelmacasling@gmail.com', 'cel macasling');
          $mail->addAddress($email, 'CLIENT EMAIL');//client's email!

          $mail->isHTML(true);
          $mail->Subject = 'Password Reset Code';

          $mail->Body = "
                        <p> Hello, This is your password reset Code: {$reset_code}</p>
          ";
          
          $mail->AltBody = "Hello, Use the code below to reset your password: \n\n {$reset_code} \n\n";
          $mail->send();
        
          $_SESSION['email_sent'] = true;

          $_SESSION['success'] = "A verification code has been sent to your email";
          header('Location: enter_code.php');
          exit();

        }   catch (Exception $e) {
            $_SESSION['error'] = "Message could not be sent. Please Try Again!";
            header('Location: forgot_password.php');
            exit();
        } 

    } else {

        $_SESSION['error'] = "No user found with this email. Please try again";
        header('Location: forgot_password.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional if you use it -->
    <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css"> <!-- Uses login design -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="icon" type="image/png" href="images/image.png">
    <style>
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
  background: url(loginbg.jpg) no-repeat center center fixed;
  background-size: cover;
}

.wrapper {
  width: 420px;
  background: rgba(255, 255, 255, 0.05);
  border: 2px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(20px);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  color: #fff;
  border-radius: 10px;
  padding: 30px 40px;
}

.wrapper h1 {
  font-size: 36px;
  text-align: center;
  margin-bottom: 30px;
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
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 40px;
  padding: 20px 45px 20px 20px;
  font-size: 16px;
  color: #fff;
  outline: none;
}

.input-box input::placeholder {
  color: #fff;
}

.input-box i {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
}

.remember-forgot {
  display: flex;
  justify-content: space-between;
  font-size: 14px;
  margin: -10px 0 20px;
}

.remember-forgot a {
  color: #fff;
  text-decoration: none;
}

.remember-forgot a:hover {
  text-decoration: underline;
}

.btn {
  width: 100%;
  height: 45px;
  background: #fff;
  color: #333;
  border: none;
  border-radius: 40px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.mt-3 {
  margin-top: 1rem;
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

.alert {
  margin: 10px 0;
  padding: 10px;
  border-radius: 6px;
  font-size: 14px;
}

.alert-danger {
  background: #ff4d4f;
  color: white;
}

.alert-success {
  background: #4caf50;
  color: white;
}

.alert-warning {
  background: #ffa000;
  color: white;
}

/* Google Button */
.btn-google {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 45px;
  background-color: #db4437;
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  font-size: 16px;
  transition: background-color 0.3s ease, transform 0.2s ease;
  text-decoration: none;
  margin-top: 15px;
}

.btn-google i {
  margin-right: 10px;
  font-size: 20px;
}

.btn-google:hover {
  background-color: #c1351d;
  transform: translateY(-2px);
  text-decoration: none;
}

.btn-google:active {
  transform: translateY(0);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* reCAPTCHA Container */
.recaptcha-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

    </style>
</head>
<body>
    <div class="wrapper">
        <form action="forgot_password.php" method="POST">
            <h1>Forgot Password</h1>

            <!-- Display success or error messages -->
            <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info text-center">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger text-center">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
            ?>

            <div class="input-box">
                <input type="email" name="email" placeholder="Enter Your Email" required class="form-control">
                <i class='bx bx-envelope'></i>
            </div>

            <button type="submit" class="btn">Send Verification Code</button>

            <div class="register-link">
                <p>Remember your password? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
