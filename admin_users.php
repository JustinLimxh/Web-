<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- Bootstrap CSS link -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/admin_style.css"> 

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="container mt-5">
   <h1 class="mb-4">User Accounts</h1>

   <div class="row">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         if(mysqli_num_rows($select_users) > 0){
            while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="col-lg-4 col-md-6 mb-4">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title"><?php echo $fetch_users['name']; ?></h5>
               <p class="card-text"><strong>User ID:</strong> <?php echo $fetch_users['id']; ?></p>
               <p class="card-text"><strong>Email:</strong> <?php echo $fetch_users['email']; ?></p>
               <p class="card-text">
                  <strong>User Type:</strong> 
                  <span class="<?php echo $fetch_users['user_type'] == 'admin' ? 'text-warning' : ''; ?>">
                     <?php echo $fetch_users['user_type']; ?>
                  </span>
               </p>
               <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" 
                  class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $fetch_users['id']; ?>">Delete</a>
            </div>
         </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal<?php echo $fetch_users['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $fetch_users['id']; ?>" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel<?php echo $fetch_users['id']; ?>">Confirm Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  Are you sure you want to delete user <strong><?php echo $fetch_users['name']; ?></strong> with ID <strong><?php echo $fetch_users['id']; ?></strong>?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" class="btn btn-danger">Delete</a>
               </div>
            </div>
         </div>
      </div>
      <?php
         }
      } else {
         echo '<p class="text-center w-100">No users found!</p>';
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
