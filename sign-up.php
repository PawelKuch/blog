<?php

$dblink = new mysqli("localhost", "root", "") or die("could not find the connection");
$dblink -> select_db("userstry");
$isLogged = false;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sign-up-button'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $stmt = $dblink -> prepare("INSERT INTO users (username, password, phone_number) VALUES (?, ?, ?)");
    $stmt -> bind_param("sss", $username, $password, $phone_number);
    if($stmt ->execute()){
        $isLogged = true;
    }else {
        echo "something went wrong";
    }
}

?>
<!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/sign-up.css">
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
            <div id="sign-up-container">
                <div id="sign-up-header">
                    SIGN UP
                </div>
                <form action="sign-up.php" method="POST">
                    <div class="input-group">
                        <div style="display: flex; flex-direction: row; justify-content: center;">
                            <span class="input-span input-group-text mb-3"> USERNAME </span>
                            <input class="form-control mb-3" id="username" name="username">
                        </div>
                        <div style="display: flex; flex-direction: row; justify-content: center;">
                            <span class="input-span input-group-text mb-3"> PASSWORD </span>
                            <input class="form-control mb-3" type="password" id="password" name="password">
                        </div>
                        <div style="display: flex; flex-direction: row; justify-content: center;">
                            <span class="input-span input-group-text mb-3"> PHONE NUMBER </span>
                            <input class="form-control mb-3" type="number" id="phone_number" name="phone_number">
                        </div>
                    </div>
                        <button class="btn btn-dark" type="submit" name="sign-up-button">SIGN UP</button>
                </form>
            </div>
            <?php
                if($isLogged){
                    echo '<div id="success-alert" class="alert alert-success" role="alert">
                            You have just signed up! You can <a href="sign-in.php"><b> &nbsp;sign in&nbsp;</b></a>now! 
                          </div>';
                }
            ?>


        </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    </body>
    </html>