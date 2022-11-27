<?php 
    require "services.php";
    function buyitem($text, $stars, $crop){
        session_start();
        $db = new AccountService();
        $user = $_SESSION['user'];

        $getfarmer = $db->get("SPECIFIC_CROP", "FARMER", "CROPID='" . $crop . "'");
        $farmer = $getfarmer->fetch();

        echo "recenze byla přidána";

        $db->add("RATING", "(NULL,'".$stars."','".$text."','".$user."','".$farmer[0]."','".$crop."')");

    }

    if (isset($_POST['pstars'])) {
        buyitem($_POST['ptext'], $_POST['pstars'], $_POST['pcid']);
    }
?>