<?php
    session_start();
    $dblink = new mysqli("localhost", "root", "", "userstry") or die("Could not find the connection");
?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['delete_user_button'])){
        $user_id = $_POST['user_id_input'];
        $stmt = $dblink -> prepare("DELETE FROM users WHERE id = ?");
        $stmt -> bind_param("s", $user_id );
        if($stmt -> execute()){
            echo "User with the id of $user_id has been deleted";

        }
    }elseif (isset($_POST['block_user'])){
        $user_id = $_POST['user_id_input'];
        $stmt = $dblink -> prepare("UPDATE users SET blocked = true WHERE id = ?");
        $stmt -> bind_param("i", $user_id);
        if($stmt -> execute()){
            header("Location: " . $_SERVER['PHP_SELF']);
            echo "The user of id $user_id has been blocked and is not able to sign in until you change it!";
            exit();
        }
    }
}

?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['unblock_user'])){
        $user_id = $_POST['user_id_input'];
        $stmt = $dblink -> prepare("UPDATE users SET blocked = false WHERE id = ?");
        $stmt -> bind_param("i", $user_id);
        if ($stmt -> execute()){
            echo "The user of id $user_id has been unblocked and is able to sign in!";
            header("Location: accounts-management.php");
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

    <link rel="stylesheet" href="css/accounts-management.css">
    <link rel="stylesheet" href="css/menu.css">

    <style>
        th, td {
            text-align: center;
        }
    </style>

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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="5">USERS MANAGEMENT</th>
                </tr>
                <tr>
                    <th>USER ID</th>
                    <th>USER</th>
                    <th>PHONE NO</th>
                    <th>BLOCKED</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = "SELECT id, username, phone_number, blocked FROM users";
                    if($result = $dblink ->query($query)){
                        if($result -> num_rows > 0){
                            while ($row = $result -> fetch_row()){
                                if ($row[0] != 1){
                                    $blocked = "NO";
                                    $row[3] == 1 ? $blocked = "YES" : $blocked = "NO";
                                    echo "<tr><td class='table-cell'>" . $row[0] . "</td> <td class='table-cell'> " . $row[1] ."</td><td class='table-cell'>" . $row[2] ."</td><td class='table-cell'>" . $blocked . "</td><td> 
                                    <form method='post' action='accounts-management.php'> 
                                        <input name='user_id_input' type='hidden' value= '$row[0]'>
                                        <button class='management-btn btn btn-outline-secondary' type='submit' name='delete_user_button'>DELETE USER</button>
                                    </form>
                                    <form method='post' action='accounts-management.php'> 
                                        <input name='user_id_input' type='hidden' value= '$row[0]'>
                                        <button class='management-btn btn btn-outline-secondary' type='submit' name='block_user'>BLOCK USER</button>
                                    </form>
                                    <form method='post' action='accounts-management.php'>
                                        <input name='user_id_input' type='hidden' value='$row[0]'>
                                        <button class='management-btn btn btn-outline-secondary' type='submit' name='unblock_user'>UNBLOCK</button>
                                    </form>
                                    </td></tr>";

                                }
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
        <a href="main-blog.php"><button class="btn btn-secondary">BACK</button></a>
    </div>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>
