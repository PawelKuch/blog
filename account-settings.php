<?php
    session_start();
    $dblink = new mysqli("localhost", "root", "") or die("could not find the connection");
    $dblink -> select_db("userstry");
    $login_changed_flag = false;
    $password_changed_flag = false;
    $phone_number_changed_flag = false;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['change-username-button'])){
            $username = $_POST['username'];
            $stmt = $dblink -> prepare("SELECT password FROM users WHERE id = ?");
            $stmt -> bind_param("i", $_SESSION['user_id']);
            $stmt -> bind_result($hashed_password);
            if ($stmt -> execute()){
                $stmt -> store_result();
                $stmt -> fetch();
            }
            $password = $_POST['password'];
            if(password_verify($password, $hashed_password)){
                $stmt = $dblink ->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt ->bind_param("si", $username, $_SESSION['user_id']);
                if($stmt -> execute()){
                    $_SESSION['username'] = $username;
                    $login_changed_flag = true;
                }else
                    echo "Could not update your username";
                }
        }elseif(isset($_POST['change_password_button'])){
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $current_password = $_POST['current_password'];
            $password === $confirm_password || die("Passwords are different");
            $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $_SESSION['user_id'];
            $stmt = $dblink -> prepare("SELECT id, username, password FROM users WHERE id = ?");
            $stmt ->bind_param("i", $_SESSION['user_id']);
            if($stmt -> execute()){
                $stmt -> bind_result($db_id, $db_username, $hashed_password);
                $stmt -> store_result();
                $stmt -> fetch();
                if(password_verify($current_password, $hashed_password)){

                    $stmt2 =$dblink -> prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt2 -> bind_param("si", $new_hashed_password,$user_id );
                    if($stmt2->execute()) {
                        $password_changed_flag = true;
                    }
                }else {
                    echo "current password and hashed password from DB are the same";
                }
            }
        }elseif(isset($_POST['change_number_button'])){
            $phone = $_POST['phone_number'];
            $user_id = $_SESSION['user_id'];
            $password = $_POST['current_password_number'];

            $stmt = $dblink -> prepare("SELECT password FROM users WHERE id = ?");
            $stmt -> bind_param("i", $user_id);
            $stmt -> bind_result($hashed_password);
            if($stmt -> execute()){
                $stmt -> store_result();
                $stmt -> fetch();
                if(password_verify($password, $hashed_password)){
                    $stmt2 = $dblink -> prepare("UPDATE users SET phone_number = ? WHERE id = $user_id");
                    $stmt2 -> bind_param("i", $phone);
                    if($stmt2 ->execute())
                        $phone_number_changed_flag = true;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kino pod dębem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="css/account-settings.css">
    <link rel="stylesheet" href="css/menu.css">
    <script src="js/account-settings.js"></script>

</head>
<body>
    <div class="navi-style">
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
    <div  id="container" class="container mt-3">
        <div class="menu-tiles">
            <div id="open-add-post-modal-div">
                <button type="button" class="change-btn btn btn-outline-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#change-username-modal">CHANGE USERNAME</button>
            </div>

            <div id="open-add-post-modal-div">
                <button type="button" class="change-btn btn btn-outline-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#change-password-modal">CHANGE PASSWORD</button>
            </div>

            <div id="open-add-post-modal-div">
                <button type="button" class="change-btn btn btn-outline-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#change-phone-modal">CHANGE PHONE NUMBER</button>
            </div>

            <div id="open-add-post-modal-div">
                <button type="button" class="change-btn btn btn-outline-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#user-info-modal">USER DETAILS</button>
            </div>

            <div class="modal" id="change-username-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">CHANGE USERNAME</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="account-settings.php" method="post">
                                <div class="input-group">
                                    <div class="subinput-group"> <span class="input-group-text form-control mb-3">USERNAME</span><input class="form-control mb-3" id="username" name="username"></div>
                                    <div class="subinput-group"> <span class="input-group-text form-control mb-3">PASSWORD</span><input class="form-control mb-3" id="password" name="password" type="password"></div>
                                </div>
                                <div class="confirm-btn-div">
                                    <button class="btn btn-secondary" name="change-username-button" type="submit">CHANGE USERNAME</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="change-password-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">CHANGE PASSWORD</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="account-settings.php" method="post">
                                <div class="input-group">
                                    <div class="subinput-group mb-3">
                                        <span class="input-group-text form-control mb-3 change-password-span">NEW PASSWORD</span><input class="form-control mb-3" id="password" name="password" type="password">
                                    </div>
                                    <div class="subinput-group mb-3">
                                        <span class="input-group-text form-control mb-3 change-password-span">CONFIRM NEW PASSWORD</span><input class="form-control mb-3" id="confirm_password" name="confirm_password" type="password">
                                    </div>
                                    <div class="subinput-group mb-3">
                                        <span class="input-group-text form-control mb-3 change-password-span">CURRENT PASSWORD</span><input class="form-control mb-3" id="current_password" name="current_password" type="password">
                                    </div>
                                </div>
                                <div id="change-password-btn-div"><button class="btn btn-secondary" name="change_password_button" type="submit">CHANGE PASSWORD</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="change-phone-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">CHANGE PHONE NUMBER</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="account-settings.php" method="post">
                                <div class="input-group">
                                    <div class="subinput-group">
                                        <span class="input-group-text mb-3">PHONE NUMBER</span><input class="form-control mb-3" id="phone_number" name="phone_number">
                                    </div>
                                    <div class="subinput-group">
                                        <span class="input-group-text mb-3">PASSWORD</span><input class="form-control mb-3" id="current_password_number" name="current_password_number" type="password">
                                    </div>
                                </div>
                                <div class="confirm-btn-div">
                                    <button class="btn btn-secondary" name="change_number_button" type="submit">CHANGE PHONE NUMBER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal" id="user-info-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">YOUR ACCOUNT DETAILS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table bordered-table">
                                <thead>
                                </thead>
                                <tbody>
                                <?php
                                $dblink = new mysqli("localhost", "root", "", "userstry") or die("could not find the connection!");
                                if(isset($_SESSION['user_id'])){
                                    $user_id = $_SESSION['user_id'];
                                    $stmt = $dblink -> prepare("SELECT phone_number FROM users WHERE id = $user_id");
                                    $stmt -> bind_result($phone_number);
                                    if($stmt -> execute()){
                                        $stmt -> store_result();
                                        $stmt -> fetch();
                                        $username = $_SESSION['username'];
                                        echo "<tr>
                                            <td> USERNAME</td>
                                            <td> $username</td>
                                          </tr> ";
                                        echo "<tr>
                                            <td> PHONE NUMBER</td>
                                            <td> $phone_number</td>
                                          </tr> ";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <a href="main-blog.php"><button id="back-btn" class="btn btn-light ">BACK</button></a>
        </div>
        <?php
            if(isset($_POST['change-username-button']))   {
                if($login_changed_flag) echo'<div class="account-settings-alert alert alert-success" role="alert">YOUR LOGIN HAS BEEN CHANGED. NOW IT IS <b>' . $username . '</b></div>';
                if(!$login_changed_flag) echo'<div class="account-settings-alert alert alert-danger" role="alert">PASSWORD IS INCORRECT! YOU CANNOT CHANGE YOUR LOGIN!</div>';
            }elseif (isset($_POST['change_password_button'])){
                if($password_changed_flag) echo'<div class="account-settings-alert alert alert-success" role="alert">YOUR PASSWORD HAS BEEN CHANGED!</div>';
                if(!$password_changed_flag) echo'<div class="account-settings-alert alert alert-danger" role="alert">PASSWORD IS INCORRECT! YOU CANNOT CHANGE YOUR LOGIN!</div>';
            }elseif(isset($_POST['change_number_button'])){
                if($phone_number_changed_flag) echo'<div class="account-settings-alert alert alert-success" role="alert">YOUR PHONE NUMBER HAS BEEN CHANGED!</b></div>';
                if(!$phone_number_changed_flag) echo'<div class="account-settings-alert alert alert-danger" role="alert">PASSWORD IS INCORRECT! YOU CANNOT CHANGE YOUR PHONE NUMBER!</div>';
            }

        ?>
    </div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>




</body>
</html>

