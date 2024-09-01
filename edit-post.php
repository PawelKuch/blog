<?php
    session_start();
    $dblink = new mysqli("localhost", "root", "", "userstry");

    $post_id = $_GET['id'];
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['edit-post'])){
            $stmt = $dblink -> prepare("UPDATE posts SET post_title = ?, post_content =? WHERE id = ?");
            $post_title = $_POST['post_title'];
            $post_content = $_POST['post_content'];
            $stmt -> bind_param("ssi", $post_title, $post_content, $post_id);
            if($stmt -> execute()){
                header("Location: edit-post.php?id=" . $post_id);
                echo "Post has been updated and you can see changes!";
                exit();
            }

        }
    }

    $stmt = $dblink->prepare("SELECT post_title, post_content, user_id FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->bind_result($post_title, $post_content, $user_id);
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->fetch();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER BLOG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/edit-post.css">

</head>
<body>
<div class="navi-style">
    <header class="navigation">
        <div id="imgLogo">
            <a href="/index.php" class="logo">USER MENU TEST
                <img src="/img/oak.jpg" alt="oak jpg"></a>
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

    <div id="edit-container">
        <?php
            $current_user_id = $_SESSION['user_id'];
            if($current_user_id == $user_id || $current_user_id == 1){
                echo
                    '<div id="edit-post">
                    <form action="edit-post.php?id=' . $post_id . '" method="POST">
                         <div class="input-group>">
                            <div class="subinput-group">
                                <span class="title-content-input-span input-group-text form-control mb-3">TITLE</span>
                                <input name="post_title" class="form-control mb-3" value="' . $post_title . '">
                            </div>
                        </div>
                         <div class="input-group">
                             <div class="subinput-content-group">
                                <span class="input-group-text form-control justify-content-center">CONTENT</span>
                                <textarea name="post_content" rows="20">' . $post_content . '</textarea>
                             </div> 
                         </div>
                         <div id="save-changes-button-div">
                            <button class="btn btn-secondary" name="edit-post" type="submit">SAVE CHANGES</button>
                         </div>
                    </form>
                </div>';
            }
    ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



</body>

</html>

