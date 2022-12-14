<?php
session_start();
require "../php_ajax/services.php";

// ADMIN 1 / MODERATOR 2
if (isset($_SESSION['user'])) {
    $database = new AccountService();
    $getrole = $database->get("ACCOUNTS", "MODERATE", "LOGIN=\"" . $_SESSION['user'] . "\"");
    $role = $getrole->fetch();

    if ($role[0] == 1) {
        echo '<p><a href="adminmode.php"><button>Admin mode</button></a></p>';
    } else if ($role[0] == 2) {
        echo '<p><a href="moderator.php"><button>Moderate mode</button></a></p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="VrablikWebIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css" type="text/css">
    <title>Document</title>
    <script src="../js/cart.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/farmer_view.js"></script>
</head>

<body>
    <nav>
        <div id='navbar'>
            <div id='logo'>
            </div>
        </div>
        <div id='navbar'>
            <div id='category'>
                <?php include 'category.php'; ?>
            </div>
        </div>
        <div id='navbar'>
            <div id='credents'>
            </div>
        </div>
    </nav>
    <?php
    if ($_GET["category"] == "farmers" || $_GET["category"] == "events") {
        echo "<div id='filter' style=\"display: none;\"";
    } else {
        echo "<div id='filter' style=\"display: ;\"";
    }
    ?>
    <?php include 'filters.php'; ?>
    </div>
    <div id="table">
        <?php
        if (isset($_GET['detail'])) {
            include 'productdetail.php';
        }
        if (isset($_SESSION['farmer'])) {
        ?>
            <script>
                farmer_view_pick()
            </script>
        <?php
        } else {
            include 'main_view.php';
        }
        ?>

    </div>
    <footer>footer fooo</footer>
</body>
<script src="../js/logo.js"></script>
<script src="../js/credents.js"></script>
<script src="../js/filters.js"></script>

</html>
