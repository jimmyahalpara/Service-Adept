<?php
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // login required
    loginAccessRequired(3);
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php
        require_once __DIR__ . "/Views/Header/header.php" 
?>
<body>
    


<?php
    define("CURRENT_PAGE", "Organization");
    require_once __DIR__ . '/Views/Navbar/navbar.php';

    $user = new UserModel($pdo);
    $user -> id = $_SESSION['user_id'];
    $user -> readOne();


    if ($user -> access_level == 4){
        // get organization id
        $admin = new OrganizationAdminModel($pdo);
        $admin -> user_id = $user -> id;
        $admin -> readOne();
        $organization_id = $admin -> organization_id;
    }

    $provider = new ProviderModel($pdo);
    $provider -> organization_id = $organization_id;
    $providers = $provider -> readAllByOrganizationId();
    // var_dump($providers);
    require_once __DIR__ . '/Views/ManageProvider/managerProviderView.php';
?>


</body>
</html>