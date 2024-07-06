<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){
   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- Bootstrap CSS link -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/admin_style.css"> 

   <style>
      .form-control {
         display: inline-block;
         width: auto;
      }
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="container mt-5">
   <h1 class="mb-4">Placed Orders</h1>

   <div class="row">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="col-lg-4 col-md-6 mb-4">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Order ID: <?php echo $fetch_orders['id']; ?></h5>
               <p class="card-text"><strong>User ID:</strong> <?php echo $fetch_orders['user_id']; ?></p>
               <p class="card-text"><strong>Name:</strong> <?php echo $fetch_orders['name']; ?></p>
               <p class="card-text"><strong>Number:</strong> <?php echo $fetch_orders['number']; ?></p>
               <p class="card-text"><strong>Email:</strong> <?php echo $fetch_orders['email']; ?></p>
               <p class="card-text"><strong>Total Products:</strong> <?php echo $fetch_orders['total_products']; ?></p>
               <p class="card-text"><strong>Total Price:</strong> RM<?php echo $fetch_orders['total_price']; ?></p>
               <p class="card-text"><strong>Payment Method:</strong> <?php echo $fetch_orders['method']; ?></p>
               <form action="" method="post" class="mb-2">
                  <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                  <select name="update_payment" class="form-control mr-2">
                     <option value="<?php echo $fetch_orders['payment_status']; ?>" selected disabled><?php echo ucfirst($fetch_orders['payment_status']); ?></option>
                     <option value="pending">Pending</option>
                     <option value="completed">Completed</option>
                  </select>
                  <input type="submit" value="Update" name="update_order" class="btn btn-primary">
               </form>
               <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" 
                  class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $fetch_orders['id']; ?>">Delete</a>
            </div>
         </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal<?php echo $fetch_orders['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $fetch_orders['id']; ?>" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel<?php echo $fetch_orders['id']; ?>">Confirm Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  Are you sure you want to delete order with ID <?php echo $fetch_orders['id']; ?>?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="btn btn-danger">Delete</a>
               </div>
            </div>
         </div>
      </div>
      <?php
         }
      } else {
         echo '<p class="text-center w-100">No orders placed yet!</p>';
      }
      ?>
   </div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
