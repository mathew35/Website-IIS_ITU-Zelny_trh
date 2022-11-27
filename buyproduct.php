<?php 
    require "services.php";
    function buyitem($amount, $pid){
        session_start();
        $db = new AccountService();
        $user = $_SESSION['user'];

        $getcid = $db->get("SHOPPING_CART", "CARTID", "USER='" . $user . "'");
        $cid = $getcid->fetch();

        $db->add("CART_CROP", "('".$cid[0]."','".$pid."','".$amount."')");

        echo "Uživatel " . $user . " přidal " . $amount . " kusů produktu " . $pid;
    }

    if (isset($_POST['paramount'])) {
        buyitem($_POST['paramount'], $_POST['parpid']);
    }
?>
