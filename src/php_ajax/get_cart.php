<?php
// Author: Matúš Vráblik

require "services.php";
session_start();
$db = new AccountService();
//kosik novy atribut spracovava sa ?
$cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND IN_USE=1)");
if ($cart->rowCount() == 0) {
    $db->add('SHOPPING_CART', "(NULL,'" . $_SESSION['user'] . "',0,0,1)");
    $cart = $db->get('SHOPPING_CART', '*', "(USER='" . $_SESSION['user'] . "' AND IN_USE=1)");
}
$arr = $cart->fetch();
echo $arr[0];
$_SESSION['cartid'] = $arr[0];
// for ($i = 0; $i < $cart->rowCount(); $i++) {
//     for ($j = 0; $j < 4; $j++) {
//         echo $arr[$j] . " ";
//     }
// }
