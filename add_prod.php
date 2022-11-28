<?php
session_start();
require "services.php";
$db = new AccountService();
$cropPost = $_POST['crop'];
if ($cropPost == 'addNew') $cropPost = $_POST['newCrop'];
$crop = $db->get('CROP', '*', "(CROPTYPE='" . $_POST['crop'] . "');");
if ($crop->rowCount() == 0) {
    $db->add('CROP', "('" . $cropPost . "','" . $_POST['category'] . "')");
}
$crop = $db->get('CROP', '*', "(CROPTYPE='" . $_POST['crop'] . "');");
$crop = $crop->fetch();
$db->add('SPECIFIC_CROP', "(NULL, '" . $_POST['cropname'] . "','" . $cropPost . "','" . $_POST['category'] . "'," . $_POST['amount'] . "," . $_POST['price'] . "," . $_POST['unit'] . ",'" . $_POST['photo'] . "','" . $_POST['description'] . "','" . $_SESSION['user'] . "')");
$crop = $db->get('SPECIFIC_CROP', '*', "(FARMER='" . $_SESSION['user'] . "')");
for ($i = 0; $i < $crop->rowCount(); $i++) {
    $ret = $crop->fetch();
}
echo $ret[0];
for ($i = 1; $i < 9; $i++) {
    echo " " . $ret[$i];
}
