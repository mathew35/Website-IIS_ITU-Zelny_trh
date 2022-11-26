<?php 
    require "services.php";
    function joinharvest($data){
        $db = new AccountService();
        $eid = $data;
        $db->add("HARVEST_EVENT_ATTENDANTS", "(" . $eid . ", 'xmnamka55')");
        echo $eid;
    }

    if (isset($_POST['param1'])) {
        joinharvest($_POST['param1']);
    }
?>
