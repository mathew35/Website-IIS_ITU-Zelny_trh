<?php
session_start();
require 'services.php';
$db = new AccountService();
$crop = $db->get('SPECIFIC_CROP', '*', "(CROPID='" . $_POST['cropid'] . "')");
$crop = $crop->fetch();
$cartCrop = $db->get('CART_CROP', '*', "(CARTID='" . $_SESSION['cartid'] . "' AND CROPID='" . $_POST['cropid'] . "')");
$cartCrop = $cartCrop->fetch();
$diff = $crop['AMOUNT'] - $_POST['ammount'];
// $newAmount = $crop['AMOUNT'] + $diff;
if ($diff < 0) {
    echo "fail";
    return;
}
// $db->update('SPECIFIC_CROP', 'AMOUNT=' . $newAmount, '(CROPID=' . $_POST['cropid'] . ")");
if ($_POST['ammount'] > 0) {
    $db->update('CART_CROP', 'AMOUNT=' . $_POST['ammount'], '(CROPID=' . $_POST['cropid'] . " AND CARTID=" . $_SESSION['cartid'] . ")");
} else {
    $db->remove('CART_CROP', "(CARTID='" . $_SESSION['cartid'] . "' AND CROPID='" . $_POST['cropid'] . "')");
}
