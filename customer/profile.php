

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Perfumora">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Page</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    header {
    position: fixed;
    width: 100%;
    top: 0;
    right: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Align all items to the right */
    padding: 20px 10%; /* Adjust the padding if necessary */
}

.navmenu {
    display: flex;
    margin-right: 30px; /* Add margin to the right for spacing */
}

.navmenu a {
    color: #2c2c2c;
    font-size: 16px;
    text-transform: capitalize;
    padding: 10px 20px;
    font-weight: 400;
    transition: all .42s ease;
}

.navmenu a:hover {
    color: #EE1C47;
}

.nav-icon {
    display: flex;
    align-items: center;
    margin-right: 30px; /* Add margin to the right for spacing */
}

.nav-icon i {
    margin-right: 20px;
    color: #2c2c2c;
    font-size: 25px;
    font-weight: 400;
    transition: all .42s ease;
}

.nav-icon i:hover {
    transform: scale(1.1);
    color: #EE1C47;
}
</style>
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
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="men.php">For Men</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="women.php">For Women</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
    </ul>
  </div>
</nav>

<p>profile</p>
</body>
</html>