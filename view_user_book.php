<?php

include 'config.php';

if (isset($_GET['pdf'])) {
    $pdf_name = $_GET['pdf'];

    $pdf_query = mysqli_query($conn, "SELECT pdf, product_name FROM `user_book` WHERE pdf = '$pdf_name'") or die('query failed');
    $fetch_pdf = mysqli_fetch_assoc($pdf_query);
    $pdf_path = 'uploaded_pdf/' . $fetch_pdf['pdf'];

    // Display the content of the user's PDF file
    if (file_exists($pdf_path)) {
        echo '<h2>' . $fetch_pdf['product_name'] . '</h2>';
        echo '<iframe src="uploaded_pdf/' . $fetch_pdf['pdf'] . '" width="100%" height="500px"></iframe>';
    } else {
        echo 'PDF file not found';
    }
} else {
    echo 'Invalid request';
}

?>
