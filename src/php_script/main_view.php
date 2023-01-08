<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
</head>

<?php

// Author: Natália Bubáková


$db = new AccountService();

/****** FARMERS_LIST ******/

if ($_GET["category"] == "farmers") {
    echo "<div class=\"farmer-items\">";
    echo "<h1>FARMÁRI</h1>";

    // SELECT A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN
    // FROM ACCOUNTS A, FARMERS F
    // WHERE A.LOGIN = F.LOGIN;
    $crops = $db->get("ACCOUNTS A, FARMERS F", "A.LOGIN, A.FULLNAME, A.EMAIL, F.LOGIN, F.ADDRESS, F.ICO, F.PHONE, F.IBAN", "A.LOGIN = F.LOGIN");
    $arr = $crops->fetch();

    for ($i = 0; $i < $crops->rowCount(); $i++) {
        echo "<div class='farmer-item' id=\"{$arr['CROP_NAME']}\">";
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
    echo "</div>";


/****** EVENTS_LIST ******/

} elseif ($_GET["category"] == "events") {
    echo "<div class=\"event-items\">";
    echo "<h1>SAMOZBERY</h1>";

    // // SELECT E.EVENTID, E.DATE_FROM, E.DATE_TO, E.PLACE, E.DESCRIPTION, E.POSTEDBY,C.EVENTID, C.CROPID, S.CROPID, S.CROP_NAME
    // // FROM HARVEST_EVENT E, HARVEST_CROP C, SPECIFIC_CROP S
    // // WHERE E.EVENTID = C.EVENTID AND C.CROPID = S.CROPID
    // // GROUP BY C.CROPID
    // // ORDER BY C.EVENTID ASC;
    $crops = $db->get("HARVEST_EVENT E, HARVEST_CROP C, SPECIFIC_CROP S", "E.EVENTID, E.DATE_FROM, E.DATE_TO, E.PLACE, E.DESCRIPTION, E.POSTEDBY, C.EVENTID, C.CROPID, S.CROPID, S.CROP_NAME", "E.EVENTID = C.EVENTID AND C.CROPID = S.CROPID ORDER BY C.EVENTID ASC");
    $arr = $crops->fetch();

    $crop_sum = "{$arr['CROP_NAME']}";
    for ($i = 0; $i < $crops->rowCount(); $i++) {
        $tmp_arr = $arr;
        $tmp_id = $arr['EVENTID'];
        $arr = $crops->fetch();

        if ($tmp_id == $arr['EVENTID'])
            $crop_sum = "{$crop_sum}" . ", " . "{$arr['CROP_NAME']}";
        else {
            echo "<div class='event-item'>";
            echo "<div class='item_col'><p><span>Zberané plodiny:</span> {$crop_sum}</p>";
            echo "<p><span>Organizátor samozberu:</span> {$tmp_arr['POSTEDBY']}</p></div>";
            echo "<div class='item_col'><p><span>Kedy?</span> od {$tmp_arr['DATE_FROM']} do {$tmp_arr['DATE_TO']}</p>";
            echo "<p><span>Kde?</span> {$tmp_arr['PLACE']}</p></div>";
            echo "<div class='item_col'><p><span>Popis:</span></p><p>{$tmp_arr['DESCRIPTION']}</p></div>";
            if (isset($_SESSION['user'])) {
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
    echo "</div>";


/****** PRODUCTS_LIST ******/

} else {
    echo "<div class=\"shop-items\">";

    if (isset($_POST["price"]) || isset($_POST["price"]))
        $order = ($_POST["price"] == "price_down") ? "DESC" : "ASC";
    else
        $order = "";

    $filter_bool = false;
    for ($i = 0; $i < $crop_type->rowCount()+2; $i++) {
        $filter = (isset($_POST["{$i}"])) ? $_POST["{$i}"] : "";
        $filter_bool = (isset($_POST["{$i}"]) || $filter_bool);
        if ($filter == "Ovocie" || $filter == "Zelenina" )
            ;
        else
        {
            if ($i == 1)
                $condition = "CROP=" . "\"{$filter}\"";
            else
                $condition = "{$condition}" . " OR " . "CROP=" . "\"{$filter}\"";
        }

        
        
    }
    // $condition = "{$condition}" . " OR " . "CATEGORY=" . "\"ovocie\"";

    if ($filter_bool || $order != "")    // crop_type filter is set
    {
        if (!$filter_bool)
            $condition = "1";
        if ($order != "")
            $condition = "{$condition}" . " ORDER BY PRICE {$order}";
        $crops = $db->get("SPECIFIC_CROP", "*", "{$condition}");
    } else {               // default filter is used
            $crops = $db->getCrops(NULL);
    }


    $arr = $crops->fetch();

    // for each product
    for ($i = 0; $i < $crops->rowCount(); $i++) {
        $getstars = $db->get("RATING", "STARS", "CROP=" . $arr['CROPID']);
        $stars = $getstars->fetch();
        $count = $getstars->rowCount();
        $sum = 0;
        $avg_stars = 0;
        for ($j = 0; $j < $count; $j++) {
            $sum += $stars[0];
            $stars = $getstars->fetch();
        }
        if ($count != 0) {
            $avg_stars = $sum / $count;
        }
        $stars_obj="";
        for ($s = 0; $s < 5; $s++) {
            if ($s<$avg_stars)
                $stars_obj .= "&#9733;";
            else
                $stars_obj .= "&#9734;";
        }
    
        echo "<div class='shop-item' id=\"{$arr['CROP_NAME']}\"  style=\"background-image: url({$arr['PHOTO_URL']});\" >";
        echo '<a href="index.php?detail=' . $arr['CROPID'] . '">';
        echo "<div class='shop-item--strip'>";
        echo "<div class=\"line\"> <h3>{$arr['CROP_NAME']}</h3><span class=\"stars\">$stars_obj</span></div>";
        echo "<div class=\"line\"> <p class=\"farmer\">{$arr['FARMER']}</p>";
        echo "<p class='price'><span>{$arr['PRICE']}</span> Kč</span> / {$arr['PER_UNIT']}</p></div>";
        echo "</div></a></div>";

        $arr = $crops->fetch();
    }
    
    echo "</div>";
}

?>




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
