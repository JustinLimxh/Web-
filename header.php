<?php
// Start session and ensure user is logged in
include 'config.php';
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location: login.php');
    exit; // Make sure to exit after redirection
}

// Fetch cart items count for the user
$select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
$cart_rows_number = mysqli_num_rows($select_cart_number);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Japanese E-Bookshop</title>

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <!-- Font Awesome CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<header class="header">
   <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
         <a class="navbar-brand" href="index.php">Japanese E-Bookshop</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item">
                  <a class="nav-link" href="buy.php">Buy</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="borrow.php">Borrow</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="order.php">Orders</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="myBook.php">My Books</a>
               </li>
            </ul>

            <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                  <a class="nav-link" href="search_page.php"><i class="fas fa-search"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="cart.php">
                     <i class="fas fa-shopping-cart"></i>
                     <span>(<?php echo $cart_rows_number; ?>)</span>
                  </a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-user"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                     <p class="dropdown-item">Username: <span><?php echo $_SESSION['user_name']; ?></span></p>
                     <p class="dropdown-item">Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</header>
