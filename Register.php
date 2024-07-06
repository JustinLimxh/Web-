<?php
include 'config.php';

$message = '';

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message = 'User already exists!';
   }else{
      if($pass != $cpass){
         $message = 'Confirm password does not match!';
      }else{
         mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$name', '$email', '$pass', '$user_type')") or die('query failed');
         $message = 'Registered successfully!';
         header('location: login.php');
         exit();
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS files -->
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/style.css">
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/LoginCSS.css">

   <style>
      /* Additional inline styles for simplicity */
      body {
         font-family: Arial, sans-serif;
         background-color: #f0f0f0;
         margin: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      .form-container {
         width: 100%;
         max-width: 360px;
         padding: 20px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .form-container h3 {
         font-size: 24px;
         text-align: center;
         margin-bottom: 20px;
         color: #333;
      }

      .box {
         width: 100%;
         padding: 10px;
         margin-bottom: 15px;
         border: 1px solid #ccc;
         border-radius: 4px;
         font-size: 16px;
         box-sizing: border-box;
      }

      .btn {
         width: 100%;
         padding: 12px;
         background-color: #333;
         color: #fff;
         font-size: 18px;
         border: none;
         cursor: pointer;
         border-radius: 4px;
         text-transform: uppercase;
         transition: background-color 0.3s ease;
      }

      .btn:hover {
         background-color: #555;
      }

      p {
         text-align: center;
         margin-top: 15px;
         color: #333;
      }

      p a {
         color: #333;
         text-decoration: none;
         font-weight: bold;
      }

      p a:hover {
         text-decoration: underline;
      }

      .message {
         text-align: center;
         color: #f44336;
         margin-top: 20px;
      }
   </style>
</head>
<body>



<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <?php if(!empty($message)): ?>
         <div class="message">
            <span><?php echo $message; ?></span>
         </div>
      <?php endif; ?>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>
</div>

</body>
</html>
