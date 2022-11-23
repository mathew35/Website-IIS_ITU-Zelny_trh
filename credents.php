
<?php
function login()
{
    echo "loged in";
}
if (isset($_SESSION['user'])) {
    echo "user found";
} else {
    // echo "<table id='loginTable'>
    // <tr><td>Login</td><td>Password</td></tr>    
    // <tr><td><input type='text'></input></td><td><input type='password'></input></td></tr>
    // <tr><td><button>Login</button></td><td><button>Register</button></td></tr>
    // </table>";
    echo "<form action=" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&action=login method='post'><button type='submit'>Login</button></form>";
    echo "<form action=" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&action=register method='post'><button type='submit'>Register</button></form>";
}
if (isset($_GET['action'])) {
    echo "<div id='popupBackground' class='popup'></div>";
    echo "<div id='popupWin' class='popup'";
    if ($_GET['action'] == "login") {
        echo "login";
    } else if ($_GET['action'] == "register") {
        echo "register";
    } else {
        unset($_GET['action']);
    }
    echo "</div>";
    echo "<script src='fnc.js'></script>";
}
?>
