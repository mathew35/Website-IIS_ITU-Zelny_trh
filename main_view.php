<div id="tableItems">
    <?php
    $serv = new AccountService();


    if($_GET["category"]=="farmers")
    {
        // SELECT A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN
        // FROM ACCOUNTS A, FARMERS F
        // WHERE A.LOGIN = F.LOGIN;
        $crops = $serv->get("ACCOUNTS A, FARMERS F","A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN","A.LOGIN = F.LOGIN");
        $arr = $crops->fetch();

        for ($i = 0; $i < $crops->rowCount(); $i++) {
            echo "<div class='tableItemFarmer' id=\"{$arr['CROP_NAME']}\">";
            echo "<div class='item_col'><h2>{$arr['LOGIN']}</h2>";
            echo "<p>{$arr['FULLNAME']}</p></div>";
            echo "<div class='item_col'><p>E-mail: {$arr['EMAIL']}</p>";
            echo "<p>Tel.Číslo: {$arr['PHONE']}</p>";
            echo "<p>Adresa: {$arr['ADDRESS']}</p></div>";
            echo "<div class='item_col'><p>IČO: {$arr['ICO']}</p>";
            echo "<p>IBAN: {$arr['IBAN']}</p></div>";
            echo "</div>";
            $arr = $crops->fetch();
        }
        
    }
    elseif($_GET["category"]=="events")
    {

        $crops = $serv->get("HARVEST_EVENT","*","");
        $arr = $crops->fetch();

        for ($i = 0; $i < $crops->rowCount(); $i++) {
            echo "<div class='tableItemFarmer' id=\"{$arr['CROP_NAME']}\">";
            echo "<p>{$arr['DATE_FROM']}</p>";
            echo "<p>{$arr['DATE_TO']}</p>";
            echo "<p>{$arr['PLACE']}</p>";
            echo "<p>{$arr['POSTEDBY']}</p>";
            echo "<p>{$arr['DESCRIPTION']}</p>";
            echo "</div>";
            $arr = $crops->fetch();
        }
    }
    else
    {
        
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
            echo "<div class='tableItem' id=\"{$arr['CROP_NAME']}\"  style=\"background-image: url({$arr['PHOTO_URL']});\" >";
            echo "<h2><span>{$arr['CROP_NAME']}</span></h2>";
            echo "<p><span>{$arr['FARMER']}</span></p>";
            echo "<p><span><span class='price'>{$arr['PRICE']} Kč</span> / {$arr['PER_UNIT']}</span></p>";
            // echo "<p><span>{$arr['DESCRIPTION']}</span></p>";
            echo '<p><a href="index3.php?detail='. $arr['CROPID'] .'"><button id="myBtn">Detail</button></a></p>';
            echo "</div>";
            $arr = $crops->fetch();
        }
        
    }

    ?>
</div>



