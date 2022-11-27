<?php
require "services.php";
session_start();
$db = new AccountService();
$items = $db->get('CART_CROP', '*', "(CARTID='" . $_SESSION['cartid'] . "'");
$arr = $items->fetch();
echo $arr[0];
for ($i = 0; $i < $cart->rowCount(); $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $arr[$j] . " ";
    }
}
