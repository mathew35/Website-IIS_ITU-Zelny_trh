<?php
session_start();
// Author: Matúš Vráblik

require "services.php";
if (!isset($_SESSION['user'])) {
    echo "USER NOT FOUND";
    return;
}
$db = new AccountService();
$farmer = $db->get('FARMERS', '*', "LOGIN='" . $_SESSION['user'] . "'");
if ($farmer->rowCount() != 0) return;
if ($_POST['ico'] == '') $_POST['ico'] = 0;
if ($_POST['phone'] == '') $_POST['phone'] = 0;
if ($_POST['iban'] == '') $_POST['iban'] = 0;
$db->add('FARMERS', "('" . $_SESSION['user'] . "','" . $_POST['address'] . "','" . $_POST['ico'] . "','" . $_POST['phone'] . "','" . $_POST['iban'] . "')");
echo "success";
