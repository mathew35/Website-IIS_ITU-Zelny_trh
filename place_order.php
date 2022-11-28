<?php
session_start();
require 'services.php';
$db = new AccountService();
// $crop = $db->get('SPECIFIC_CROP', '*', "(CROPID='" . $_POST['cropid'] . "')");
// $crop = $crop->fetch();
// $cartCrop = $db->get('CART_CROP', '*', "(CARTID='" . $_SESSION['cartid'] . "' AND CROPID='" . $_POST['cropid'] . "')");
// $cartCrop = $cartCrop->fetch();
// $newAmount = $crop['AMOUNT'] - $_POST['ammount'];
// $db->update('SPECIFIC_CROP', 'AMOUNT=' . $newAmount, '(CROPID=' . $_POST['cropid'] . ")");

$cartCrops = $db->get('CART_CROP', '*', "(CARTID='" . $_SESSION['cartid'] . "')");
$cartCrop = $cartCrops->fetch();
for ($i = 0; $i < $cartCrops->rowCount(); $i++) {
    $specificCrop = $db->get('SPECIFIC_CROP', '*', "(CROPID='" . $cartCrop['CROPID'] . "')");
    $specificCrop = $specificCrop->fetch();
    $amm = $specificCrop['AMOUNT'] - $cartCrop['AMOUNT'];
    $db->update('SPECIFIC_CROP', 'AMOUNT=' . $amm, "CROPID=" . $specificCrop['CROPID']);

    $db->add('ORDERS', "(NULL," . $_SESSION['cartid'] . ",'" . date("Y-m-d") . "','" . date("Y-m-d") . "','" . $specificCrop['FARMER'] . "'," . $cartCrop['CROPID'] . "," . $cartCrop['AMOUNT'] . ",0)");
    $cartCrop = $cartCrops->fetch();
}

unset($_SESSION['cartid']);

$db->update('SHOPPING_CART', 'IN_USE=0', 'USER=\'' . $_SESSION['user'] . '\'');
$cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND IN_USE=1)");
if ($cart->rowCount() == 0) {
    $db->add('SHOPPING_CART', "(NULL,'" . $_SESSION['user'] . "',0,0,1)");
    $cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND IN_USE=1)");
}
$arr = $cart->fetch();
echo $arr[0];
$_SESSION['cartid'] = $arr[0];
