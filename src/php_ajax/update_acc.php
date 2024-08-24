<?php
// Author: Matúš Vráblik

require 'services.php';
session_start();
$db = new AccountService();
$db->update('ACCOUNTS', 'FULLNAME=\'' . $_POST['fullname'] . '\',EMAIL=\'' . $_POST['email'] . '\'', "LOGIN='" . $_SESSION['user'] . "'");
$db->update('FARMERS', 'ADDRESS=\'' . $_POST['address'] . '\',ICO=\'' . $_POST['ICO'] . '\',PHONE=\'' . $_POST['phone'] . '\',IBAN=\'' . $_POST['IBAN'] . '\'', "LOGIN='" . $_SESSION['user'] . "'");
// $db->update('ORDERS', 'PROCESSED=' . $_POST['status'], 'ORDERID=' . $_POST['id']);
