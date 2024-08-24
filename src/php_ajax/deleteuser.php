<?php 
// Author: Alena Klimecká

    require "services.php";
    function deleteuser($userid){
        echo "tady bude uzivatel smazan";
        //TODO - Napojeni na vsechno s nim souvisejici
        // $db = new AccountService();
        // $db->remove("ACCOUNTS", "ID='" . $userid . "'");
        // echo $userid . " byl odstraněn";
    }

    if (isset($_POST['param'])) {
        deleteuser($_POST['param']);
    }
?>
