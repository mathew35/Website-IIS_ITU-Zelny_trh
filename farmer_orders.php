<?php
session_start();
require "services.php";
$db = new AccountService();
$crops = $db->get('ORDERS', '*', "(FARMER='" . $_SESSION['user'] . "')");
if ($crops->rowCount() == 0) {
    return;
}
$arr = $crops->fetch();
for ($j = 0; $j < $arr->ob_get_length(); $j++) {
    echo $arr[$j] . " ";
}
for ($i = 1; $i < $crops->rowCount(); $i++) {
    $arr = $crops->fetch();
    echo ",";
    for ($j = 0; $j < 4; $j++) {
        echo $arr[$j] . " ";
    }
}
