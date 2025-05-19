<?php
session_start();
require '../includes/db.php';

$sql = "SELECT * FROM products WHERE product_type = 'women' and quantity > 0";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Men Perfume</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"/>
  
  <style>
    body {
      min-height: 100vh;
      background-image: url('women.jpg');
      background-position: center;
      background-size: cover;
      background-attachment: fixed;
      background-repeat: no-repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 100px;
    }

    header {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 40px; /* smaller navbar height */
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-bottom: 2px solid rgb(228, 0, 190);
}

.logo img {
  max-width: 60px; /* reduced logo size */
  height: auto;
}

.navmenu {
  display: flex;
  margin-top:10px;
  gap: 20px; /* spacing between links, no dots */
  list-style: none;
}

.navmenu a {
  
  color: #000000;
  font-size: 16px; /* unchanged size */
  text-transform: capitalize;
  padding: 10px 20px; /* unchanged */
  font-weight: 400;
  transition: all 0.42s ease;
  text-decoration: none;
}

.navmenu a:hover {
  color: #f7f6f6;
}

    .nav-icon {
    display: flex;
    align-items: center;
    gap: 15px;
    }

    .nav-icon i {
    font-size: 25px; /* unchanged icon size */
    font-weight: 400;
    color: #000000;
    transition: all 0.42s ease;
    }

    .nav-icon i:hover {
    transform: scale(1.1);
    color: #ffffff;
    }


    .nav-icon a {
      color: #000;
      font-size: 20px;
      margin-left: 15px;
      margin-top: 5px;
    }

    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
      margin: 20px;
    }

    .cardborder {
      width: 220px;
      background-color: transparent;
      border-radius: 10px;
      box-shadow: 0 10px 60px rgba(255, 0, 195, 0.7);
      text-align: center;
      padding: 15px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      transition: 0.3s;
    }

    .cardborder img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .cardborder h5, .cardborder h3, .cardborder h4 {
      margin: 10px 0;
      color: #fff;
    }

.view-btn {
  margin-top: 10px;
  padding: 6px 12px;
  font-size: 13px;
  background-color:rgb(228, 0, 190); /* Bootstrap blue */
  color: #fff;               /* White text */
  border: none;              /* Optional: remove default border */
  border-radius: 4px;        /* Optional: rounded corners */
  cursor: pointer;           /* Optional: pointer on hover */
}
    /* Modal custom layout */
.custom-modal-pink {
  background: linear-gradient(to bottom right,rgb(255, 0, 174),rgb(255, 0, 174));
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  padding: 20px;
}

.modal-content h5,
.modal-content h6,
.modal-content p {
  color: #ffffff;
}

.modal-content .btn {
  border-radius: 8px;
}

.modal-content img {
  max-height: 250px;
  object-fit: cover;
}
  </style>
  
</head>
<body>

  <header>
    <a href="#" class="logo"><img src="images/logo.png" alt="Logo" style="height: 40px;"></a>
    <?php echo htmlspecialchars($_SESSION['email']); ?>
    <ul class="navmenu">
      <li><a href="index.php">Home</a></li>
      <li><a href="men.php">Men</a></li>
      <li><a href="women.php">Women</a></li>
    </ul>
    <div class="nav-icon">
      <a href="#"><i class='bx bx-search'></i></a>
      <a href="profile.php"><i class='bx bx-user'></i></a>
      <a href="#"><i class='bx bx-cart'></i></a>
    </div>
  </header>

  <div class="product-grid">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      <div class="cardborder">
        <img src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>">
        <h5><?= $row['product_name'] ?></h5>
        <h3>₱<?= number_format($row['product_price']) ?>.00</h3>
        <h4><?= ucfirst($row['product_type']) ?></h4>
        <button class="btn btn-outline-dark view-btn" data-toggle="modal" data-target="#productModal<?= $row['id'] ?>">
          View Product
        </button>
      </div>

      <!-- Modal -->
<div class="modal fade" id="productModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="productModalLabel<?= $row['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content custom-modal-pink text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title"><?= $row['product_name'] ?></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <!-- Left Side: Image -->
          <div class="col-md-5 text-center mb-3 mb-md-0">
            <img src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>" class="img-fluid rounded shadow-sm">
          </div>
          <!-- Right Side: Info -->
          <div class="col-md-7">
            <h6><strong>Price:</strong> ₱<?= number_format($row['product_price']) ?>.00</h6>
            <h6><strong>Type:</strong> <?= ucfirst($row['product_type']) ?></h6>
            <p class="mt-3"><strong>Description:</strong><br><?= $row['product_description'] ?></p>
            <a href="../transactions/order.php?id=<?= $row['id'] ?>" class="btn btn-light text-danger font-weight-bold mr-2">Buy Now</a>
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


        
    <?php } ?>
  </div>

  <!-- Bootstrap Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
