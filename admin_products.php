<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['add_product'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Product name already exists!';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'Image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      } else {
         $message[] = 'Product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Image file size is too large!';
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- Bootstrap CSS link -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- Product CRUD section starts -->
<section class="container mt-5">

   <h1 class="mb-4">Shop Products</h1>

   <!-- Add Product Form -->
   <form action="" method="post" enctype="multipart/form-data" class="mb-5">
      <div class="form-group">
         <label for="productName">Product Name</label>
         <input type="text" name="name" id="productName" class="form-control" placeholder="Enter product name" required>
      </div>
      <div class="form-group">
         <label for="productPrice">Product Price</label>
         <input type="number" min="0" name="price" id="productPrice" class="form-control" placeholder="Enter product price" required>
      </div>
      <div class="form-group">
         <label for="productImage">Product Image</label>
         <input type="file" name="image" id="productImage" accept="image/jpg, image/jpeg, image/png" class="form-control" required>
      </div>
      <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
   </form>

   <!-- Show Products -->
   <div class="row">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
         <div class="card h-100">
            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="Product Image">
            <div class="card-body">
               <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
               <p class="card-text">RM<?php echo $fetch_products['price']; ?></p>
               <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="btn btn-warning">Update</a>
               <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
         </div>
      </div>
      <?php
         }
      } else {
         echo '<p class="text-center w-100">No products added yet!</p>';
      }
      ?>
   </div>

</section>
<!-- Product CRUD section ends -->

<!-- Update Product Modal -->
<div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="updateProductModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="update_p_id" id="updateProductId">
               <input type="hidden" name="update_old_image" id="updateOldImage">
               <div class="form-group">
                  <label for="updateProductName">Product Name</label>
                  <input type="text" name="update_name" id="updateProductName" class="form-control" required>
               </div>
               <div class="form-group">
                  <label for="updateProductPrice">Product Price</label>
                  <input type="number" name="update_price" id="updateProductPrice" min="0" class="form-control" required>
               </div>
               <div class="form-group">
                  <label for="updateProductImage">Product Image</label>
                  <input type="file" name="update_image" id="updateProductImage" accept="image/jpg, image/jpeg, image/png" class="form-control">
               </div>
               <button type="submit" name="update_product" class="btn btn-primary">Update</button>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Populate Update Product Modal
$(document).on('click', '.btn-warning', function(e) {
   e.preventDefault();
   var productId = $(this).attr('href').split('=')[1];
   var card = $(this).closest('.card');
   var productName = card.find('.card-title').text();
   var productPrice = card.find('.card-text').text().substring(2);
   var productImage = card.find('img').attr('src').split('/').pop();
   
   $('#updateProductId').val(productId);
   $('#updateProductName').val(productName);
   $('#updateProductPrice').val(productPrice);
   $('#updateOldImage').val(productImage);

   $('#updateProductModal').modal('show');
});
</script>

</body>
</html>
