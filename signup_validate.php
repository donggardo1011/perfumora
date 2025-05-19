<?php

session_start();

require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header('Location: signup.php');
        exit;
    }

    // Check if the email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Email exists, redirect back with an error message
        $_SESSION['error'] = "Email address already exists!";
        header('Location: signup.php');
        exit;
    }

    // If the email is unique, proceed with the registration
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Insert the user into the database
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();

    // Set success message in session
    $_SESSION['success'] = "Your Account has been created. You can now Login.";

    // Redirect to the signup page with success message
    header('Location: login.php');
    exit;
}