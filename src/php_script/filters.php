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

            
                <div id="fltr-btts">
                    <input class="filter-button" type="submit" value="Filtruj">
                    <button class="filter-button" onclick='reset_filter()'>Reset</button>
                </div>
            </div>
        </ul>
    </form>


<div id="filter-search">
    <input type="text" id="search_input" name="search" placeholder="Hľadaj v ponuke..." style="float:left;">
</div>
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

    $(document).ready(function(){
        $("#search_input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".shop-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

  </script>


