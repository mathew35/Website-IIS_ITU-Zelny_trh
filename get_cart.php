<?php
require "services.php";
session_start();
$db = new AccountService();
//kosik novy atribut spracovava sa ?
$cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND ITEM_COUNT=0)");
if ($cart->rowCount() == 0) {
    $db->add('SHOPPING_CART', "(NULL,'" . $_SESSION['user'] . "',0,0)");
    $cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND ITEM_COUNT=0)");
}
$arr = $cart->fetch();
echo $arr[0];
$_SESSION['cartid'] = $arr[0];
// for ($i = 0; $i < $cart->rowCount(); $i++) {
//     for ($j = 0; $j < 4; $j++) {
//         echo $arr[$j] . " ";
//     }
// }
