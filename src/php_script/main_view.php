<!-- Author: Natália Bubáková -->

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
</head>

<div id="tableItems">
    <?php
    $db = new AccountService();


    if ($_GET["category"] == "farmers") {
        echo "<h1>FARMÁRI</h1>";

        // SELECT A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN
        // FROM ACCOUNTS A, FARMERS F
        // WHERE A.LOGIN = F.LOGIN;
        $crops = $db->get("ACCOUNTS A, FARMERS F","A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN","A.LOGIN = F.LOGIN");
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
    } elseif ($_GET["category"] == "events") {
        echo "<h1>SAMOZBERY</h1>";

        // // SELECT E.EVENTID, E.DATE_FROM, E.DATE_TO, E.PLACE, E.DESCRIPTION, E.POSTEDBY,C.EVENTID, C.CROPID, S.CROPID, S.CROP_NAME
        // // FROM HARVEST_EVENT E, HARVEST_CROP C, SPECIFIC_CROP S
        // // WHERE E.EVENTID = C.EVENTID AND C.CROPID = S.CROPID
        // // GROUP BY C.CROPID
        // // ORDER BY C.EVENTID ASC;
        $crops = $db->get("HARVEST_EVENT E, HARVEST_CROP C, SPECIFIC_CROP S","E.EVENTID, E.DATE_FROM, E.DATE_TO, E.PLACE, E.DESCRIPTION, E.POSTEDBY, C.EVENTID, C.CROPID, S.CROPID, S.CROP_NAME","E.EVENTID = C.EVENTID AND C.CROPID = S.CROPID ORDER BY C.EVENTID ASC");
        $arr = $crops->fetch();

        $crop_sum = "{$arr['CROP_NAME']}";
        for ($i = 0; $i < $crops->rowCount(); $i++) {
            $tmp_arr = $arr;
            $tmp_id = $arr['EVENTID'];
            $arr = $crops->fetch();

            if ($tmp_id == $arr['EVENTID'])
                $crop_sum = "{$crop_sum}" . ", " . "{$arr['CROP_NAME']}";
            else {
                echo "<div class='tableItemFarmer'>";
                echo "<div class='item_col'><p><span>Zberané plodiny:</span> {$crop_sum}</p>";
                echo "<p><span>Organizátor samozberu:</span> {$tmp_arr['POSTEDBY']}</p></div>";
                echo "<div class='item_col'><p><span>Kedy?</span> od {$tmp_arr['DATE_FROM']} do {$tmp_arr['DATE_TO']}</p>";
                echo "<p><span>Kde?</span> {$tmp_arr['PLACE']}</p></div>";
                echo "<div class='item_col'><p><span>Popis:</span></p><p>{$tmp_arr['DESCRIPTION']}</p></div>";
                if(isset($_SESSION['user']))
                {
                    if ($db->get("HARVEST_EVENT_ATTENDANTS", "*", "LOGIN = \"{$_SESSION['user']}\" AND EVENTID = \"{$tmp_arr['EVENTID']}\"")->fetch()[0] == NULL)
                        echo '<button type="submit" class="logharvest" onclick="joinharvest(' . $tmp_arr['EVENTID'] . ')">Zúčastnit se</button>';
                    else {
                        echo "<h4>MÁM ZÁUJEM</h4>";
                        echo '<button type="submit" class="logharvest2" onclick="leaveharvest(' . $tmp_arr['EVENTID'] . ')">Zrušiť záujem</button>';
                    }
                }
                echo "</div>";
                $crop_sum =  "{$arr['CROP_NAME']}";
            }
        }
    } else {

        if (isset($_POST["price"]) || isset($_POST["price"]))
            $order = ($_POST["price"] == "price_down") ? "DESC" : "ASC";
        else
            $order = "";

        $filter_bool = false;
        for ($i = 0; $i < $crop_type->rowCount(); $i++) {
            $filter = (isset($_POST["{$i}"])) ? $_POST["{$i}"] : "";
            $filter_bool = (isset($_POST["{$i}"]) || $filter_bool);
            if ($i == 0)
                $condition = "CROP=" . "\"{$filter}\"";
            else
                $condition = "{$condition}" . " OR " . "CROP=" . "\"{$filter}\"";
        }


        if ($filter_bool || $order != "")    // crop_type filter is set
        {
            if (!$filter_bool)
                $condition = "1";
            if($order != "")
                $condition = "{$condition}"." ORDER BY PRICE {$order}";
            $crops = $db->get("SPECIFIC_CROP", "*", "{$condition}");
        }
        else{               // default filter is used
            if ($_GET['category'] == 'ovocie' || $_GET['category'] == 'zelenina')
                $crops = $db->getCrops("{$_GET['category']}");
            else
                $crops = $db->getCrops(NULL);
        }


        $arr = $crops->fetch();
        
        $getstars = $db->get("RATING", "STARS", "CROP=" . $arr['CROPID']);
        $stars = $getstars->fetch();
        // $stars_obj = $stars[0]*"*";
      

        for ($i = 0; $i < $crops->rowCount(); $i++) {
            echo "<div class='tableItem' id=\"{$arr['CROP_NAME']}\"  style=\"background-image: url({$arr['PHOTO_URL']});\" >";
            echo "<h2><span>{$arr['CROP_NAME']}</span></h2>";
            echo "<p><span>{$arr['FARMER']}</span></p>";
            echo "<p><span><span class='price'>{$arr['PRICE']} Kč</span> / {$arr['PER_UNIT']}</span></p>";
            echo '<p><a href="index.php?detail='. $arr['CROPID'] .'"><button id="myBtn">Detail</button></a></p>';
            echo "</div>";

            // echo "<div class='shop-item' id=\"{$arr['CROP_NAME']}\">";
            // echo '<a href=\"index.php?detail='. $arr['CROPID'] .'\" class=\"shop-item--container\">';
            // // echo "<div class=\"meta\"> <span class=\"discount\">$stars *</span></div>";
            // echo "<img src=\"{$arr['PHOTO_URL']}\" width=\"160\" height=\"160\">";
            // echo "</a>";
            // echo "<div class=\"title\"><h3><a href=\"#\">{$arr['CROP_NAME']}</a></h3><h4>{$arr['FARMER']}</h4></div>";
            // echo "<div class=\"price\"><span>{$arr['PRICE']} Kč</span> / {$arr['PER_UNIT']}</span></div>";
            // // echo '<p><a href="index.php?detail='. $arr['CROPID'] .'"><button id="myBtn">Detail</button></a></p>';
            // echo "</div>";
            $arr = $crops->fetch();
        }
    }

    ?>
</div>




<script>
    function joinharvest(eid) {
        $.ajax({
            url: 'joinharvest.php',
            type: 'post',
            data: {
                "param1": eid
            },
            success: function(response) {
                alert(response);
            }
        });
    }

    function leaveharvest(eid) {
        $.ajax({
            url: 'joinharvest.php',
            type: 'post',
            data: {
                "param2": eid
            },
            success: function(response) {
                alert(response);
            }
        });
    }
</script>
