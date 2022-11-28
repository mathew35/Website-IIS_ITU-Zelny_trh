<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <p><a href="index3.php"><button>User mode</button></a>
    <div class="admin-container">
        <div class="admin-informations-container">
            <div class="admin-informations-header">
                <h2> Upravit informace uživatele </h2>
            </div>
            <div class="admin-informations-content"> 
                <p>Login: <input type="text" id="xlogin"></p>
                <p>Fullname: <input type="text" id="xname"></p>
                <p>Email: <input type="text" id="xemail"></p>
            </div>
        </div>
    </div>

</body>
</html> 

<script>
    function updateuser(){
    xlogin = document.getElementById("xlogin").value;
    xname = document.getElementById("xname").value;
    xemail = document.getElementById("xemail").value;
    alert("tady bude měnit")
}
</script>