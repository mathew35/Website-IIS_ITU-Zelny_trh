<?php
// Author: Alena Klimecká

    require "services.php";
    function addmoderator($userid){
        $db = new AccountService();
        $db->update("ACCOUNTS", "MODERATE='". 2 . "'", "ID='" . $userid . "'");
        header("Refresh:1");

    }

    function deletemod($userid){
        $db = new AccountService();
        $db->update("ACCOUNTS", "MODERATE='". 0 . "'", "ID='" . $userid . "'");
        header("Refresh:1");
    }

    if ($_POST['param2']==0) {
        addmoderator($_POST['param']);
    }
    else if($_POST['param2']==2){
        deletemod($_POST['param']);
    }
?>

