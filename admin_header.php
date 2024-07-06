<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="alert alert-info alert-dismissible fade show" role="alert">
         <span>'.$msg.'</span>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      ';
   }
}
?>

<header class="header">

   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="admin_page.php">Admin<span>Panel</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item">
               <a class="nav-link" href="admin_page.php">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin_products.php">Products</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin_bproducts.php">Borrow Products</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin_users.php">Users</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin_orders.php">Orders</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin_userBook.php">User Book</a>
            </li>
         </ul>
         <ul class="navbar-nav">
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <p class="dropdown-item-text">Username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
                  <p class="dropdown-item-text">Email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Logout</a>
               </div>
            </li>
         </ul>
      </div>
   </nav>

</header>
