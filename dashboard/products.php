<?php
include '../includes/db.php';
SESSION_START();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Dashboard</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="../Images/462534209_900066331612624_360995020807937831_n (1).png">
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="heads">P R O D U C T S
            <img src="../Images/logo.png" alt="Logo">
        </div>
        <ul class="menu">
            <li><a href="../dashboard/index.php" ><img src="../Images/dashboards.png"><span>Dashboard</span></a></li>
            <li><a href="../dashboard/products.php" class="active"><img src="../Images/Products.png"><span>Products</span></a></li>
            <li><a href="../dashboard/orders.php"><img src="../Images/settings.png"><span>orders</span></a></li>
            <li><a href="../dashboard/reports.php"><img src="../Images/Report.png"><span>Reports</span></a></li>
            <li><a href="../dashboard/accounts.php"><img src="../Images/Accounts.png"><span>Accounts</span></a></li>
            <li><a href="../dashboard/settings.php"><img src="../Images/settings.png"><span>Settings</span></a></li>
            <li><a href="../login.php"><img src="../Images/logout.png"><span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="search">
                <input type="text" placeholder="Search Here">
            </div>
            <div class="user-profile">
                    <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                    <img src="../Images/person.jfif" alt="user" />
                </div>
        </div>

        <!-- Product Cards -->
        <div class="content">
            <div class="container">
                <?php
        if (isset($_SESSION['msg'])) {
            echo '<div style="color: green; font-weight: bold; margin-bottom: 20px;">' . htmlspecialchars($_SESSION['msg']) . '</div>';
            unset($_SESSION['msg']);
        }
        ?>
                <div class="product-grid">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM products");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="cardborder">
                        <img src="../shopping/<?= htmlspecialchars($row['product_image']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>">
                        <h5><?= htmlspecialchars($row['product_name']) ?></h5>
                        <h3>₱<?= number_format($row['product_price'], 2) ?></h3>
                        <h4>Category: <?= htmlspecialchars($row['product_type']) ?></h4>
                        <h2>Description: <?= htmlspecialchars($row['product_description']) ?></h2>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="buy-btn">Edit</a>
                        <a href="delete_products.php?id=<?= $row['id'] ?>" class="buy-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
                       <footer class="footer">
        <div class="pagination-wrapper">
            <div class="pagination">
                <a href="#" class="page-btn active" onclick="showPage(1)">1</a>
                <a href="#" class="page-btn" onclick="showPage(2)">2</a>
            </div>
        </div>
    </footer>
        </div>

    </div>

    <!-- Pagination -->


</div>

<script>
  function showPage(pageNum) {
    const products = document.querySelectorAll('.cardborder');
    products.forEach((p, index) => {
      if (pageNum === 1 && index < 4) {
        p.style.display = 'block';
      } else if (pageNum === 2 && index >= 4 && index < 8) {
        p.style.display = 'block';
      } else {
        p.style.display = 'none';
      }
    });

    document.querySelectorAll('.page-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.page-btn')[pageNum - 1].classList.add('active');
  }

  document.addEventListener('DOMContentLoaded', () => showPage(1));
</script>
    
</body>
</html>
