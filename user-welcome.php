<?php
    if(isset($_SESSION['username']))
        echo "<li> Logged as " . $_SESSION['username'] . "</li>";
