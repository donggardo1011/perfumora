    <?php 
    include '../includes/db.php';
    session_start();

    $msg = "";

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $_email = $_POST['email'] ?? '';
    $_num = $_POST['phone'] ?? '';
    $_add = $_POST['address'] ?? '';

    $_product_name = $_POST['product_name'] ?? '';
    $_product_price = $_POST['product_price'] ?? '';
    $_total_price = $_POST['total_price'] ?? '';
    $_product_id = $_POST['product_id'] ?? null;

    try {
        $stmt = $pdo->prepare("INSERT INTO orders 
            (product_name, product_price, total_price, user_email, user_number, user_address, status, buy_at)
            VALUES 
            (:pname, :pprice, :tprice, :email, :num, :addr, 'pending', NOW())");

        $stmt->execute([
            ':pname' => $_product_name,
            ':pprice' => $_product_price,
            ':tprice' => $_total_price,
            ':email' => $_email,
            ':num' => $_num,
            ':addr' => $_add,
        ]);

        $_SESSION['msg'] = "✅ Order has been recorded!";
        header("Location: ../customer/index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['msg'] = "❌ Order failed: " . $e->getMessage();
        header("Location: pay.php");
        exit();
    }
}
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>pay.php</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    </body>
    </html>