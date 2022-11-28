<?php
session_start();
require 'services.php';
$db = new AccountService();
$db->update('ORDERS', 'PROCESSED=' . $_POST['status'], 'ORDERID=' . $_POST['id']);
if ($_POST['status'] == 2) {
    $order = $db->get('ORDERS', 'CROPID,AMOUNT', 'ORDERID=\'' . $_POST['id'] . '\'');
    $crop = $db->get('SPECIFIC_CROP', 'AMOUNT', 'CROPID=\'' . $_POST['id'] . '\'');
    $order = $order->fetch();
    $crop = $crop->fetch();
    $db->update('SPECIFIC_CROP', 'AMOUNT=\'' . $crop['AMOUNT'] + $order['AMOUNT'] . '\'', 'CROPID=\'' . $order['CROPID'] . '\'');
}
