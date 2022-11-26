<?php 
    require_once "services.php";
    function joinharv($data){
        session_start();
        $db = new AccountService();
        $eid = $data;
        $user = $_SESSION['user'];
        $db->add("HARVEST_EVENT_ATTENDANTS", "(" . $eid . ", ' . $user .')"); // přidat přímo usera v session
        echo $eid;
    }

    if (isset($_POST['param1'])) {
        joinharv($_POST['param1']);
    }
?>
