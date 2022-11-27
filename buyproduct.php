<?php 
    require "services.php";
    function buyitem($amount, $pid){
        session_start();
        $db = new AccountService();
        $user = $_SESSION['user'];
        //$cid = $_SESSION['cropid'];

        $getcid = $db->get("SHOPPING_CART", "CARTID", "USER='" . $user . "'");
        $cid = $getcid->fetch();

        $basketin = $db->get("CART_CROP", "AMOUNT", "CROPID='" . $pid . "'");

        if ($basketin->rowCount() != 0){
            $basket = $basketin->fetch();
            $amount = $amount + $basket[0];
            $db->update("CART_CROP", "AMOUNT='".$amount. "'", "CROPID='".$pid."'"); 
        }
        else{
            $db->add("CART_CROP", "('".$cid[0]."','".$pid."','".$amount."')"); 
        }
        echo "Uživatel " . $user . " má v košíku " . $amount . " kusů produktu " . $pid;
    }

    if ($_POST['paramount'] == NULL){
        echo "Není zadáno množství";
    }
    if (isset($_POST['paramount'])) {
        buyitem($_POST['paramount'], $_POST['parpid']);
    }
?>
