<?php
require_once 'includes/db.php';
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$siteKey = $_ENV['RECAPTCHA_SITE_KEY'] ?? '';
?>

<!-- SAMPLE -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
  margin: 0;
}

/* Login Form Wrapper */
.wrapper {
  width: 420px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(15px);
  border: 2px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
  color: #fff;
  border-radius: 10px;
  padding: 30px 40px;
  position: relative;
  text-align: center;
  z-index: 10;
}

/* Title */
.wrapper h1 {
  font-size: 36px;
  text-align: center;
  margin-bottom: 30px;
}

/* Input Fields */
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
  transition: border-color 0.3s;
}

.input-box input::placeholder {
  color: #fff;
}

.input-box input:focus {
  border-color: #4CAF50; /* Green color when focused */
}

.input-box i {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
  color: #fff;
}

/* Remember Me & Forgot Password */
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

/* Login Button */
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

.btn:hover {
  background: #f0f0f0;
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

.btn-google:hover {
  background-color: #c1351d;
  transform: translateY(-2px);
  text-decoration: none;
}

.btn-google:active {
  background-color: #9c331f;
  transform: translateY(0);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-google i {
  margin-right: 10px;
  font-size: 20px;
}

/* Alert Messages */
.alert {
  margin: 10px 0;
  padding: 10px;
  border-radius: 6px;
  font-size: 14px;
}

.alert-danger {
  background-color: #ff4d4f;
  color: #fff;
}

.alert-success {
  background-color: #4caf50;
  color: #fff;
}

.alert-warning {
  background-color: #ffa000;
  color: #fff;
}

/* reCAPTCHA Container */
.recaptcha-container {
  margin-top: 20px;
}

.g-recaptcha {
  margin: 0 auto;
  display: block;
  max-width: 100%;
  transform: scale(0.9); /* Optional: Adjust size */
}

/* Registration Link */
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

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  .wrapper {
    width: 90%;
    padding: 20px;
  }

  .input-box {
    height: 45px;
  }

  .btn, .btn-google {
    font-size: 14px;
    height: 40px;
  }

  .register-link p a {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .wrapper {
    width: 95%;
    padding: 15px;
  }

  .input-box input {
    padding: 10px 30px 10px 10px;
  }

  .btn, .btn-google {
    font-size: 13px;
    height: 38px;
  }
}

  </style>

</head>
<body>

<div class="wrapper">
  <h1>Login</h1>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" role="alert">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <form action="login_validate.php" method="POST">
    <div class="input-box">
      <input required type="email" name="email" placeholder="Email">
      <i class='bx bx-user'></i>
    </div>

    <div class="input-box">
      <input required type="password" name="password" placeholder="Password">
      <i class='bx bx-lock-alt'></i>
    </div>

    <div class="remember-forgot">
      <label><input type="checkbox" name="remember"> Remember me</label>
      <a href="forgot_password.php">Forgot password?</a>
    </div>

    <?php if ($siteKey): ?>
      <div class="recaptcha-container">
        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">reCAPTCHA site key is not set.</div>
    <?php endif; ?>

    <button class="btn" type="submit">Login</button>
  </form>

  <a href="googleAuth/google-login.php" class="btn-google">
    <i class='bx bxl-google'></i> Login with Google
  </a>

  <div class="register-link">
    <p>Don't have an account? <a href="signup.php">Register</a></p>
  </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
