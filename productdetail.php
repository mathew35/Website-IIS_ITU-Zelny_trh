<?php

include "harvestdetail.php";
require_once "services.php";
class ProductDetail
{
    private $id;
    private $db;

    public function __construct($id)
    {
        $this->id = $id;
        $this->db = new AccountService();
    }


    public function getName()
    {
        $getname = $this->db->get("SPECIFIC_CROP", "CROP_NAME", "CROPID=" . $this->id);
        $name = $getname->fetch();
        echo $name[0] . "<br>";
    }

    // pridat puvod
    public function getLocation()
    {
        //nejdrive potreba pridat lokaci
    }

    // pridat farmare 
    public function getFarmer()
    {
        $gettext = $this->db->get("SPECIFIC_CROP", "FARMER", "CROPID=" . $this->id);
        $text = $gettext->fetch();
        echo "Farma: " . $text[0] . "<br>";
    }

    public function getDescript()
    {
        $gettext = $this->db->get("SPECIFIC_CROP", "DESCRIPTION", "CROPID=" . $this->id);
        $text = $gettext->fetch();
        echo "Popis: " . $text[0] . "<br>";
    }

    public function getPrice()
    {
        $getprice = $this->db->get("SPECIFIC_CROP", "PRICE", "CROPID=" . $this->id);
        $price = $getprice->fetch();
        echo $price[0] . " Kč<br>";
    }

    public function getAvgRatings()
    {

        $getstars = $this->db->get("RATING", "STARS", "CROP=" . $this->id);
        $stars = $getstars->fetch();
        $count = $getstars->rowCount();
        $sum = 0;
        $avg = 0;
        for ($i = 0; $i < $count; $i++) {
            $sum += $stars[0];
            $stars = $getstars->fetch();
        }
        if($count != 0){
            $avg = $sum / $count;
        }
        echo "Průměr: " . round($avg, 0) . "/5 Hvězdiček <br>";
    }

    public function getRatings()
    {

        $getstars = $this->db->get("RATING", "STARS", "CROP=" . $this->id);
        $stars = $getstars->fetch();
        $gettext = $this->db->get("RATING", "DESCRIPTION", "CROP=" . $this->id);
        $text = $gettext->fetch();
        for ($i = 0; $i < $getstars->rowCount(); $i++) {
            echo $stars[0] . " Hvězdiček <br>";
            echo "Hodnocení: " . $text[0] . " <br>";
            $stars = $getstars->fetch();
            $text = $gettext->fetch();
        }
    }

    public function addAmount()
    {
        //ziskat amount od uzivatele
        $crop = $this->id; 
        $amount = 1;
        echo '<button type="submit" class="buythis" onclick="buyproduct(' . $amount . ',' . $crop . ')">Do košíku</button>';

        //vlozit do cart_crop/shopping_cart ?
        //$this->db->add("CART_CROP", "(" . 55 . $crop . $amount . ")");
    }

    public function harvest()
    {
        $getplace = $this->db->get("HARVEST_EVENT E, HARVEST_CROP C", "E.EVENTID", "E.EVENTID = C.EVENTID AND C.CROPID=" . $this->id);
        $place = $getplace->fetch();

        for ($i = 0; $i < $getplace->rowCount(); $i++) {
            echo '<div class="column left">';
            $harvestdetail = new HarvestDetail($this->id, $place[0]);
            $harvestdetail->getName();
            $harvestdetail->getPlace();
            $harvestdetail->getDate();
            $harvestdetail->getDescript();
            echo '</div>';

            echo '<div class="column right">';
            echo '<button type="submit" class="logharvest" onclick="joinharvest(' . $place[0] . ')">Zúčastnit se</button>';
            echo '</div>';


            $place = $getplace->fetch();
        }

    }
    

}
if(isset($_GET['detail'])){
    $product = new ProductDetail($_GET['detail']); // zde budeme volat prislusne ID produktu 
    $product->getName();
    $product->getFarmer();
    $product->getLocation();
    $product->getDescript();
    $product->getPrice();

    $product->addAmount();

    $product->getAvgRatings();
    $product->getRatings();
}

?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Product </title>
	<link rel="stylesheet" href="productstyle.css">
</head>
	
		<button type="submit" class="harvest" onclick="openPopup()">Samosběr</button>
		<div class="popup" id="popup">
            <div class="popup-harvest">
                <?php $product->harvest() ?>
            </div>
			<button type="button" onclick="closePopup()">Close</button>
			
		</div>
	

<script> 			
let popup = document.getElementById("popup");

function openPopup(){
	popup.classList.add("open-popup");	
}
function closePopup(){
	popup.classList.remove("open-popup");
}
function joinharvest(eid){
    $.ajax({
        url: 'joinharvest.php',
        type: 'post',
        data: { "param1": eid},
        success: function(response) { alert(response); }
    });
}
function buyproduct(amount, pid){
    $.ajax({
        url: 'buyproduct.php',
        type: 'post',
        data: { "paramount": amount, "parpid": pid},
        success: function(response) { alert(response); }
    });
}



</script>