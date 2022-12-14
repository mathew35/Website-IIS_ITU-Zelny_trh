<?php
// Author: Matúš Vráblik

require "services.php";
session_start();
$db = new AccountService();
$items = $db->remove('CART_CROP', "(CARTID='" . $_SESSION['cartid'] . "')");
