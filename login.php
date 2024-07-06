<?php
include 'config.php';
session_start();

$message = '';

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location: admin_page.php');
         exit();
      } elseif($row['user_type'] == 'user'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location: index.php');
         exit();
      }
   } else {
      $message = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/style.css">
   <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/LoginCSS.css">
   <style>
      /* Inline styles for simplicity */
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

      .message {
         text-align: center;
         color: #f44336;
         margin-top: 20px;
      }

      .message i {
         cursor: pointer;
      }

      .message i:hover {
         color: #333;
      }
   </style>
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>Login</h3>
         <?php if(!empty($message)): ?>
            <div class="message">
               <span><?php echo $message; ?></span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
         <?php endif; ?>
         <input type="email" name="email" placeholder="Enter your email" required class="box">
         <input type="password" name="password" placeholder="Enter your password" required class="box">
         <input type="submit" name="submit" value="Login" class="btn">
         <p>Don't have an account? <a href="register.php">Register Now</a></p>
      </form>
   </div>
</body>
</html>
