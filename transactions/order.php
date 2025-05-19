<?php
require '../includes/db.php';
session_start();



    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];  // Cast to int for safety
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  

        $sql = $pdo->prepare("UPDATE products set quantity  = quantity-1  where id  = :id ");
        $sql->execute([':id' => $id]);



        if ($row) {
            $pname = $row['product_name'];
            $pprice = $row['product_price'];
            $pdescription = $row['product_description'];
            $del_charge = 50;
            $total_price = $pprice + $del_charge;
            $pimage = $row['product_image'];
        } else {
            echo 'No product found!';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid or missing product ID!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Perfumora">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Complete Your Order</title>
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
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">Perfumora</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="../customer/index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Product</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Categories</a>
      </li>
    </ul>
  </div>
</nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-mb-10 mb-5">
                <h2 class="text-center p-2 text-primary">Fill the details to complete your order</h2>
                <h3>Product Details : </h3>
                <table class="table table-bordered" width="500px">
                    <tr>
                     <th>Product Name :</th>
                     <td><?= $pname; ?></td>
                     <td rowspan="5" class="text-center"><img src="<?= $pimage; ?>" width="200"></td>
                    </tr>
                    <tr>
                        <th>Product Price</th>
                        <td><?= number_format($pprice); echo ".00PHP";?></td>
                    </tr>
                    <tr>
                        <th>Product Description</th>
                        <td><?= $pdescription; ?></td>
                    </tr>
                    <tr>
                        <th>Delivery Charge :</th>
                        <td><?= number_format($del_charge); echo ".00PHP";?></td>
                    </tr>
                    <tr>    
                        <th>Total Price :</th>
                        <td><?= number_format($total_price); echo ".00PHP";?></td>
                    </tr>
                </table>
                <h4>Enter your details</h4>
                    <form action="pay.php" method="POST" accept-charset="utf-8">
                        <input type="hidden" name="product_name" value="<?= $pname; ?>">
                        <input type="hidden" name="product_price" value="<?= $pprice; ?>">
                        <input type="hidden" name="total_price" value="<?= $total_price; ?>">
                        <input type="hidden" name="product_id" value="<?= $id; ?>">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Enter your number" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="address" class="form-control" placeholder="Enter your address" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-danger btn-lg" value="Click to pay : <?= number_format($total_price); ?>.00PHP">
                        </div>
                    </form>
            </div>
        </div>
    </div>
</body>
</html>