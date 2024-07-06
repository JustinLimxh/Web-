<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['add_books'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $pdf = $_FILES['pdf']['name'];
    $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
    $pdf_folder = 'uploaded_pdf/' . $pdf;

    // Check if the user exists
    $user_check_query = "SELECT id FROM `users` WHERE id = '$user_id'";
    $result = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($result) > 0) {
        // User exists, insert book details
        move_uploaded_file($pdf_tmp_name, $pdf_folder);
        $insert_query = "INSERT INTO `user_book` (user_id, product_name, pdf) VALUES ('$user_id', '$product_name', '$pdf')";
        mysqli_query($conn, $insert_query) or die('Query failed');
        header('location:admin_userBook.php');
        exit();
    } else {
        echo 'User does not exist';
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_pdf_query = mysqli_query($conn, "SELECT pdf FROM `user_book` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_pdf = mysqli_fetch_assoc($delete_pdf_query);
    unlink('uploaded_pdf/' . $fetch_delete_pdf['pdf']);
    mysqli_query($conn, "DELETE FROM `user_book` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_userBook.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Books</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/WebDevelopment/public_html/CSS/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">User Books</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="id">User ID</label>
                                <input type="text" name="id" class="form-control" id="id" placeholder="Enter User ID"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" name="product_name" class="form-control" id="product_name"
                                    placeholder="Enter Product Name" required>
                            </div>
                            <div class="form-group">
                                <label for="pdf">PDF File</label>
                                <input type="file" name="pdf" class="form-control-file" id="pdf" accept="application/pdf"
                                    required>
                            </div>
                            <button type="submit" name="add_books" class="btn btn-primary">Add Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Books List</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $select_pdf = mysqli_query($conn, "SELECT * FROM `user_book`") or die('query failed');
                        if (mysqli_num_rows($select_pdf) > 0) {
                            while ($fetch_products = mysqli_fetch_assoc($select_pdf)) {
                        ?>
                        <div class="media mb-3">
                            <img src="uploaded_pdf/<?php echo $fetch_products['pdf']; ?>" class="mr-3" alt="..."
                                style="width: 100px;">
                            <div class="media-body">
                                <h5 class="mt-0"><?php echo $fetch_products['product_name']; ?></h5>
                                <a href="admin_userBook.php?delete=<?php echo $fetch_products['id']; ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo '<p class="text-muted">No products added yet!</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
