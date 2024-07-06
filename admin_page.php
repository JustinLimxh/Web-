<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit; // Ensure script execution stops after redirection
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Bootstrap CSS Link -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

   <!-- Custom CSS (optional for additional styling) -->
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<!-- Admin Dashboard Section Starts -->
<div class="container mt-5">
   <section class="dashboard">

      <h1 class="text-center mb-4">Dashboard</h1>

      <div class="row">

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php
                     $total_pendings = 0;
                     $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('Query failed');
                     if(mysqli_num_rows($select_pending) > 0){
                        while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                           $total_pendings += $fetch_pendings['total_price'];
                        }
                     }
                  ?>
                  <h3 class="card-title">RM<?php echo $total_pendings; ?></h3>
                  <p class="card-text">Total Pendings</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php
                     $total_completed = 0;
                     $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('Query failed');
                     if(mysqli_num_rows($select_completed) > 0){
                        while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                           $total_completed += $fetch_completed['total_price'];
                        }
                     }
                  ?>
                  <h3 class="card-title">RM<?php echo $total_completed; ?></h3>
                  <p class="card-text">Completed Payments</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php 
                     $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed');
                     $number_of_orders = mysqli_num_rows($select_orders);
                  ?>
                  <h3 class="card-title"><?php echo $number_of_orders; ?></h3>
                  <p class="card-text">Orders Placed</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php 
                     $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed');
                     $number_of_products = mysqli_num_rows($select_products);
                  ?>
                  <h3 class="card-title"><?php echo $number_of_products; ?></h3>
                  <p class="card-text">Products Added</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php 
                     $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('Query failed');
                     $number_of_users = mysqli_num_rows($select_users);
                  ?>
                  <h3 class="card-title"><?php echo $number_of_users; ?></h3>
                  <p class="card-text">Normal Users</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php 
                     $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('Query failed');
                     $number_of_admins = mysqli_num_rows($select_admins);
                  ?>
                  <h3 class="card-title"><?php echo $number_of_admins; ?></h3>
                  <p class="card-text">Admin Users</p>
               </div>
            </div>
         </div>

         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body text-center">
                  <?php 
                     $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('Query failed');
                     $number_of_account = mysqli_num_rows($select_account);
                  ?>
                  <h3 class="card-title"><?php echo $number_of_account; ?></h3>
                  <p class="card-text">Total Accounts</p>
               </div>
            </div>
         </div>

      </div>

   </section>
</div>
<!-- Admin Dashboard Section Ends -->

<!-- Bootstrap JS and Dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
