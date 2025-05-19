<?php
include '../includes/db.php';
SESSION_START();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
// Include the database connection
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Define the number of records per page (set to 5)
$records_per_page = 5;

// Get the current page number from the URL, default to page 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

try {
    // Query to fetch a limited number of records from the 'orders' table
    $stmt = $pdo->prepare("SELECT * FROM orders LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();


    // Fetch the results as an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records in the 'orders' table
    $total_stmt = $pdo->prepare("SELECT COUNT(*) FROM orders");
    $total_stmt->execute();
    $total_records = $total_stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Define the range for pagination (show a maximum of 5 pages)
$page_range = 5;

// Calculate the start and end page numbers
$start_page = max(1, $current_page - floor($page_range / 2));
$end_page = min($total_pages, $start_page + $page_range - 1);

// If there are fewer than 5 pages remaining, adjust the start page to ensure 5 pages are shown
if ($end_page - $start_page + 1 < $page_range) {
    $start_page = max(1, $end_page - $page_range + 1);
}

// Handle accept, reject, delete actions
if (isset($_POST['order_id']) && isset($_POST['action'])) {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

     $mail = new PHPMailer(true);

    try {
        // Depending on the action, execute the appropriate SQL query
        if ($action === 'accept') {
    // Update the order status to 'accepted'
    $stmt = $pdo->prepare("UPDATE orders SET status = 'accepted' WHERE id = :order_id");
    $stmt->execute(['order_id' => $order_id]);

    $sql = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id");
    $sql->execute(['order_id' => $order_id]);
    $order = $sql->fetch(PDO::FETCH_ASSOC);

    try {
        // Set up PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'perfumora');
        $mail->addAddress($order['user_email'], 'CLIENT EMAIL'); // Client's email

        $mail->isHTML(true);
        $mail->Subject = 'Your Order Status: Accepted';
        $mail->Body    = "<p>Your order has been accepted.</p>";

        // Send the email
        $mail->send();

        $_SESSION['email_sent'] = true;
        $_SESSION['success'] = "Order accepted successfully and email sent!";
        header('Location: orders.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Message could not be sent. Please try again!";
        header('Location: orders.php');
        exit();
    }

} elseif ($action === 'reject') {
    // Update the order status to 'rejected'
    $stmt = $pdo->prepare("UPDATE orders SET status = 'rejected' WHERE id = :order_id");
    $stmt->execute(['order_id' => $order_id]);

    $sql = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id");
    $sql->execute(['order_id' => $order_id]);
    $order = $sql->fetch(PDO::FETCH_ASSOC);

    try {
        // Set up PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'perfumora');
        $mail->addAddress($order['user_email'], 'CLIENT EMAIL'); // Client's email

        $mail->isHTML(true);
        $mail->Subject = 'Your Order Status: Rejected';
        $mail->Body    = "<p>We regret to inform you that your order has been rejected.</p>";

        // Send the email
        $mail->send();

        $_SESSION['email_sent'] = true;
        $_SESSION['success'] = "Order rejected successfully and email sent!";
        header('Location: orders.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Message could not be sent. Please try again!";
        header('Location: orders.php');
        exit();
    }

} elseif ($action === 'delete') {
    // Delete the order from the database
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = :order_id");
    $stmt->execute(['order_id' => $order_id]);

    $_SESSION['success'] = "Order deleted successfully!";
    header('Location: orders.php');
    exit();
}


    } catch (PDOException $e) {
        // Handle any errors during the database operation
        echo "Error: " . $e->getMessage();
    }
    
}

// The rest of the code to display the table and actions...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="../Images/renzo.png">
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <div class="heads"> S E T T I N G S
            <img src="../Images/logo.png" alt="Logo">
        </div>

        <ul class="menu">
            <li><a href="../dashboard/index.php"><img src="../Images/dashboards.png"><span>Dashboard</span></a></li>
            <li><a href="../dashboard/products.php"><img src="../Images/Products.png"><span>Products</span></a></li>
            <li><a href="../dashboard/orders.php" class="active"><img src="../Images/settings.png"><span>orders</span></a></li>
            <li><a href="../dashboard/reports.php"><img src="../Images/Report.png"><span>Reports</span></a></li>
            <li><a href="../dashboard/accounts.php"><img src="../Images/Accounts.png"><span>Accounts</span></a></li>
            <li><a href="../dashboard/settings.php"><img src="../Images/settings.png"><span>Settings</span></a></li>
            <li><a href="/login.php"><img src="../Images/logout.png"><span>Logout</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="search">
                <input type="text" placeholder="Search Here">
            </div>
            <div class="user-profile">
                    <span><?php echo $_SESSION['fullname']?></span>
                    <img src="../Images/person.jfif" alt="user">
                </div>
        </div>
        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

        <div class="table-container">
    <table class="table table-bordered ml-5">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Price</th>
                <th scope="col">User Email</th>
                <th scope="col">User Number</th>
                <th scope="col">User Address</th>
                <th scope="col">Status</th>
                <th scope="col">Buy Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
                <tbody>
                     <?php
                     
                if ($rows) {
                    // Loop through the results and display them in the table
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['product_price'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        echo "<td>" . $row['user_number'] . "</td>";
                        echo "<td>" . $row['user_address'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>"; 
                        echo "<td>" . $row['buy_at'] . "</td>";
                        echo "<td>";

                        // If status is not 'accepted' or 'rejected', show action buttons
                        if ($row['status'] != 'accepted' && $row['status'] != 'rejected') {
                            // Accept form
                            echo "<form action='' method='POST' style='display:inline-block;'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='action' value='accept' class='btn btn-success btn-sm'>
                                    <i class='fas fa-check'></i> 
                                  </button>";
                            echo "</form>";

                            // Reject form
                            echo "<form action='' method='POST' style='display:inline-block;'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>
                                    <i class='fas fa-times'></i> 
                                  </button>";
                            echo "</form>";
                        }

                        // Delete form (can always be shown, if needed)
                        echo "<form action='' method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='order_id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='action' value='delete' class='btn btn-warning btn-sm'>
                                <i class='fas fa-trash'></i> 
                              </button>";
                        echo "</form>";

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                                echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                            }
                ?>
                </tbody>
            </table>

            <footer class="footer">
                <div class="pagination-wrapper">
                    <div class="pagination">
                        <?php
                        // Generate pagination buttons dynamically, but limit the range to a maximum of 5 pages
                        for ($page = 1; $page <= $total_pages; $page++) {
                            // Check if the page is the current page and add the 'active' class if true
                            $active_class = ($page == $current_page) ? 'active' : '';
                            echo "<a href='?page=$page' class='page-btn $active_class'>$page</a>";
                        }
                        ?>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>


</body>
</html>
