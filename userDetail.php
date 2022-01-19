<!DOCTYPE html>
<html lang="en">
<?php
        require_once __DIR__ . "/Views/Header/header.php" 
?>
<body>
    


<?php
    session_start();
    require_once __DIR__ . '/Views/Navbar/navbar.php';

    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
?>


</body>
</html>