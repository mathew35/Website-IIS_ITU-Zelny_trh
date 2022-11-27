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
            echo '<p>' . $name[1] . ' <button onclick="edituser(' . $name[0] . ')">Upravit účet</button>' . 
            ' <button onclick="deleteuser(' . $name[0] . ')">Smazat účet</button>'. 
            ' <button onclick="addmoder(' . $name[0] . ')">Přidat uživateli roli moderátora</button>'.'</p>';
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
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <p><a href="index3.php"><button>Admin mode</button></a></p>
    <div>

        <h1>Spravovat uživatele</h1>
        <?php $amode->getusers();?>

    </div>

</body>
</html> 

<script>
    function edituser(id){
        alert("edit bude tu");
    }
    function deleteuser(userid){
        $.ajax({
        url: 'deleteuser.php',
        type: 'post',
        data: { "param": userid},
        success: function(response) { alert(response); }
    });
    }
    function addmoder(id){
        alert("add moderatoru tu");
    }
</script>