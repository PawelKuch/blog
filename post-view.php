<?php
    session_start();
    $current_user_id = $_SESSION['user_id'];
    $dblink = new mysqli("localhost", "root", "", "userstry") or die("Could not find the connection");

    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];
        $stmt = $dblink->prepare("SELECT post_title, post_content, user_id, photo, photo_type FROM posts WHERE id=?");
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()){
            $stmt -> store_result();
            $stmt->bind_result($post_title, $post_content, $user_id, $post_photo, $photo_type);
            $stmt->fetch();
        }
    }



?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $dblink = new mysqli("localhost", "root", "", "userstry") or die("Could not find the connection");
    if(isset($_POST['delete_post'])){
        $post_id = $_POST['post_id_input'];
        $stmt = $dblink -> prepare("DELETE FROM posts WHERE id = ?");
        $stmt -> bind_param("i", $post_id);
        if($stmt -> execute()){
            header("Location: main-blog.php");
            exit();
        }
    }elseif(isset($_POST['add_comment'])){
        $post_id = $_GET['id'];
        date_default_timezone_set("Europe/Warsaw");
        $date = date("Y-m-d H:i:s");
        $comment_content = $_POST['comment_content'];
        $user_id = $_SESSION['user_id'];
        echo "comment is : " . $comment_content;
        if ($comment_content != null && $comment_content != "") {
            $stmt2 = $dblink -> prepare("INSERT INTO comments (comment_content, date, user_id) VALUES (?, ? ,?)");
            $stmt2 -> bind_param("ssi", $comment_content ,$date, $user_id);
            if($stmt2 -> execute()){
                $comment_id = $stmt2 -> insert_id;
                $stmt = $dblink -> prepare("INSERT INTO post_comments (post_id, comment_id) VALUES (?, ?) ");
                $stmt -> bind_param("ii", $post_id, $comment_id );
                $stmt ->execute();
                exit();
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
    <title>User Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/post-view.css">
    <script src="js/app.js"></script>

</head>
    <body>
    <div id="navi-style" class="navi-style">
        <header class="navigation">
            <div id="imgLogo">
                <a href="/index.php" class="logo"><b>USER MENU TEST</b>
                    <img width="40px" height="40px" src="img/logotype.png" alt="oak jpg">
                </a>
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
        <div id="post-container">
            <div id="post-header">
                <div id="post-title">
                        <?php
                            if($post_title){
                                echo "$post_title";
                            }else {
                                echo "title is not available and post_id is $post_id";
                            }

                        ?>
                </div>
                <div id="dropdown-post-menu">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php

                        $owner_post_flag = false;
                        $stmt = $dblink -> prepare("SELECT user_id FROM posts WHERE id = ?");
                        $stmt -> bind_param("i", $_GET['id']);
                        $stmt -> bind_result($user_id);
                        $stmt -> execute();
                        $stmt -> fetch();
                        if($current_user_id == $user_id || $current_user_id == 1) {
                            echo '<i class="fa-solid fa-ellipsis-vertical"></i>';
                        }
                        ?>

                    </a>
                    <ul class="dropdown-menu">
                        <li>
                              <?php echo '<a class="dropdown-item" href="edit-post.php?id=' . $_GET['id'] . '"><button class="btn btn-outline-secondary"> EDIT POST </button> </a>';?>
                        </li>
                        <li>
                            <?php echo
                            '<form method="post" action="post-view.php">
                                <input name="post_id_input" type="hidden" value="' . $_GET['id'] . '">
                                <button name="delete_post" type="submit" class="btn btn-outline-secondary ms-3">DELETE POST</button>
                            </form>';
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
                <div id="post-photo">
                    <img width="400px" height="400px" src="data:<?php echo $photo_type; ?>;base64,<?php echo base64_encode($post_photo); ?>" alt="imgphoto">
                </div>
            <div id="post-content">
                <?php
                    echo $post_content;
                ?>
            </div>
            <div id="post-info">
                <?php
                    $dblink = new mysqli("localhost", "root", "", "userstry") or die("Connection could not be find!");
                    $stmt = $dblink->prepare("SELECT u.username, p.date FROM users u JOIN posts p ON u.id = p.user_id WHERE p.id=?");
                    $stmt -> bind_param("i", $_GET['id']);
                    if($stmt -> execute()){
                        $stmt -> bind_result($username, $post_date);
                        $stmt ->fetch();

                        echo 'Posted on ' . $post_date . ' by ' . $username;
                        $dblink->close();
                    }

                ?>

            </div>

            <div id="comments-container">

                <?php echo '<form method="post" action="post-view.php?id=' . $_GET['id'] . '">
                        <input name="comment_content">
                        <button id="add_comment" name="add_comment" type="submit" class="btn btn-dark">ADD COMMENT</button>      
                    </form>'; ?>


                <div id="comment">
                <?php
                    $dblink = new mysqli("localhost", "root", "", "userstry") or die("Connection could not be find!");
                    $stmt = $dblink->prepare("SELECT c.id, c.comment_content, c.date, u.username FROM comments c JOIN users u ON c.user_id = u.id JOIN post_comments pc ON c.id = pc.comment_id WHERE pc.post_id = ? ORDER BY date DESC");
                    $stmt -> bind_param("i", $post_id);
                    if( $stmt -> execute()){
                        $result = $stmt -> get_result();
                        while($row = $result->fetch_assoc()){
                            echo '<div id="comment">'
                                    . $row["comment_content"] .
                                  ' <div id="comment-info">
                                        commented on ' . $row["date"] . ' by '. $row["username"] . '
                                    </div>
                                  </div>';
                        }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    </body>
</html>
