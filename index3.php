<?php
session_start();
require "services.php";
// header("refresh:1;");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="VrablikWebIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <nav>
        <div id='navbar'>
            <div id='logo'>
                <?php
                echo "<a role='button' href='?category=none'<div id='logoText'>Zelny trh</div></a>";
                if (isset($_SESSION['user'])) {
                    echo "<p><button>farmer mode</button></p>";
                }
                ?>
            </div>
        </div>
        <div id='navbar'>
            <div id='category'>
                <?php
                echo "<a role='button' href='?category=ovocie'><button>ovocie</button></a>";
                echo "<a role='button' href='?category=zelenina'><button>zelenina</button></a>";
                ?>
            </div>
        </div>
        <div id='navbar'>
            <div id='credents'>
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
            </div>
        </div>
    </nav>
    <div id="table">
        <table>
            <?php
            $serv = new AccountService();
            if ($_GET['category'] == 'ovocie') {
                $crops = $serv->getCrops("ovocie");
            } else if ($_GET['category'] == 'zelenina') {
                $crops = $serv->getCrops("zelenina");
            } else {
                $crops = $serv->getCrops(NULL);
            }
            if ($crops->rowCount() > 0) {
                echo "<tr>";
            }
            $arr = $crops->fetch();
            $width = 6;
            for ($i = 0; $i < $crops->rowCount(); $i++) {
                echo "<td><div id='tableItem'>";
                for ($j = 0; $j < 4; $j++) {
                    echo $arr[$j] . " ";
                }
                echo "</div></td>";
                $arr = $crops->fetch();
                if ($i % 5 == 0 && $i != 0 && $i + 1 != $crops->rowCount()) echo "</tr><tr>";
            }
            if ($crops->rowCount() % 6 != 0) {
                $i = $crops->rowCount() % 6;
                for ($j = $i; $j < 6; $j++) {
                    echo "<td><div id='tableItem' style='visibility: hidden;'>placeholder</div></td>";
                }
            }
            if ($crops->rowCount() > 0) {
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <footer>footer fooo</footer>
</body>

</html>
