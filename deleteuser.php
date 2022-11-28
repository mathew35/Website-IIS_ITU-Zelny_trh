<?php 
    require "services.php";
    function deleteuser($userid){
        // $db = new AccountService();
        // $db->remove("ACCOUNTS", "ID='" . $userid . "'");
        // echo $userid . " byl odstraněn";
    }

    if (isset($_POST['param'])) {
        deleteuser($_POST['param']);
    }
?>
