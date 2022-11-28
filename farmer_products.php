<?php
session_start();
require "services.php";
$db = new AccountService();
$crops = $db->get('SPECIFIC_CROP', '*', "(FARMER='" . $_SESSION['user'] . "')");
if ($crops->rowCount() == 0) {
    return;
}
$arr = $crops->fetch();
for ($j = 0; $j < 10; $j++) {
    echo $arr[$j] . ";";
}
for ($i = 1; $i < $crops->rowCount(); $i++) {
    $arr = $crops->fetch();
    echo "~";
    for ($j = 0; $j < 10; $j++) {
        echo $arr[$j] . ";";
    }
}
