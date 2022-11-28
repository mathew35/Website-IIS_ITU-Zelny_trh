<?php
session_start();
require "services.php";
$db = new AccountService();
$user = $db->get('ACCOUNTS', '*', "(LOGIN='" . $_POST['login'] . "')");
if ($user->rowCount() != 0) {
    echo "Account already registered";
    return;
}
$pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
$db->add('ACCOUNTS', "(NULL,'" . $_POST['login'] . "','" . $pwd . "','" . $_POST['fullname'] . "','" . $_POST['email'] . "',NULL)");
echo "ok";
