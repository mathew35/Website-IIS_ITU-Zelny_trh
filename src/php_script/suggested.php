<?php 
// Author: Alena Klimecká

    require "../php_ajax/services.php";
    function deletesugg(){
        $db = new AccountService();
        $db->remove("SUGGESTED_CROP", "S_CROPTYPE=\"" . $_POST['cname'] . "\"");

    }

    function createnew(){
        $db = new AccountService();
        $db->add('CROP', "('" . $_POST['cname'] . "','" . $_POST['ctype'] . "')");
    }

    if ($_POST['par'] == 0) {
        deletesugg();
    }
    else if($_POST['par'] == 10){
        createnew();
    }
    else{
        deletesugg();
        createnew();
    }
