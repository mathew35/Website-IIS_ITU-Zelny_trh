<?php 
    require "services.php";
    function addmoderator($userid){
        $db = new AccountService();
        $db->update("ACCOUNTS", "MODERATE='". 2 . "'", "ID='" . $userid . "'");
        echo "Uživatel byl jmenován moderátorem";
    }

    function deletemod($userid){
        $db = new AccountService();
        $db->update("ACCOUNTS", "MODERATE='". 0 . "'", "ID='" . $userid . "'");
        echo "Uživatel už není moderátorem";
    }

    if ($_POST['param2']==0) {
        addmoderator($_POST['param']);
    }
    else if($_POST['param2']==2){
        deletemod($_POST['param']);
    }
    else{
        echo "Adminovi nelze upravovat roli";
    }
?>
