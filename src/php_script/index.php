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
    <div class="container">
        <header class="header">
            <div class="nav-container">
                <nav class="menu">
                    <a class="active" role='button' href='?category=ovocie'>Ovocie</a>
                    <a role='button' href='?category=zelenina'>Zelenina</a>

                    <a role='button' href='?category=farmers'>Farmári</a>
                    <a role='button' href='?category=events'>Samozbery</a>
                </nav>

                <nav class="logo" id="logo">
                    <!-- logo -->
                </nav>

                <nav class="credents" id='credents'>
                    <!-- credents buttons -->
                </nav>
            </div>
        </header>

        <?php
        if (isset($_GET['detail'])) {
            include 'productdetail.php';
        }
        ?>

        <section class="filter-section">
            <div class="filter-slide">
                <div class="filters" id="filters">

                    <?php
                    if ($_GET["category"] == "farmers" || $_GET["category"] == "events") {
                        echo "<div id='filter' style=\"display: none;\"";
                    } else {
                        echo "<div id='filter' style=\"display: ;\"";
                    }
                    ?>
                    <?php include 'filters.php'; ?>

                </div>
            </div>
        </section>

        <section class="shop-items" id="table">
            <?php
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
        </section>

        <!-- <footer>footer fooo</footer> -->
    </div>
</body>
<script src="../js/logo.js"></script>
<script src="../js/credents.js"></script>
<script src="../js/filters.js"></script>

</html>
