<?php
// Author: Alena Klimecká

require_once "services.php";
class ModMode
{
    private $db;

    public function __construct()
    {
        $this->db = new AccountService();
    }

    public function getCrop()
    {

        $getscrop = $this->db->get("CROP", "*", "");
        $crop = $getscrop->fetch();
        
        for ($i = 0; $i < $getscrop->rowCount(); $i++) {
            echo "<p>" . $crop[1] . " : " . $crop[0];
            echo ' <input type="text" id="xrename'.$i.'">';
            echo ' <button onclick="editcrop(\'' . $crop[1] . '\',\'' . $crop[0] . '\','. $i .')">Přejmenovat</button></p>';

            $crop = $getscrop->fetch();
        }
    }
    public function getNewCrop()
    {

        $getncrop = $this->db->get("SUGGESTED_CROP", "*", "");
        $ncrop = $getncrop->fetch();
        
        for ($i = 0; $i < $getncrop->rowCount(); $i++) {
            echo "<p>" . $ncrop[1] . " : " . $ncrop[0];
            echo ' <button onclick="suggested(\'' . $ncrop[1] . '\',\'' . $ncrop[0] . '\', 1 )">Přijmout</button>';
            echo ' <button onclick="suggested(\'' . $ncrop[1] . '\',\'' . $ncrop[0] . '\', 0 )">Odmítnout</button>'.'</p>';
            $ncrop = $getncrop->fetch();
        }
    }
    
}
$moder = new ModMode();
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../styles/adminstyle.css">
</head>
<body>
    <p><a href="index3.php"><button>User mode</button></a>
    <div class="admin-container">
        <div class="admin-informations-container">
            <div class="admin-informations-header">
                <h2> Správa kategorií </h2>
            </div>
            <div class="admin-informations-content"> 
                <p>Nová plodina: 
                <select name="category" id="xtype" multiple>
                    <option value="Ovocie">Ovocie</option>
                    <option value="Zelenina">Zelenina</option>
                </select>
                <input type="text" id="xcrop">
                <button type="button" onclick="addnewcrop()">Přidat</button></p>
                <h1> Existující kategorie </h1>
                <?php $moder->getCrop();?>
            </div>
            <div class="admin-informations-content"> 
                <h1> Navrhované kategorie </h1>
                <?php $moder->getNewCrop();?>
            </div>
        </div>
    </div>

</body>
</html> 

<script>
    function addnewcrop(){
        ctype = document.getElementById("xtype").value;
        cname = document.getElementById("xcrop").value;
        par01 = 10;
        $.ajax({
        url: 'suggested.php',
        type: 'post',
        data: { "ctype": ctype, "cname": cname, "par": par01},
        success: function(response) {document.location.reload();}
        });
    }
    function suggested(ctype, cname, par01){
        $.ajax({
        url: 'suggested.php',
        type: 'post',
        data: { "ctype": ctype, "cname": cname, "par": par01},
        success: function(response) {document.location.reload();}
        });
    }
    function editcrop(ctype, cname, pos){
        newname = document.getElementById("xrename"+pos).value;
        alert(newname);
        $.ajax({
        url: 'editcrop.php',
        type: 'post',
        data: { "cold": cname, "cnew": newname, "ctype": ctype},
        success: function(response) {document.location.reload();}
        });
    }
</script>