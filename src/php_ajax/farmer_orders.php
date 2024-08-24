<?php
// Author: Matúš Vráblik

session_start();
require "services.php";
$db = new AccountService();
$crops = $db->get('ORDERS', '*', "(FARMER='" . $_SESSION['user'] . "')");
if ($crops->rowCount() == 0) {
    return;
}
$arr = $crops->fetch();
for ($j = 0; $j < 8; $j++) {
    if ($j == 7) if ($arr[$j] == NULL) {
        echo "3 ";
        continue;
    }
    echo $arr[$j] . " ";
}
for ($i = 1; $i < $crops->rowCount(); $i++) {
    $arr = $crops->fetch();
    echo ",";
    for ($j = 0; $j < 8; $j++) {
        echo $arr[$j] . " ";
    }
}
