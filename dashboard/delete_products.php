<?php
include('../includes/db.php'); // Ensure this file initializes the $pdo PDO instance

session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();   
        $_SESSION['msg'] = "The product has been deleted.";
    } catch (PDOException $e) {
        // Log the exception message in a real-world scenario
        $_SESSION['msg'] = "An error occurred while deleting the product.";
    }

    header("Location: products.php");
    exit();
} else {
    $_SESSION['msg'] = "Product ID not set or invalid.";
    header("Location: products.php");
    exit();
}
?>
