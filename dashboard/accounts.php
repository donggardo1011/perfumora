<?php
SESSION_START();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/png" href="../Images/renzo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
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
            <li><a href="../dashboard/orders.php"><img src="../Images/settings.png"><span>orders</span></a></li>
            <li><a href="../dashboard/reports.php"><img src="../Images/Report.png"><span>Reports</span></a></li>
            <li><a href="../dashboard/accounts.php" class="active"><img src="../Images/Accounts.png"><span>Accounts</span></a></li>
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
                    <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                    <img src="../Images/person.jfif" alt="user" />
                </div>
        </div>

        <div class="content">

            <table class="table">

                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date Created</th>
                  </tr>
                </thead>

                <tbody>
                    <?php
                        // Include the database connection
                        include '../includes/db.php';  // Ensure the path is correct

                        try {
                            // Query to fetch all records from the 'crud' table
                            $stmt = $pdo->prepare("SELECT * FROM users");
                            $stmt->execute();

                            // Fetch the results as an associative array
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($rows) {
                                // Loop through the results and display them in the table
                                foreach ($rows as $row) {
                                    echo "<tr>";
                                    echo "<th>" . $row['id'] . "</th>";
                                    echo "<td>" . $row['firstname'] . "</td>";
                                    echo "<td>" . $row['lastname'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No users found</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }

                        // Close the database connection (optional with PDO, but good practice)
                        // $pdo = null;
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
