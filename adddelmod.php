<?php 
    require "services.php";
    function addmoderator($userid){
        // $db = new AccountService();
        // $db->remove("ACCOUNTS", "ID='" . $userid . "'");
        // echo $userid . " byl jmenován moderátorem";
    }

    function deletemod($userid){
        // $db = new AccountService();
        // $db->remove("ACCOUNTS", "ID='" . $userid . "'");
        // echo $userid . " byl jmenován moderátorem";
    }

    if ($_POST['param2']==0) {
        addmoderator($_POST['param']);
    }
    else{
        deletemod($_POST['param']);
    }
?>
