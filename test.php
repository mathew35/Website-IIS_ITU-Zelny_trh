<!DOCTYPE html>

<?php
function add($a,$b){
  $c=$a+$b;
  return $c;
}
function milt($a,$b){
  $c=$a*$b;
  return $c;
}

function divide($a,$b){
  $c=$a/$b;
  return $c;
}
?>	
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Product </title>
	<link rel="stylesheet" href="productstyle.css">
</head>
<body>
	<div class="container">
		<button type="submit" class="harvest" onclick="openPopup()">Sběr</button>
		<div class="popup" id="popup">
				<h2>Let's go harvest</h2>
				<p>next harvest will be</p>
				<script> 
				document.write(10);
				document.write(" <?php echo add(1,2); ?> ");
  				document.write(" <?php echo milt(1,2); ?> ");
  				document.write(" <?php echo divide(1,2); ?> ");
				</script> 
			<button type="button" onclick="closePopup()">OK</button>
			
		</div>
	</div>
<script> 
  					
let popup = document.getElementById("popup");

function openPopup(){
	
	popup.classList.add("open-popup");	
}
function closePopup(){
	popup.classList.remove("open-popup");
}
</script>
</body>
</html>