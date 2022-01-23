<?php
    session_start();
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header("Location: " . dirname($_SERVER['PHP_SELF']));

?>