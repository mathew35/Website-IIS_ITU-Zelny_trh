<?php
session_start();
require 'services.php';
$db = new AccountService();
$db->update('ORDERS', 'PROCESSED=' . $_POST['status'], 'ORDERID=' . $_POST['id']);
