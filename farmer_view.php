<table>
    <?php
    $serv = new AccountService();

    // if ($_GET['category'] == 'ovocie') {
    //     $crops = $serv->getCrops("ovocie");
    // } else if ($_GET['category'] == 'zelenina') {
    //     $crops = $serv->getCrops("zelenina");
    // } else {
    //     $crops = $serv->getCrops(NULL);
    // }

    // todo function for getCropsOf(farmer_name)
    $crops = $serv->getCrops(NULL);
    
    if ($crops->rowCount() > 0) {
        echo "<tr>";
    }
    $arr = $crops->fetch();
    $width = 6;
    for ($i = 0; $i < $crops->rowCount(); $i++) {
        echo "<td><div id='tableItem'>";
        for ($j = 0; $j < 4; $j++) {
            echo $arr[$j] . " ";
        }
        echo "</div></td>";
        $arr = $crops->fetch();
        if ($i % 5 == 0 && $i != 0 && $i + 1 != $crops->rowCount()) echo "</tr><tr>";
    }
    if ($crops->rowCount() % 6 != 0) {
        $i = $crops->rowCount() % 6;
        for ($j = $i; $j < 6; $j++) {
            echo "<td><div id='tableItem' style='visibility: hidden;'>placeholder</div></td>";
        }
    }
    if ($crops->rowCount() > 0) {
        echo "</tr>";
    }
    ?>
</table>
