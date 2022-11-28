<?php

    if (isset($_GET['detail'])) {
        include 'productdetail.php';
    }
    if (isset($_SESSION['farmer'])) {
        include 'farmer_view.php';
    } else {
        include 'main_view.php';
    }


// todo
