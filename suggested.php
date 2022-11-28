<?php 
    require "services.php";
    function deletesugg(){
        session_start();
        $db = new AccountService();
        $db->remove("SUGGESTED_CROP", "S_CROPTYPE=\"" . $_POST['cname'] . "\"");

    }

    function createnew(){
        session_start();
        $db = new AccountService();
        $db->add('CROP', "('" . $_POST['cname'] . "','" . $_POST['ctype'] . "')");
    }

    if ($_POST['par'] == 0) {
        deletesugg();
    }
    else{
        deletesugg();
        createnew();
    }
?>
