<?php
// Author: Matúš Vráblik

require "services.php";
session_start();
$db = new AccountService();
$cart = $db->get('ACCOUNTS', '*', "(LOGIN='" . $_SESSION['user'] . "')");
$arr = $cart->fetch();
echo $arr[0];
for ($i = 0; $i < $cart->rowCount(); $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $arr[$j] . " ";
    }
}
