<?php
    session_start();
    $dblink = new mysqli("localhost", "root", "", "userstry") or die("connection could not be found");
    $stmt = $dblink -> prepare("SELECT (SELECT COUNT(*) FROM posts WHERE user_id =?) AS posts_quantity, (SELECT COUNT(*) FROM comments WHERE user_id = ?) AS comments_quantity");
    $user_id = $_SESSION['user_id'];
    $stmt -> bind_param("ii", $user_id, $user_id);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();
        $posts_quantity = $row['posts_quantity'];
        $comments_quantity = $row['comments_quantity'];
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" class="text-center">STATISTICS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>POSTS QUANTITY</td>
                <td><?php echo $posts_quantity; ?></td>
            </tr>
            <tr>
                <td>COMMENTS QUANTITY</td>
                <td><?php echo $comments_quantity ?></td>
            </tr>
        </tbody>
    </table>
</div>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>

