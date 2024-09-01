<?php
    if(isset($_SESSION['username']) && isset($_SESSION['user_id'])){
        if($_SESSION['user_id'] == "1"){
            echo "<li><a href='accounts-management.php'> <div class='menu-tile'>ACCOUNTS MANAGEMENT </div></a></li> ";
        }
        echo "<li class='nav-item dropdown'>
                    <a class='nav-link' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>     
                        MY ACCOUNT
                    </a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <li><a class='dropdown-item' href='account-settings.php'>Account settings</a></li>
                        <li><a class='dropdown-item' href='user-statistics.php'>Statistics</a></li>
                        <li><a class='dropdown-item' href='my-posts.php'>My posts</a></li>
                        <li><a class='dropdown-item' href='my-comments.php'>My comments</a></li>
                    </ul>
                </li>";
        echo "<li><a href='main-blog.php'> <div class=menu-tile'> BLOG </div></a></li>";
        echo "<li><a href='logout.php'>LOGOUT</a></li>";
    }else{
        echo "<a href='sign-in.php'> <li>SIGN IN</li></a>";
        echo "<a href='sign-up.php'><li>SIGN UP</li></a>";
    }

?>

