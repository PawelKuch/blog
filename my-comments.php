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

    <link rel="stylesheet" href="css/menu.css"> gt
    <link rel="stylesheet" href="css/my-comments.css">

    <script src="js/app.js"></script>

</head>
<body>
<div class="navi-style">
    <header class="navigation">
        <div id="imgLogo">
            <a href="/index.php" class="logo">USER MENU TEST
                <img src="img/logotype.png" alt="logotype jpg"></a>
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
    <div id="comments-container">
        <?php
            $user_id = $_SESSION['user_id'];
            $dblink = new mysqli("localhost", "root", "", "userstry") or die("connection could not be found");
            $stmt = $dblink -> prepare("SELECT c.id, c.comment_content, c.user_id, pc.post_id, p.post_title, p.photo, p.photo_type FROM comments c JOIN post_comments pc ON c.id = pc.comment_id JOIN posts p ON p.id = pc.post_id WHERE c.user_id = ?");
            $stmt -> bind_param("i", $user_id);
            if($stmt -> execute()){
                $result = $stmt -> get_result();
                while ($row = $result -> fetch_assoc()){
                    echo '<div class="comment">
                             <div class="post-photo"><img width="300px" src="data:' . $row['photo_type'] .';base64,' . base64_encode($row['photo']) . '"></div>
                             <div class="post-title"><a href="post-view.php?id=' . $row['post_id'] .'">' . $row['post_title'] . '</a></div>
                             <div class="comment-content">YOUR COMMENT:<br> <a href="post-view.php?id=' . $row['post_id'] . '">' . $row['comment_content'] . '</a></div>
                         </div>';
                }
            }
        ?>
    </div>



</div>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>


