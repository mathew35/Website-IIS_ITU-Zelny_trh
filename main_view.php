<div id="tableItems">
    <?php
    $serv = new AccountService();


    if(isset($_POST["price"]) || isset($_POST["price"]))
        $order=($_POST["price"] == "price_down")?"DESC":"ASC";
    else
        $order="";
    
    $filter_bool=false;
    for ($i = 0; $i < $crop_type->rowCount(); $i++) {
        $filter=(isset($_POST["{$i}"]))?$_POST["{$i}"]:"";
        $filter_bool=(isset($_POST["{$i}"]) || $filter_bool);
        if ($i == 0)
            $condition = "CROP="."\"{$filter}\"";
        else
            $condition = "{$condition}"." OR ". "CROP="."\"{$filter}\"";
    }
    
    if($filter_bool || $order != "")    // crop_type filter is set
    {
        if(! $filter_bool)
            $condition = "1";
        if($order != "")
            $condition = "{$condition}"." ORDER BY PRICE {$order}";
        $crops = $serv->get("SPECIFIC_CROP", "*", "{$condition}");
    }
    else{               // default filter is used
        if ($_GET['category'] == 'ovocie' || $_GET['category'] == 'zelenina')
            $crops = $serv->getCrops("{$_GET['category']}");
        else
            $crops = $serv->getCrops(NULL);
    }


    $arr = $crops->fetch();

    for ($i = 0; $i < $crops->rowCount(); $i++) {
        echo "<div class='tableItem' id=\"{$arr['CROP_NAME']}\">";
        echo "<h2>{$arr['CROP_NAME']}</h2>";
        echo "<p>{$arr['FARMER']}</p>";
        echo "<p>{$arr['PRICE']} Kč / {$arr['PER_UNIT']}</p>";
        echo "<p>{$arr['DESCRIPTION']}</p>";
        echo '<p><a href="index3.php?detail='. $arr['CROPID'] .'"><button id="myBtn">Detail</button></a></p>';
        echo "</div>";
        $arr = $crops->fetch();
    }
    
    ?>
</div>



