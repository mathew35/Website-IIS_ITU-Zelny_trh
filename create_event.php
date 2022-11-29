<?php
require "services.php";
session_start();
$db = new AccountService();
$db->add('HARVEST_EVENT', "(NULL,'" . $_POST['datefrom'] . "','" . $_POST['dateto'] . "','" . $_POST['place'] . "','" . $_POST['description2'] . "','" . $_SESSION['user'] . "')");

$events = $db->get('HARVEST_EVENT', 'EVENTID', '1');
$event = $events->fetch();
for ($i = 0; $i < $events->rowCount(); $i++) {
    $harvestCrops = $db->get('HARVEST_CROP', '*', "EVENTID='" . $event['EVENTID'] . "'");
    $harvestCrop = $harvestCrops->fetch();
    if ($harvestCrops->rowCount() == 0) {
        $newEvent = $event;
        break;
    }
    $event = $events->fetch();
}
if ($newEvent == NULL) return;
$db->add('HARVEST_CROP', "(" . $_POST['id2'] . "," . $event['EVENTID'] . ")");
