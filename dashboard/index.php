<?php
require '../includes/db.php';
session_start();

$msg = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $p_name = $_POST['pName'];
    $p_price = $_POST['pPrice'];
    $p_description = $_POST['pDescription'];
    $product_Type = $_POST['type'];

    $target_dir = "../uploads/";
    $file_extension = pathinfo($_FILES['pImage']['name'], PATHINFO_EXTENSION);
    $unique_image_name = uniqid('perfume_') . '.' . $file_extension;
    $target_file = $target_dir . $unique_image_name;

    if (move_uploaded_file($_FILES['pImage']["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (product_name, product_price, product_description, product_image, product_type) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$p_name, $p_price, $p_description, $target_file, $product_Type]);
        $_SESSION['msg'] = "Product successfully added!";
        header("location: index.php");
        exit;
    } else {
        $_SESSION['msg'] = "Failed to upload the image.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Dashboard</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../Images/logo.png">
    <link rel="stylesheet" href="admin.css">

</head>
<body>
    <!-- Sidebar and Topbar (unchanged) -->
    <div class="dashboard">
        <div class="sidebar">
            <div class="heads">D A S H B O A R D <img src="../Images/logo.png" alt="Logo"></div>
            <ul class="menu">
                <li><a href="../dashboard/index.php" class="active"><img src="../Images/dashboards.png"><span>Dashboard</span></a></li>
                <li><a href="../dashboard/products.php"><img src="../Images/Products.png"><span>Products</span></a></li>
                <li><a href="../dashboard/orders.php"><img src="../Images/settings.png"><span>orders</span></a></li>
                <li><a href="../dashboard/reports.php"><img src="../Images/Report.png"><span>Reports</span></a></li>
                <li><a href="../dashboard/accounts.php"><img src="../Images/Accounts.png"><span>Accounts</span></a></li>
                <li><a href="../dashboard/settings.php"><img src="../images/settings.png"><span>Settings</span></a></li>
                <li><a href="../login.php"><img src="../Images/logout.png"><span>Logout</span></a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="topbar">
                <div class="search"><input type="text" placeholder="Search Here"></div>
                <div class="user-profile">
                    <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                    <img src="../Images/person.jfif" alt="user" />
                </div>
            </div>

            <div class="pogi">
                <!-- Button to open modal -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal" style="margin-top:15px; margin-left:20px;">Add Product</button>

                <!-- Add Product Modal -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php if (isset($_SESSION['msg'])): ?>
                                        <div class="alert alert-info"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="pName">Product Name</label>
                                        <input type="text" name="pName" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pPrice">Price</label>
                                        <input type="number" name="pPrice" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pDescription">Description</label>
                                        <textarea name="pDescription" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="pImage">Product Image</label>
                                        <input type="file" name="pImage" class="form-control-file" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Category</label>
                                        <select name="type" class="form-select" required>
                                            <option value="" selected disabled>Select category</option>
                                            <option value="men">Men</option>
                                            <option value="women">Women</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-0">
                    
                <!-- Optional redirect button -->
                <table class="table table-bordered mt-0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Product Description</th>
                            <th scope="col">Product Type</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Include the database connection
                        include '../includes/db.php';  // Ensure the path is correct

                        try {
                            // Query to fetch all records from the 'products' table
                            $stmt = $pdo->prepare("SELECT * FROM products");
                            $stmt->execute();

                            // Fetch the results as an associative array
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($rows) {
                                // Loop through the results and display them in the table
                                foreach ($rows as $row) {
                                    echo "<tr>";
                                    echo "<th>" . $row['id'] . "</th>";
                                    echo "<td>" . $row['product_name'] . "</td>";
                                    echo "<td>" . $row['product_price'] . "</td>";
                                    echo "<td>" . $row['quantity'] . "</td>";
                                    echo "<td>" . $row['product_description'] . "</td>";
                                    echo "<td>" . $row['product_type'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                    </tbody>
                </table>
            </div>

    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>