<?php 
    function deleteuser($userid){
        echo $userid . " bude vymazán tu";
    }

    if (isset($_POST['param'])) {
        deleteuser($_POST['param']);
    }
?>
