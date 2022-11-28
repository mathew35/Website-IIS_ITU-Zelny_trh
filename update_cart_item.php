<?php
session_start();
require 'services.php';
$db = new AccountService();
if ($_POST['ammount'] > 0) {
    $db->update('CART_CROP', 'AMOUNT=' . $_POST['ammount'], '(CROPID=' . $_POST['cropid'] . " AND CARTID=" . $_SESSION['cartid'] . ")");
} else {
    $db->remove('CART_CROP', "(CARTID='" . $_SESSION['cartid'] . "' AND CROPID='" . $_POST['cropid'] . "')");
}
