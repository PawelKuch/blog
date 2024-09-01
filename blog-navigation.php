<?php

if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    if ($_SESSION['user_id'] == "1") {
       // echo "<li><a href='accounts-management.php'> <div class='menu-tile'>ACCOUNTS MANAGEMENT </div></a></li> ";
    }
    echo "<li><a href='account-settings.php'> <div class='mneu-tile'> ACCOUNT SETTINGS </div></a></li>";
    echo "<li><a href='main-blog.php'> <div class=menu-tile'> BLOG </div></a></li>";
    echo "<li><a href='statistics.php'>LOGOUT</a></li>";
} else {
    echo "<a href='sign-in.php'> <li>SIGN IN</li></a>";
    echo "<a href='sign-up.php'><li>SIGN UP</li></a>";
}

?>

