<?php
require "services.php";
session_start();
$db = new AccountService();
$user = $db->get('ACCOUNTS', '*', "(LOGIN='" . $_SESSION['user'] . "')");
$arr = $user->fetch();
for ($i = 0; $i < $user->rowCount(); $i++) {
    for ($j = 3; $j < 5; $j++) {
        echo $arr[$j] . ";";
    }
}

$user = $db->get('FARMERS', '*', "(LOGIN='" . $_SESSION['user'] . "')");
$arr = $user->fetch();
for ($i = 0; $i < $user->rowCount(); $i++) {
    for ($j = 1; $j < 4; $j++) {
        echo $arr[$j] . ";";
    }
    echo $arr[$j];
}
