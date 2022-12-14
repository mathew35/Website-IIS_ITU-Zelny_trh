<?php
// Author: Alena Klimecká

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
        echo "<h2>" . $name[0] . "</h2>";
    }

    public function getLocation()
    {
        $getlocation = $this->db->get("SPECIFIC_CROP", "CROPLOCATION", "CROPID=" . $this->id);
        $location = $getlocation->fetch();
        echo "<p>Lokace: " . $location[0] . "</p>";
    }

    public function getFarmer()
    {
        $gettext = $this->db->get("SPECIFIC_CROP", "FARMER", "CROPID=" . $this->id);
        $text = $gettext->fetch();
        echo "<p>Farma: " . $text[0] . "</p>";
    }

    public function getDescript()
    {
        $gettext = $this->db->get("SPECIFIC_CROP", "DESCRIPTION", "CROPID=" . $this->id);
        $text = $gettext->fetch();
        echo "<p>Popis: " . $text[0] . "</p>";
    }

    public function getPrice()
    {
        $getprice = $this->db->get("SPECIFIC_CROP", "PRICE", "CROPID=" . $this->id);
        $price = $getprice->fetch();
        $getunit = $this->db->get("SPECIFIC_CROP", "PER_UNIT", "CROPID=" . $this->id);
        $unit = $getunit->fetch();
        echo "<p>"  . $price[0] . " Kč / " . $unit[0] ."</p>";
    }

    public function getavailable()
    {
        $getamount = $this->db->get("SPECIFIC_CROP", "AMOUNT", "CROPID=" . $this->id);
        $amount = $getamount->fetch();

        $getunit = $this->db->get("SPECIFIC_CROP", "PER_UNIT", "CROPID=" . $this->id);
        $unit = $getunit->fetch();

        echo "<p>Skladem: "  . $amount[0] . " " . $unit[0] ."</p>";
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
        echo "<p>Průměr: " . round($avg, 0) . "/5 Hvězdiček </p>";
    }

    public function getRatings()
    {

        $getstars = $this->db->get("RATING", "STARS", "CROP=" . $this->id);
        $stars = $getstars->fetch();
        $gettext = $this->db->get("RATING", "DESCRIPTION", "CROP=" . $this->id);
        $text = $gettext->fetch();
        for ($i = 0; $i < $getstars->rowCount(); $i++) {
            echo '<div class="detail-column detail-left">';
            echo "<p>" . "Hodnocení: " . $text[0] . "</p>";
            echo '</div>';
            echo '<div class="detail-column detail-right">';
            echo "<p>" . $stars[0] . " Hvězdiček " . "</p>";
            echo '</div>';
            $stars = $getstars->fetch();
            $text = $gettext->fetch();
        }
    }

    public function newrate(){
        echo '<button onclick="myrate(' . $this->id . ')">Přidat hodnocení</button>';
    }

    public function addAmount()
    {
        $amount = 0;
        $crop = $this->id; 
        echo '<button type="submit" class="buythis" onclick="buyproduct(' . $amount . ',' . $crop . ')">Do košíku</button>';

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

$product = new ProductDetail($_GET['detail']); 

?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Product </title>
	<link rel="stylesheet" href="../styles/productstyle.css">
</head>
    <div class="detail-container">
        <div class="detail">
            <a href="index3.php"><button id="myBtn" class="back">Zpět</button></a>
			<div class="detail-column detail-left">
                <?php   
                    $product->getName();
                    $product->getFarmer();
                    $product->getLocation();
                    $product->getDescript();
                ?>
			</div>
			<div class="detail-column detail-right">
                <input type="number" id="myText" min="1" value="0">
                <?php 
                    $product->getPrice();
                    $product->getavailable();
                    $product->addAmount();
                    ?>
			</div>

            <div class="detail-column detail-left">
                <?php $product->getAvgRatings(); ?>
			    <button type="submit" class="harvest" onclick="openReview()">Recenze</button>
		    </div>
		    <div class="detail-column detail-right">
			    <button type="submit" class="harvest" onclick="openHarvest()">Samosběry</button>	
            </div>
        </div>

		<div class="detail-harvest" id="detail-harvest">
            <button type="button" class="back" onclick="closeHarvest()">Close</button>
            <div class="popup-harvest">
                <?php $product->harvest(); ?>
            </div>
			
			
		</div>

        <div class="detail-review" id="detail-review">
            <button type="button" class="back" onclick="closeReview()">Close</button>
            Hodnocení: <input type="text" id="myRating">
            <input type="number" min="0" max="5" id="myStars" value="0">
            <?php $product->newrate(); ?>
			<?php $product->getRatings();?>	   
			
		</div>
    </div>
<script> 			
let harvest = document.getElementById("detail-harvest");
let review = document.getElementById("detail-review");

function openHarvest (){
	harvest .classList.add("open-popup");	
}
function closeHarvest (){
	harvest .classList.remove("open-popup");
}
function openReview(){
	review.classList.add("open-popup");	
}
function closeReview(){
	review.classList.remove("open-popup");
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
    amount = document.getElementById("myText").value;
    $.ajax({
        url: 'buyproduct.php',
        type: 'post',
        data: { "paramount": amount, "parpid": pid},
        success: function(response) { alert(response); }
    });
}
function myrate(cid){
    text = document.getElementById("myRating").value;
    stars = document.getElementById("myStars").value;
    $.ajax({
        url: 'rateproduct.php',
        type: 'post',
        data: { "ptext": text, "pstars": stars, "pcid": cid},
        success: function(response) { alert(response); }
    });

}


</script>