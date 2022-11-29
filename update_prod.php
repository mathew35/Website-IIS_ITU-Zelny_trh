<?php
require 'services.php';
session_start();
$db = new AccountService();
$db->update('SPECIFIC_CROP', 'CROP_NAME=\'' . $_POST['cropname'] . '\',CROP=\'' . $_POST['crop'] . '\',CATEGORY=\'' . $_POST['category'] . '\',AMOUNT=\'' . $_POST['amount'] . '\',PRICE=\'' . $_POST['price'] . '\',PER_UNIT=\'' . $_POST['unit'] . '\',PHOTO_URL=\'' . $_POST['photo'] . '\',DESCRIPTION=\'' . $_POST['description'] . '\',CROPLOCATION=\'' . $_POST['location'] . '\'', "CROPID='" . $_POST['id'] . "'");
