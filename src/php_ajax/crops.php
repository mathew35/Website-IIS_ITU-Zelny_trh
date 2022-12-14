<?php
// Author: Matúš Vráblik

session_start();
require "services.php";
$db = new AccountService();
$crops = $db->get('CROP', '*', NULL);
if ($crops->rowCount() > 0) echo $crops->fetch()[0];
for ($i = 1; $i < $crops->rowCount(); $i++) {
    echo "," . $crops->fetch()[0];
}
