<!-- Add a new crop_type -->
<div>
  <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
    <div>
            <label for="text">Chýba ti kategória?</label>
    </div><div>
        <ul>
            <li>
                <input type="radio" name="category" value="ovocie">
                <label for="ovocie">Ovocie</label><br>
            </li>
            <li>
                <input type="radio" name="category" value="zelenina">
                <label for="zelenina">Zelenina</label><br>
            </li>
        </ul>
            <input placeholder="Zadaj požadovanú kategóriu..." type="text" name="text" id="text"><br>
            <input type="submit" value="Navrhni">
    </div><div>
           
    </div>
    </form> 
</div>

<?php
    $db = new AccountService();

    if(isset($_POST["text"]) && !empty($_POST["text"]) && isset($_POST["category"]))
    {   
        $crop_type = ucfirst(strtolower($_POST['text']));
        $db->add("CROP","(\"{$crop_type}\",\"{$_POST['category']}\")");
    }
        

?>


<!-- Crop_type filter -->
<div id="filter_items" >
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
        <ul>
            <li>
                <input type="radio" name="price" value="price_up">
                <label for="price_up">Od najlacnejšieho</label><br>
            </li>
            <li>
                <input type="radio" name="price" value="price_down">
                <label for="price_down">Od najdrahšieho</label><br>
            </li>
        </ul>
        <ul>

<?php
    $db = new AccountService();
    $crop_type = $db->get("CROP","CROPTYPE","");
    $arr = $crop_type->fetch();

    for ($i = 0; $i < $crop_type->rowCount(); $i++) {
        echo <<<HTML
            <li>
                <input type="checkbox" id="{$i}" name="{$i}" value="{$arr[0]}">
                <label for="{$i}">{$arr[0]}</label><br>
            </li>
HTML;
        $arr = $crop_type->fetch();
    }           
?>

            <input type="submit" value="Filtruj">
        </ul> 
    </form> 
</div>
