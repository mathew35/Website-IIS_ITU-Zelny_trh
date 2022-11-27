<?php
require "services.php";
session_start();
$db = new AccountService();
$items = $db->get('CART_CROP', '*', "(CARTID='" . $_SESSION['cartid'] . "')");
$arr = $items->fetch();
if ($items->rowCount() == 0) return;
for ($k = 0; $k < $items->rowCount(); $k++) {
    echo $arr[2] . " ";
    $crop = $db->get('SPECIFIC_CROP', '*', "(CROPID='" . $arr[2] . "')");
    $arr = $crop->fetch();
    for ($i = 0; $i < $crop->rowCount(); $i++) {
        for ($j = 0; $j < 7; $j++) {
            echo $arr[$j] . " ";
        }
    }
    if ($items->rowCount() - 1 != $k) echo ",";
    $arr = $items->fetch();
}
