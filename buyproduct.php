<?php 
    require "services.php";
    session_start();
    function buyitem($amount, $pid){
        $db = new AccountService();
        $user = $_SESSION['user'];
        $cid = $_SESSION['cartid'];

        $basketin = $db->get("CART_CROP", "AMOUNT", "CROPID='" . $pid . "' AND CARTID='" . $cid . "'");

        if ($basketin->rowCount() != 0){
            $basket = $basketin->fetch();
            $allamount = $amount + $basket[0];
            $db->update("CART_CROP", "AMOUNT='".$allamount. "'", "CARTID='".$cid."'"); 

            updateprice($pid, $cid, $amount);
        }
        else{
            $db->add("CART_CROP", "('".$cid."','".$pid."','".$amount."')"); 

            updateprice($pid, $cid, $amount);

            //kosik
            $getcount=$db->get("SHOPPING_CART", "ITEM_COUNT", "CARTID='" . $cid . "'");
            $count=$getcount->fetch();
            $sum=$count[0]+ 1;
            $db->update("SHOPPING_CART", "ITEM_COUNT='".$sum. "'", "CARTID='".$cid."'");
        }
        echo "Uživatel " . $user . " má v košíku " . $amount . " kusů produktu " . $pid;
    }

    function updateprice($pid, $cid, $amount){
        $db = new AccountService();
        $getpprice=$db->get("SPECIFIC_CROP", "PRICE", "CROPID='" . $pid . "'");
        $productprice=$getpprice->fetch();

        $price=$amount * $productprice[0];

        $getvalue=$db->get("SHOPPING_CART", "CART_VALUE", "CARTID='" . $cid . "'");
        $value=$getvalue->fetch();
        $totalprice=$value[0]+ $price;
        $db->update("SHOPPING_CART", "CART_VALUE='".$totalprice. "'", "CARTID='" . $cid . "'");
    }

    if (isset($_POST['paramount'])) {
        if(isset($_SESSION['user'])){
            buyitem($_POST['paramount'], $_POST['parpid']);
        }
        else{
            echo "Je nutné se nejprve přihlásit.";
        }
    }
?>
