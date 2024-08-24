<?php 
// Author: Alena Klimecká

    require "../php_ajax/services.php";
    function buyitem($text, $stars, $crop){
        session_start();
        $db = new AccountService();

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];

            $getfarmer = $db->get("SPECIFIC_CROP", "FARMER", "CROPID='" . $crop . "'");
            $farmer = $getfarmer->fetch();

            $db->add("RATING", "(NULL,'".$stars."','".$text."','".$user."','".$farmer[0]."','".$crop."')");
            echo "recenze byla přidána";
        }
        else{
            echo "Je nutné se nejprve přihlásit.";
        }
        
    }

    if (isset($_POST['pstars'])) {
        buyitem($_POST['ptext'], $_POST['pstars'], $_POST['pcid']);
    }
?>
