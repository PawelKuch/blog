<?php
    session_start();
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

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/my-posts.css">
    <script src="js/app.js"></script>

</head>
<body>
<div class="navi-style">
    <header class="navigation">
        <div id="imgLogo">
            <a href="/index.php" class="logo">USER MENU TEST
                <img src=" img/logotype.png" alt="logotype png"></a>
        </div>
        <nav>
            <ul class="nav-link">
                <?php include "user-welcome.php"; ?>
                <?php include "menu-navigation.php"; ?>
            </ul>
        </nav>
    </header>
</div>
<div id="container" class="container">
    <div id="posts">
        <?php
            $user_id = $_SESSION['user_id'];
            $dblink = new mysqli("localhost", "root", "", "userstry") or die("connection could not be found");
            $stmt = $dblink ->prepare("SELECT id, post_title, photo, photo_type, DATE(date) AS date_only FROM posts WHERE user_id = ? ORDER BY date DESC");
            $stmt -> bind_param("i",$user_id);
            if($stmt -> execute()){
                if($result = $stmt -> get_result()){
                    while($row = $result -> fetch_assoc()){
                        echo '
                              <div class="my-post">
                                <div class="photo">
                                    <img width="300px" src="data:' . $row["photo_type"] . ';base64,' . base64_encode($row["photo"]) . '" alt="Post Image">
                                </div>
                                <div class="post-title">
                                    <a href="post-view.php?id=' . $row['id'] . '">
                                        ' . $row['post_title'] . '
                                    </a>
                                </div>
                                <div class="post-info">
                                   ' . $row['date_only'] . '
                                </div>                                            
                              </div>';
                    }
                }
            }
        ?>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>

