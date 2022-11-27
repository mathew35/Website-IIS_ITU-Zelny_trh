<?php
session_start();
require 'services.php';
$db = new AccountService();
echo "yeeet";
// $db->update('ORDERS', 'PROCESSED=' . $_POST['status'], 'ORDERID=' . $_POST['id']);
