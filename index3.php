<?php
session_start();
require "services.php";
// header("refresh:1;");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="VrablikWebIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Document</title>
    <script src="cart.js"></script>
    <script src="profile.js"></script>
    <script src="farmer_view.js"></script>
</head>

<body>
    <nav>
        <div id='navbar'>
            <div id='logo'>
                <!-- logo.js -->
            </div>
        </div>
        <div id='navbar'>
            <div id='category'>
                <?php
                include 'category.php';
                ?>
            </div>
        </div>
        <div id='navbar'>
            <div id='credents'>
                <!-- credents.js -->
            </div>
        </div>
    </nav>
    <div id='filter'>
        <!-- filters.js-->
        <?php
        include 'filters.php';
        ?>
    </div>
    <div id="table">
        <?php
        include 'content.php';
        ?>
    </div>
    <footer>footer fooo</footer>
</body>
<script src="logo.js"></script>
<script src="credents.js"></script>
<script src="filters.js"></script>
<!-- <script src="farmer_view.js"></script> -->

</html>
