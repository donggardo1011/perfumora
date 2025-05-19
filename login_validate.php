<?php
session_start();

// Load environment variables from .env
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get secret key from .env
    $recaptchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Check if captcha response is empty
    if (empty($recaptchaResponse)) {
        $_SESSION['error'] = "Captcha not submitted. Please try again.";
        header('Location: login.php');
        exit();
    }

    // Verify reCAPTCHA with Google's API
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
    $captchaSuccess = json_decode($verify);

    if (!$captchaSuccess || !$captchaSuccess->success) {
        $_SESSION['error'] = "Captcha verification failed. Please try again.";
        header('Location: login.php');
        exit();
    }

    // Handle login form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'];
    $msg = '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format.";
    } elseif (empty($password)) {
        $msg = "Password cannot be empty.";
    } else {
        // Prepare and execute the SQL statement using PDO
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            // STORING FULLNAME
            $email = $user['email'];
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $user['id'];

            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: dashboard/index.php');
                exit();
            } elseif ($user['role'] === 'user') {
                header('Location: customer/index.php');
                exit();
            } else {
                $msg = "Unknown user type.";
            }
        } else {
            $msg = "Incorrect email or password.";
        }
    }

    if (!empty($msg)) {
        $_SESSION['error'] = $msg;
        header('Location: login.php');
        exit();
    }
}
?>
