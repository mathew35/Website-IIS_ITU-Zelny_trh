<?php 
    require_once "services.php";
    function joinharv($data){
        $db = new AccountService();
        $eid = $data;
        $db->add("HARVEST_EVENT_ATTENDANTS", "(" . $eid . ", 'xmnamka55')"); // přidat přímo usera v session
        echo $eid;
    }

    if (isset($_POST['param1'])) {
        joinharv($_POST['param1']);
    }
?>
