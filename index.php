<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
   header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <!-- Font Awesome CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Optional: Include your custom CSS for homepage here -->
   <link rel="stylesheet" href="css/homepage.css">
   <link rel="stylesheet" href="css/header.css"> <!-- Link your header.css -->
   <link rel="stylesheet" href="css/footer.css"> <!-- Link your footer.css -->
</head>
<body>

<?php include 'header.php'; ?>

<main>
   <div class="container mt-4">
      <div class="intro text-center">
         <h1>World of Light Novels</h1>
         <p>Buy or borrow books that you like!</p>
         <a href="buy.php" target="_blank" class="btn btn-primary">Buy Now!</a>
      </div>

      <div class="row mt-4">
         <div class="col-md-4">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Leaderboards</h5>
                  <p class="card-text">Daily and Weekly Ranking available.</p>
                  <img src="/WebDevelopment/public_html/image/ranking1.jpg" class="img-fluid" alt="Leaderboard Image">
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Newcomers</h5>
                  <p class="card-text">Newest released series.</p>
                  <img src="/WebDevelopment/public_html/image/newcomer1.jpg" class="img-fluid" alt="Newcomers Image">
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Buy Now</h5>
                  <p class="card-text">Upcoming Big Hits.</p>
                  <img src="/WebDevelopment/public_html/image/preorder1.jpg" class="img-fluid" alt="Preorder Image">
               </div>
            </div>
         </div>
      </div>

      <div class="row mt-4">
         <div class="col-md-8">
            <div class="about-me">
               <div class="about-me-text">
                  <h2>About Us</h2>
                  <p>This is a website powered by the collaboration from Japan light novel company Dengeki Bunko, manga company SHUEISHA to provide the best services.</p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <img src="/WebDevelopment/public_html/image/about_us.webp" class="img-fluid" alt="About Us Image">
         </div>
      </div>
   </div>
</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS and your custom JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
