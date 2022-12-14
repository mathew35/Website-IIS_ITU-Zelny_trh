<!-- Add a new crop_type -->
<img src="https://www.freeiconspng.com/uploads/vegetable-icon-png-0.png" style="width:20%; height:20%; float:left">
<div style="float:left">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div>
            <label for="text">Chýba ti kategória?</label>
        </div>
        <div>
            <ul style="float:left;padding-right:20px">
                <li>
                    <input type="radio" name="category" value="ovocie">
                    <label for="ovocie">Ovocie</label><br>
                </li>
                <li>
                    <input type="radio" name="category" value="zelenina">
                    <label for="zelenina">Zelenina</label><br>
                </li>
            </ul>
            <input placeholder="Zadaj požadovanú kategóriu..." type="text" name="text" id="text" style="margin-bottom:5px"><br>
            <input type="submit" value="Navrhni" style=" width:62px;margin:0 70px">
        </div>
        <div>

        </div>
    </form>
</div>

<?php
$db = new AccountService();

if (isset($_POST["text"]) && !empty($_POST["text"]) && isset($_POST["category"])) {
    $crop_type = ucfirst(strtolower($_POST['text']));
    $db->add("SUGGESTED_CROP", "(\"{$crop_type}\",\"{$_POST['category']}\")");
}


?>


<!-- Crop_type filter -->
<div id="filter_items" style="float:left">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <ul style="float:left">
            <li>
                <input type="radio" name="price" value="price_up">
                <label for="price_up">Od najlacnejšieho</label><br>
            </li>
            <li>
                <input type="radio" name="price" value="price_down">
                <label for="price_down">Od najdrahšieho</label><br>
            </li>
        </ul>
        <ul style="float:left; width:200px">

            <?php
            $db = new AccountService();
            $crop_type = $db->get("CROP", "CROPTYPE", "");
            $arr = $crop_type->fetch();

            for ($i = 0; $i < $crop_type->rowCount(); $i++) {
                echo <<<HTML
            <li class="filter-crops">
                <input type="checkbox" id="{$i}" name="{$i}" value="{$arr[0]}">
                <label for="{$i}">{$arr[0]}</label><br>
            </li>
HTML;
                $arr = $crop_type->fetch();
            }
            ?>

        </ul>
        <input type="submit" value="Filtruj" style="float:left;margin-right:20px; margin-top:50px">
    </form>
</div>
