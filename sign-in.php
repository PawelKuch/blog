<?php

session_start();
$dblink = new mysqli("localhost", "root", "") or die("could not find the connection!");
$dblink -> select_db("userstry");
$correct_data = true;
$is_blocked = false;
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sign-in-button'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $dblink ->prepare("SELECT id, username, password, blocked FROM users WHERE username = ?");
    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $stmt -> store_result();

    if($stmt -> num_rows > 0){
        $stmt -> bind_result($db_id, $db_username, $db_password, $blocked);
        $stmt -> fetch();
        if(password_verify($password, $db_password)){
            if($blocked == 0){
                $_SESSION['user_id'] = $db_id;
                $_SESSION['username'] = $username;

                echo "Signed in! Hello $username.";
                header("Location: main-blog.php");
            }else {
                $is_blocked = true;
            }
        }else { $correct_data = false;}
    } else { $correct_data = false;}
}
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Blog</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

            <link rel="stylesheet" href="css/sign-in.css">
            <link rel="stylesheet" href="css/menu.css">
            <script src="js/app.js"></script>
        </head>
        <body>
            <div id="navi-style" class="navi-style">
                <header class="navigation">
                    <div id="imgLogo">
                        <a href="/index.php" class="logo">USER MENU TEST
                            <img width="40px" height="40px" src="img/logotype.png" alt="logotype png"></a>
                    </div>
                    <nav>
                        <ul class="nav-link">
                            <?php include "user-welcome.php"; ?>
                            <?php include "menu-navigation.php"; ?>
                        </ul>
                    </nav>
                </header>
            </div>
            <div class="container">
                <div id="sign-in-container">
                    <div id="sign-in-header">
                        SIGN IN
                    </div>
                    <form id="sign-in-form" action="sign-in.php" method="POST">
                        <div class="input-group">
                            <div style="display: flex; flex-direction: row; justify-content: center;">
                                <span class="input-span input-group-text mb-3"> USERNAME </span>
                                <input class="form-control mb-3" id="username" name="username">
                            </div>
                            <div style="display: flex; flex-direction: row; justify-content: center;">
                                <span class="input-span input-group-text mb-3"> PASSWORD </span>
                                <input class="form-control mb-3" type="password" id="password" name="password">
                            </div>
                        </div>
                        <div id="sign-in-button-div">
                            <button id="sign-in-button" class="btn btn-dark" type="submit" name="sign-in-button">SIGN IN</button>
                        </div>
                    </form>
                </div>
                <?php
                    if (!$correct_data) {
                        echo'<div id="login-alert" class="alert alert-danger" role="alert">INCORRECT LOGIN OR PASSWORD!';
                    }
                    if ($is_blocked) {
                        echo'<div id="login-alert" class="alert alert-danger" role="alert">YOUR ACCOUNT HAS BEEN BLOCKED! IF YOU THINK IT IS A MISTAKE, PLEASE CONTACT THE ADMINISTRATOR!';
                    }
                ?>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>




        </body>
    </html>
