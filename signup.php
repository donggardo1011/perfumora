<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="login.css"> <!-- Uses your existing login design -->
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
        <form action="signup_validate.php" method="POST">
            <h1>Signup</h1>


            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input class="form-control" type="text" placeholder="Firstname" name="firstname" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input class="form-control" type="text" placeholder="Lastname" name="lastname" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input class="form-control" type="text" placeholder="Username" name="username" required>
                <i class='bx bx-user-circle'></i>
            </div>

            <div class="input-box">
                <input class="form-control" type="email" placeholder="Email" name="email" required>
                <i class='bx bx-envelope'></i>
            </div>

            <div class="input-box">
                <input class="form-control" type="password" placeholder="Password" name="password" required>
                <i class='bx bx-lock'></i>
            </div>

            <div class="input-box">
                <input class="form-control" type="password" placeholder="Re-enter Password" name="confirm_password" required>
                <i class='bx bx-lock'></i>
            </div>

            <button class="btn" type="submit">Signup</button>

            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
