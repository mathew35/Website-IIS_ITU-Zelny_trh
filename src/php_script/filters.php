<?php
// Author: Natália Bubáková -->
?>

<!-- Add a new crop_type -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<img src="https://www.freeiconspng.com/uploads/vegetable-icon-png-0.png" style="width:20%; height:20%; float:left">
<div id="filter-categories">
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
<div id="filter-items">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <ul id="filter-radio-list">
            <li>
                <input type="radio" name="price" value="price_up">
                <label for="price_up">Od najlacnejšieho</label><br>
            </li>
            <li>
                <input type="radio" name="price" value="price_down">
                <label for="price_down">Od najdrahšieho</label><br>
            </li>
        </ul>
        <ul id="filter-checkbox-list">
            
            <?php
            $db = new AccountService();
            $crop_type = $db->get("CROP", "CROPTYPE, CATEGORY", "1 ORDER BY CATEGORY");
            $arr = $crop_type->fetch();

            $crop_category = "";
            for ($i = 0; $i < $crop_type->rowCount()+2; $i++) {
                if ($arr[1] == $crop_category){
                    echo <<<HTML
                    <li class="filter-crops">
                        <input class="{$crop_category}" type="checkbox" id="{$i}" name="{$i}" value="{$arr[0]}">
                        <label for="{$i}">{$arr[0]}</label><br>
                    </li>
HTML;
                    $arr = $crop_type->fetch();
                }
                else
                {   
                    if ($crop_category == "")
                        echo "<div class=\"filter-col\">";
                    else
                        echo "</div><div class=\"filter-col\">";
                    
                    $crop_category = $arr[1];
                    echo <<<HTML
                    <li class="filter-crops">
                        <input class="{$crop_category}-all" type="checkbox" id="{$i}" name="{$i}" value="{$crop_category}">
                        <label for="{$i}">{$crop_category}</label><br>
                    </li>

HTML;
                }
            }
            ?>

            </div>
        </ul>
        <input type="submit" value="Filtruj" style="float:left;margin-right:20px; margin-top:50px">
    </form>
    <button onclick='reset_filter()'>Reset</button>
</div>

<div id="filter-search">
    <input type="text" id="search_input" name="search" placeholder="Zadaj názov plodiny..." style="float:left;">
    <button onclick="filter_search()" id ="search_button" style="float:left;margin-left:-52px; margin-top:50px; width:52px">Hľadaj</button>
</div>

<script>

    // to remember checked boxes when reloaded
    var checkboxValue = JSON.parse(localStorage.getItem('checkboxValue')) || {}
    var $checkbox = $("#filter-checkbox-list :checkbox");

    $checkbox.on("change", function() {
      $checkbox.each(function() {
        checkboxValue[this.id] = this.checked;
      });
      localStorage.setItem("checkboxValue", JSON.stringify(checkboxValue));
    });
    
    $.each(checkboxValue, function(key, value) {    //on page load
      $("#" + key).prop('checked', value);
    });


    // to check all crops when whole category checked
    $('.Ovocie-all').click(function() {
        $(this.form.elements).filter('.Ovocie:checkbox').prop('checked', this.checked);
    });

    $('.Zelenina-all').click(function() {
        $(this.form.elements).filter('.Zelenina:checkbox').prop('checked', this.checked);
    });

    $('.Ovocie').click(function() {
        $('.Ovocie-all').prop('checked', false);
    });

    $('.Zelenina').click(function() {
        $('.Zelenina-all').prop('checked', false);
    });

    // function for reset button
    function reset_filter() {
        $('input').prop('checked', false);
        localStorage.clear();
    }

    // avoid the warning window when refreshing
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        localStorage.clear();
    }

    function filter_search() {
        input = document.getElementById("search_input");
        filter = input.value.toUpperCase();

        items = document.getElementsByClassName("shop-item");
        for (i = 0; i < items.length; i++) {
            if (items[i].id.toUpperCase().indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }

  </script>


