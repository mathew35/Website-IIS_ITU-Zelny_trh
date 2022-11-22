
<?php
if (isset($_SESSION['user'])) {
    echo "user found";
} else {
    echo "<table id='loginTable'>
    <tr><td>Login</td><td>Password</td></tr>    
    <tr><td><input type='text'></input></td><td><input type='password'></input></td></tr>
    <tr><td><button>Login</button></td><td><button>Register</button></td></tr>
    </table>";
    // echo "<p><button>Login</button></p>";
    // echo "<p><button>Register</button></p>";
}
?>
