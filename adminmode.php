<?php


require "services.php";
class AdminMode
{
    private $db;

    public function __construct()
    {
        $this->db = new AccountService();
    }
    
    public function getusers(){
        $getname = $this->db->get("ACCOUNTS", "*", "");
        $name = $getname->fetch();
        


        for ($i = 0; $i < $getname->rowCount(); $i++) {

            echo '<p>' . $name[1] . '<a href="edituser.php"><button>Admin mode</button></a>' . 
            ' <button onclick="deleteuser(' . $name[0] . ')">Smazat účet</button>';
            if($name[5]==0){
                echo ' <button onclick="addmoder(' . $name[0] .','. $name[5] . ')">Přidat uživateli roli moderátora</button>'.'</p>';
            } 
            else if($name[5]==2){
                echo ' <button onclick="addmoder(' . $name[0] .','. $name[5] . ')">Odebrat uživateli roli moderátora</button>'.'</p>';
            }
            $name = $getname->fetch();
        }
    }

}

$amode = new AdminMode(); 

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <p><a href="index3.php"><button>User mode</button></a>
    <a href="moderator.php"><button>Moderator mode</button></a></p>
    <div class="admin-container">
        <div class="admin-informations-container">
            <div class="admin-informations-header">
                <h2> Spravovat uživatele </h2>
            </div>
        
            <div class="admin-informations-content"> 
                <?php $amode->getusers();?>
            </div>
        </div>
    </div>

</body>
</html> 

<script>
    function deleteuser(userid){
        $.ajax({
        url: 'deleteuser.php',
        type: 'post',
        data: { "param": userid},
        success: function(response) { }
    });
    }
    function addmoder(userid, adddel){
        $.ajax({
        url: 'adddelmod.php',
        type: 'post',
        data: { "param": userid, "param2": adddel},
        success: function(response) { }
        });
        setTimeout(() => {
        document.location.reload();
        }, 700);
    }
</script>