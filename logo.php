<?php
echo "<a role='button' href='?category=none'<div id='logoText'>Zelny trh</div></a>";
if (isset($_SESSION['user'])) {
    echo "<p><button>farmer mode</button></p>";
}
