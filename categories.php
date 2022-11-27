<?php
session_start();
require "services.php";
$db = new AccountService();
$categories = $db->get('CATEGORY', '*', NULL);
if ($categories->rowCount() > 0) echo $categories->fetch()[0];
for ($i = 1; $i < $categories->rowCount(); $i++) {
    echo "," . $categories->fetch()[0];
}
