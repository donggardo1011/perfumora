<?php 
session_start(); 
require '../includes/db.php'; // Make sure $pdo is your PDO connection object
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css" />
    <link rel="Icon" type="image/png" href="../Images/renzo.png" />
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" />

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="dashboard">

        <div class="sidebar">
            <div class="heads"> R E P O R T S
                <img src="../Images/logo.png" alt="Logo" />
            </div>

            <ul class="menu">
                <li>
                    <a href="../dashboard/index.php">
                        <img src="../Images/dashboards.png" />
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../dashboard/products.php">
                        <img src="../Images/Products.png" alt="" />
                        <span>Products</span>
                    </a>
                </li>
                <li><a href="../dashboard/orders.php"><img src="../Images/settings.png" /><span>orders</span></a></li>
                <li>
                    <a href="../dashboard/reports.php" class="active">
                        <img src="../Images/Report.png" />
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="../dashboard/accounts.php">
                        <img src="../Images/Accounts.png" alt="" />
                        <span>Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="../dashboard/settings.php">
                        <img src="../images/settings.png" alt="" />
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a href="../login.php">
                        <img src="../Images/logout.png" alt="Logo" />
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <div class="topbar">
                <div class="search">
                    <input type="text" placeholder="Search Here" />
                </div>
                <div class="user-profile">
                    <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                    <img src="../Images/person.jfif" alt="user" />
                </div>
            </div>

            <div class="content">
                <h1>Reports</h1>

                <?php
                $acceptedCount = 0;
                $rejectedCount = 0;
                $pendingCount = 0;

                $sql = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    $status = strtolower($row['status']);
                    if ($status === 'accepted') {
                        $acceptedCount = (int)$row['count'];
                    } elseif ($status === 'rejected') {
                        $rejectedCount = (int)$row['count'];
                    } elseif ($status === 'pending') {
                        $pendingCount = (int)$row['count'];
                    }
                }
                ?>

                <div class="row">
                    <div class="col-md-6"> <!-- Pie chart on the left -->
                        <div class="chart-container" style="max-width: 500px;">
                        <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>

                    <div class="col-md-6"> <!-- Analytics on the right -->
                        <!-- Product Analytics on the right -->
    <div class="col-md-6 d-flex flex-column gap-3">
        <!-- Men Products Card -->
        <div class="analytics-box p-3 shadow rounded">
            <h5>Men's Products</h5>
            <?php
            $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM products WHERE product_type = 'men' AND quantity > 0");
            $stmt->execute();
            $availableProductCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            ?>
            <p>Total Available: <strong><?php echo $availableProductCount; ?></strong></p>
        </div>

        <!-- Women Products Card -->
        <div class="analytics-box p-3 shadow rounded">
            <h5>Women's Products</h5>
            <?php
            $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM products WHERE product_type = 'women' AND quantity > 0");
            $stmt->execute();
            $availableProductCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            ?>
            <p>Total Available: <strong><?php echo $availableProductCount; ?></strong></p>
        </div>

        <!-- All Products Card -->
        <div class="analytics-box p-3 shadow rounded">
            <h5>All Available Products</h5>
            <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total_available FROM products WHERE quantity > 0");
            $stmt->execute();
            $availableProductCount = $stmt->fetch(PDO::FETCH_ASSOC)['total_available'];
            ?>
            <p>Total Available Products: <strong><?php echo $availableProductCount; ?></strong></p>
        </div>
    </div>
</div>
                    </div>
                </div>

                <script>
                    const ctx = document.getElementById('orderStatusChart').getContext('2d');
                    const orderStatusChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Accepted', 'Rejected', 'Pending'],
                            datasets: [{
                                label: 'Order Status',
                                data: [
                                    <?php echo $acceptedCount; ?>,
                                    <?php echo $rejectedCount; ?>,
                                    <?php echo $pendingCount; ?>
                                ],
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.7)',   // Accepted
                                    'rgba(255, 99, 132, 0.7)',   // Rejected
                                    'rgba(255, 206, 86, 0.7)'    // Pending
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 206, 86, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>

    </div>

</body>
</html>
