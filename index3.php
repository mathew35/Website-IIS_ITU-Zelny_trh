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
    <script src="farmer_view.js"></script>
</head>

<body>
    <nav>
        <div id='navbar'>
            <div id='logo'>
                <!-- <?php
                        include 'logo.php';
                        ?> -->
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
                <!-- <?php
                        include 'credents.php';
                        ?> -->

            </div>
        </div>
    </nav>
    <div id="table">
        <?php
        include 'content.php';
        ?>
    </div>
    <footer>footer fooo</footer>
</body>
<script src="credents.js"></script>
<script src="logo.js"></script>

</html>
