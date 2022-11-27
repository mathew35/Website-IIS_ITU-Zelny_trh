<?php 
    require "services.php";
    function joinharv($data){
        session_start();
        $db = new AccountService();
        $eid = $data;
        $user = $_SESSION['user'];
        $db->add("HARVEST_EVENT_ATTENDANTS", "('".$eid."','".$user."')");
        echo "Uživatel " . $user . " byl úspěšně přihlášen na samosběr " . $eid . ".";
    }

    if (isset($_POST['param1'])) {
        joinharv($_POST['param1']);
    }
?>
