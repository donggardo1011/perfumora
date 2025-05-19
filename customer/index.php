<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scroll-behavior: smooth;
    font-family: 'Jost',sans-serif;
    list-style: none;
    text-decoration: none;
}
body{
  margin: 0; /* Ensure no default margin affects layout */
  min-height: 100vh; /* Make sure body takes full viewport height */
    color: #fff;
      background-image: url(backg.jpg  );
  background-position: center;
  background-size: cover;
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
  padding: 20px 100px;
  background: rgba(255, 255, 255, 0.1); /* semi-transparent background */
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px); /* Safari support */
  border-bottom: 2px solid rgb(44, 44, 44); /* Blue line */
}


.logo img{
  max-width: 120px;
  height: auto;
}

.navmenu{
  display: flex;
  
}

.navmenu a{
  color: #000000;
  font-size: 16px;
  text-transform: capitalize;
  padding: 10px 20px;
  font-weight: 400;
  transition: all .42s ease;
}

.navmenu a:hover{
  color: #f7f6f6 ;
}

.nav-icon{
  display: flex;
  align-items: center;
}

.nav-icon i{
  margin-right: 20px;
  color: #000000;
  font-size: 25px;
  font-weight: 400;
  transition: all .42s ease;
}

.nav-icon i:hover{
  transform: scale(1.1);
  color: #ffffff;
}

/* Main Content */

section{
  padding: 5% 10% ;
}

.main-home{
  width: 100%;
  height: 100vh;
  background-image: url(background1.png);
  background-position: center;
  background-size: cover;
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  align-items: center;
}

.main-text h5{
  color:rgb(0, 0, 0);
  font-size: 16px;
  text-transform: capitalize;
  font-weight: 500;
}

.main-text h1{
  color: #000000;
  font-size: 65px;
  transform: capitalize;
  line-height: 1.1;
  font-weight: 600;
  margin: 6px 0 10px;
}

.main-text p{
  color: #ffffff;
  font-size: 30px;
  font-style: italic;
  margin-bottom: 20px;
}

.main-btn{
  display: inline-block;
  color: #000000;
  font-size: 16px;
  font-weight: 500;
  text-transform: capitalize;
  border: 2px solid #000000;
  padding: 12px 25px;
  transition: all .42 ease;
}

.main-btn:hover{
  background-color: #000;
  color: #fff;
}

.main-btn i{
  vertical-align: middle;
}

  </style>
  
</head>

<body>
  <<header>
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

  <section class="main-home">
    <div class="main-text">
      <h5>Perfume Collection</h5>
      <h1>New Perfume <br> Collection</h1>
      <p>There's Nothing like Trend</p>
      <a href="#" class="main-btn">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
    </div>
  </section>
</body>
</html>
