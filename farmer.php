<?php
session_start();
require "services.php";
$db = new AccountService();
$farmer = $db->get('FARMERS', '*', "(LOGIN='" . $_SESSION['user'] . "');");
if ($farmer->rowCount() == 0) {
    echo "false";
    return;
} else {
    if (isset($_SESSION['farmer'])) {
        unset($_SESSION['farmer']); // kvoli content.php
        echo false;
    } else {
        $_SESSION['farmer'] = $_SESSION['user']; //kvoli content.php
        echo true;
    }
}
