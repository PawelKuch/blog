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

  <link rel="stylesheet" href="css/index.css">
  <script src="js/app.js"></script>

</head>
<body>
<?php
    echo 'hej w apostrofie';
    echo '<br>';
    echo "hej w cudzyslowiu";
    echo '<br>';
    $zmienna = 3;

    echo $zmienna;
    echo '<br>';
    echo '$zmienna';
    echo "<br>";
    echo "$zmienna";
    echo '<br>';
    $zmienna1 = 5;
    echo $zmienna1;
    echo '<br>';
    $zmienna1 .="k";
    echo $zmienna1;

    echo '<br>';
    $a = 3;
    $b = 3;

    if ($a > $b)
        echo '$a większe od $b';
    else if ($a < $b)
        echo '$a mniejsze od $b';
    elseif ($a == $b) {
        echo "cos"; //brana jest pod uwagę cala zawartość w klamrze lub tylko 1 linijka, gdy nie ma klamry
        echo "<br>";
        echo "cos2";
        echo " <br> cos3";
    }

    $tablica["imie"] = "Pawel";
    $tablica["nazwisko"] = "Kucharski";
    $tablica["imie"] = "Jan";
    $tablica["nazwisko"] = "Nowak";

    foreach ($tablica as $wartosc){
        echo "$wartosc <br>";
    }

     $cars = array
    (
         array("Volvo",22,18),
         array("BMW",15,13),
         array("Saab",5,2),
         array("Land Rover",17,15)
     );

     for ($row = 0; $row < 4; $row++) {
         echo "<p><b>Row number $row</b></p>";
         echo "<ul>";
         for ($col = 0; $col < 3; $col++) {
         echo "<li>".$cars[$row][$col]."</li>";
     }
        echo "</ul>";
     }

     $meals = array("Kamil" => "Burger",
     "Pawel" => "Pizza",
     "Kamila" => "Yoghurt");

     foreach ($meals as $meal){
         echo "<br> $meal";
     }

     for ($i = 0; $i > count($meals); $i++){
         echo $meals[0][0];
     }

    foreach ($meals as $name => $meal )
        echo "<br> $name likes $meal";

    $dblink = new mysqli("localhost", "root", "") or die("could not connect!");
    echo "<br> connected successful";
    $dblink->select_db("userstry") or die("could not find the database");
    echo "<br> Database selected!";



/*$query1 = "DROP TABLE post_comments";

if($dblink -> query($query1)){
    echo "Primary key has been added!";
}*/

/*    $query = "CREATE TABLE comments (
        id int(11) PRIMARY KEY AUTO_INCREMENT,
        comment_content TEXT,
        date DATE,
        user_id int(11)
    )";
    if($dblink -> query($query))
        echo 'comments table has been created!';*/

    /*$query = "CREATE TABLE post_comments (
        id int AUTO_INCREMENT PRIMARY KEY,
        post_id int(11),
        comment_id int(11)
    )";
    if($dblink->query($query))
        echo 'post comments table has been created';*/

  /*  $query = "ALTER TABLE posts DROP COLUMN comment_id";
    if($dblink-> query($query)){
        echo 'comment_id has been deleted';
    }*/
    /*$query = "ALTER TABLE posts ADD user_id int(11)";
    if($dblink -> query($query)){
        echo "user_id column has been added to the posts table!";
    }*/

    /*$query = "CREATE TABLE users (
        id int AUTO_INCREMENT PRIMARY KEY,
        username char(25)
    )";
    $ifAdded = $dblink->query($query);
    if ($ifAdded)
        echo "<br> table has been added!";*/
?>


<?php
    /*$dblink_posts = new mysqli("localhost", "root", "", "userstry");
    $query = "ALTER TABLE posts ADD post_title CHAR(30)";
    if($dblink_posts -> query($query)){
        echo "post-content column has been added!";
    }*/

  /*  $ifInserted = $dblink->query("INSERT INTO users (username) VALUES ('Saskus')");
    if ($ifInserted)
        echo "<br> row inserted!";*/
   /* $query = "ALTER TABLE users ADD password CHAR(30)";
    if($dblink -> query($query))
        echo "Dodano kolumnę password";*/

/*    $query = "ALTER TABLE users ADD phone_number INTEGER(9)";
   if($dblink -> query($query)
       echo "Dodano kolumnę phone_number";*/

 /*   $query = "ALTER TABLE users ADD blocked BOOLEAN";
    if($dblink -> query($query)){
        echo "dodano kolumnę blocked!";
    }*/

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $stmt = $dblink->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->bind_param("s", $username);
        if ($stmt->execute())
            echo "<br> row inserted!";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
    $dblink->close();
?>

<p> <a href="menu.php">MENU APLIKACJI</a></p>
<form action="index.php" method="post">
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>

<a href="users.php">Users</a>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

