<pre>
<?php
    session_start();
    var_dump($_SESSION);

    echo "<br><br>";
    if (isset($_SESSION['user_id'])){
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="login.php">Login</a>';
    }
?>

</pre>
