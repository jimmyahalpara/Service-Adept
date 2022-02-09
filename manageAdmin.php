<?php
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
    // login required
    loginAccessRequired(4);
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

    


    if ($_SESSION['access_level'] == 4){
        // get organization id
        $admin = new OrganizationAdminModel($pdo);
        $admin -> user_id = $_SESSION['user_id'];
        $admin -> readOne();
        $organization_id = $admin -> organization_id;
    }

    $admin = new OrganizationAdminModel($pdo);
    $admin -> organization_id = $organization_id;
    $admins = $admin -> readAllByOrganizationId();
    // var_dump($providers);
    require_once __DIR__ . '/Views/ManageAdmin/manageAdminView.php';
?>


</body>
</html>