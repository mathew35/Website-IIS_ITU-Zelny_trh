<?php 
// Author: Alena Klimecká

    require "../php_ajax/services.php";
    
    function joinharv($data){
        session_start();
        $db = new AccountService();
        $eid = $data;

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user']; 
            $db->add("HARVEST_EVENT_ATTENDANTS", "('".$eid."','".$user."')");
            echo "Uživatel " . $user . " byl úspěšně přihlášen na samosběr " . $eid . ".";
        }
        else{
            echo "Je nutné se nejprve přihlásit.";
        }
    }

    function leaveharv($data){
            session_start();
            $db = new AccountService();
            $eid = $data;

            if(isset($_SESSION['user'])){
                $user = $_SESSION['user']; 
                $db->remove("HARVEST_EVENT_ATTENDANTS", " EVENTID = '{$eid}' AND LOGIN = '{$user}'" );
                echo "Uživatel " . $user . " byl úspěšně odhlášen ze samosběru " . $eid . ".";
            }
            else{
                echo "Je nutné se nejprve přihlásit.";
            }
        }

        if (isset($_POST['param1'])) {
            joinharv($_POST['param1']);
        }



    if (isset($_POST['param1'])) {
        joinharv($_POST['param1']);
    }
    elseif(isset($_POST['param2'])) {
        leaveharv($_POST['param2']);
    }
