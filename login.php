<?php
session_start();
require "services.php";
$db = new AccountService();
$user = $db->get('ACCOUNTS', '*', "(LOGIN='" . $_POST['login'] . "')");
if ($user->rowCount() == 0) {
    echo NULL;
    return;
}
$user = $user->fetch();
if (password_verify($_POST['password'], $user['PASSWORD'])) {
    if (isset($_SESSION['user'])) {
        echo "error";
    }
    $_SESSION['user'] = $_POST['login'];
};
echo $_SESSION['user'];
