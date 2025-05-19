<?php
SESSION_START();
?>

<!DOCTYPE html>
<html lang="en">
<head><a href="../login.php">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="Icon" type="image/png" href="../Images/renzo.png">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

    <div class="dashboard">

        <div class="sidebar">
            <div class="heads"> S E T T I N G S
                <img src="../Images/logo.png" alt="Logo">
            </div>

        <ul class="menu">
            <li>
                <a href="../dashboard/index.php"  >
                    <img src="../Images/dashboards.png" >
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../dashboard/products.php" >
                    <img src="../Images/Products.png" alt="">
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="../dashboard/reports.php">
                    <img src="../Images/Report.png">
                    <span>Reports</span>
                </a>
            </li>
            <li><a href="../dashboard/orders.php"><img src="../Images/settings.png"><span>orders</span></a></li>
            <li>
                <a href="../dashboard/accounts.php">
                    <img src="../Images/Accounts.png" alt="">
                    <span>Accounts</span>
                </a>
            </li>
            <li>
                <a href="../dashboard/settings.php" class="active" >
                    <img src="../images/settings.png"alt="">
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="../login.php">
                    <img src="../Images/logout.png" alt="Logo">
                    <span>Logout</span>
                </a>
            </li>
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

                <h1>WELCOME TO THE SETTINGS AREA</h1>
                <div class="id-input">
                    <label for="id-number">ID number</label>
                    <input type="text" id="id-number" placeholder="Enter ID number">
                    <div class="members-grid">
                        </div>
                        <div class="product-grid">
                            <div class="product-card">
                                <img src="../Images/renzo.jpg"alt="">
                                <h2>Renzo Pogi Gabonada</h2>
                                <p>Hacker</p>
                                <button class="buy-btn">View Profile</button>
                            </div>
                
                            <div class="product-card">
                                <img src="../Images/edgar.jpg" alt="">
                                <h2> Edgar Balmondjan Estenzo </h2>
                                <p>Hipster</p>
                                <button class="buy-btn">View Profile</button>
                            </div>
                
                            <div class="product-card">
                                <img src="../Images/patagoc.jpg">
                                <h2> John Jericho Patagoc</h2>
                                <p>Huslter</p>
                                <button class="buy-btn">View Profile</button>
                            </div>
                
                        </div>
                </div>

            </div>
        </div>

    </div>
    
</body>
</html>