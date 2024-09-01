<?php
    session_start();
    $dblink = new mysqli("localhost", "root", "", "userstry");
?>
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['add-post'])){
        $user_id = $_SESSION['user_id'];
        $post_content = $_POST['post-content'];
        $post_title = $_POST['post-title'];
        date_default_timezone_set("Europe/Warsaw");
        $date = date("Y-m-d H:i:s");
        $photo = $_FILES['input-file'];
        $photo_type = $photo['type'];
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
        if(!in_array($photo_type, $allowed_types))
            die("The photo type is not allowed to upload");
        $photo_path = $photo['tmp_name'];
        $photo_file = file_get_contents($photo_path);
        $stmt = $dblink -> prepare("INSERT INTO posts (user_id, post_content, post_title, date, photo, photo_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("ssssss", $user_id, $post_content, $post_title, $date, $photo_file, $photo_type);

        if ($stmt -> execute()){
            echo "your post has been added and everyone can see it";
            if(!$dblink -> query("INSERT INTO post_comments (post_id) SELECT id FROM posts"))
                die("Row has not been inserted into post_comments table");
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

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

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main-blog.css">
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

    <div id="container" >
        <div id="open-add-post-modal-div">
            <button id="open-add-post-modal-button" type="button" class="btn btn-dark mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#add-post-modal">ADD POST</button>
        </div>
        <div id="posts">
            <?php
                $query = "SELECT p.id, p.post_title, SUBSTRING(p.post_content, 1, 600) AS short_content , p.photo, p.photo_type, u.username, DATE(p.date) AS only_date FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.date DESC";
                $result = $dblink -> query($query);
                if($result -> num_rows > 0){
                    while ($row = $result -> fetch_assoc()){
                        echo '
                                <div class="post-tile">                                                          
                                        <div class="photo-file">
                                            <img src="data:' . $row["photo_type"] . ';base64,' . base64_encode($row["photo"]) . '" alt="Post Image">
                                        </div>
                                        <div id="container1">
                                            <div class="fw-bold justify-content-center">
                                                <div class="post-title text-uppercase">
                                                    <a href="post-view.php?id=' . $row["id"] . '">'
                                                    .  $row["post_title"] . '
                                                    </a>
                                                </div>                                       
                                            </div>                                      
                                            <div id="short-content" class="text-wrap">'
                                                . $row['short_content'] . '...<a href="post-view.php?id=' . $row["id"] . '"> <b>See more</b> </a>
                                            </div>    
                                            <div class="post-footer">                                          
                                                by ' . $row["username"] . ' on ' . $row["only_date"] . '                                       
                                            </div>   
                                        </div>                                                          
                                </div>';

                    }
                }
            ?>
        </div>
    </div>
    <div class="modal" id="add-post-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adding post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="main-blog.php" method="post" enctype="multipart/form-data">
                        <div class="input-group">
                            <span class="input-group-text mb-3">POST TITLE</span>
                            <input class="form-control mb-3" id="post-title" name="post-title">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="post-content" name="post-content" rows="18"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="input-file" id="input-file">
                            <label class="input-group-text" for="input-file">UPLOAD</label>
                        </div>
                        <button name="add-post" type="submit">ADD POST </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>


