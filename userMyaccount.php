<?php
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
    // login required
    loginRequired();
?>
<!DOCTYPE html>
<html lang="en">
<?php
        require_once __DIR__ . "/Views/Header/header.php" 
?>
<body>
    


<?php
    define("CURRENT_PAGE", "User");
    require_once __DIR__ . '/Views/Navbar/navbar.php';

    $user = new UserModel($pdo);
    $user -> id = $_SESSION['user_id'];
    $user -> readOne();

    require_once __DIR__ . '/Views/MyAccount/myAccountView.php';
?>


</body>
</html>