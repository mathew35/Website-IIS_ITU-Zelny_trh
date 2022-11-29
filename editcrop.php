<?php
    require "services.php";
    function editcrop(){
        $db = new AccountService();
        $db->update('CROP', 'CROPTYPE=\'' . $_POST['cnew'] . '\'', 'CROPTYPE=\'' . $_POST['cold'] . '\'');
    }

    if (isset($_POST['cnew'])) {
        editcrop();
    }
?>