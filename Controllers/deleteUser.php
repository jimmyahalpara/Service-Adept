    <?php 
    session_start();
    
    // import all models
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginRequired();
    
    function setUserUpdateError($error){
        $_SESSION['userUpdateError'] = $error;
        header("Location: /service_adept/userMyaccount.php");
    }
    // var_dump($_POST);
    if (isset($_POST['submit'])){
        $user = new UserModel($pdo);
        $user -> id = $_SESSION['user_id'];
        
        $user -> readOne();
        
        if ($user -> access_level == 1){
            $user -> delete();
            session_destroy();
            header("Location: /service_adept/");
        } else if ($user -> access_level == 2 || $user -> access_level == 3){
            setUserUpdateError("Cannot delete your account because you are Manager or Provider. Contact your organization admin");
            return;
        } else if ($user -> access_level == 4){
            $user_id = $user -> id;
            
            // // get organization id
            $admin = new OrganizationAdminModel($pdo);
            $admin -> user_id = $user_id;
            $admin -> readOne();
            // var_dump($admin);
            $organization_id = $admin -> organization_id;
            
            // get all organizationAdmin in organization
            $organizationAdmin = new OrganizationAdminModel($pdo);
            $organizationAdmin -> organization_id = $organization_id;
            // var_dump($organizationAdmin);
            $admins = $organizationAdmin -> readAllByOrganizationId();
            // var_dump( count($admins) );
            if (count($admins) == 1){
                setUserUpdateError("Cannot delete your account because you are the only admin in your organization.");
                return;
            } else if (count($admins) > 1){
                $admin -> delete();
                $user -> delete();
                session_destroy();
                header("Location: /service_adept/userMyaccount.php");
                return;
            }
            

        }
        
    }
    
    
    ?>
