<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

$message = [];

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image) VALUES('$user_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Books</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="products">
   <div class="container">
      <h2 class="title">Your Books</h2>

      <?php
      foreach ($message as $msg) {
         echo '<p class="message">' . $msg . '</p>';
      }
      ?>

      <div class="box-container">
         <?php
         $select_user_books = mysqli_query($conn, "SELECT * FROM `user_book` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_user_books) > 0){
            while($fetch_user_book = mysqli_fetch_assoc($select_user_books)){
               // Display user books along with other details
               echo '<form action="" method="post" class="box">';
               echo '<div class="user-book">';
               echo '<h3>' . $fetch_user_book['product_name'] . '</h3>';
               // You can add more details here as needed
               echo '<a href="view_user_book.php?pdf=' . $fetch_user_book['pdf'] . '">View Book</a>';
               echo '</div>';
               echo '</form>';
            }
         } else {
            echo '<p class="empty">Your bookshelf is empty!</p>';
         }
         ?>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
