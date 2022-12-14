<?php
// Author: Matúš Vráblik

    require "services.php";
    function editcrop(){
        $db = new AccountService();

        $db->update('SPECIFIC_CROP', 'CROP=\'' . $_POST['cnew'] . '\'', 'CROP=\'' . $_POST['cold'] . '\'');
        $db->update('CROP', 'CROPTYPE=\'' . $_POST['cnew'] . '\'', 'CROPTYPE=\'' . $_POST['cold'] . '\'');

    }

    if (isset($_POST['cnew'])) {
        editcrop();
    }
?>