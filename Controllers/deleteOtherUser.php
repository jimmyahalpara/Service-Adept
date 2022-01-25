<pre>
    <?php 
    session_start();
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginAccessRequired(3);
    
    
    function setUserCreationError($message){
        $_SESSION['createUserError'] = $message;
        var_dump($_SESSION['createUserError']);
        if ($_POST['access_level'] == 2){
            header("Location: /service_adept/manageProviders.php");
        } else if ($_POST['access_level'] == 3){
            header("Location: /service_adept/manageManagers.php");
        } else if ($_POST['access_level'] == 4){
            header("Location: /service_adept/manageAdmin.php");
        }
    }
    if (isset($_POST['submit']) && isset($_SESSION['access_level']) && ($_SESSION['access_level'] == 3 || $_SESSION['access_level'] == 4)){
        if (isset($_POST['access_level']) && isset($_POST['user_id'])){
            
            
            if ($_POST['access_level'] == 2){
                if ($_SESSION['access_level'] == 4){
                    // get organization id for current user
                    $admin = new OrganizationAdminModel($pdo);
                    $admin -> user_id = $_SESSION['user_id'];
                    $admin -> readOne();
                    $organization_id = $admin -> organization_id;
                } else if ($_SESSION['access_level'] == 3) {
                    $manager = new OrganizationManagerModel($pdo);
                    $manager -> user_id = $_SESSION['user_id'];
                    $manager -> readOne();
                    $organization_id = $manager -> organization_id;
                }
                // create new Provider 
                $provider = new ProviderModel($pdo);
                $provider -> user_id = $_POST['user_id'];
                $provider -> delete();
                
                // reduce access level of that user
                $user = new UserModel($pdo);
                $user -> id = $_POST['user_id'];
                $user -> readOne();
                
                $user -> access_level = 1;
                $user -> update();
                // set login required for user 
                $user -> setReloginRequired();
                
                if (isset($_POST['delete_user']) && $_POST['delete_user'] == 1){
                    // delete user
                    $user -> delete();
                }
                // redirect to manageProviders
                header("Location: /service_adept/manageProviders.php");
                
            } else if ($_POST['access_level'] == 3){
                if ($_SESSION['access_level'] == 4){
                    // get organization id for current user
                    $admin = new OrganizationAdminModel($pdo);
                    $admin -> user_id = $_SESSION['user_id'];
                    $admin -> readOne();
                    $organization_id = $admin -> organization_id;
                    // create new Provider 
                    $manager = new OrganizationManagerModel($pdo);
                    $manager -> user_id = $_POST['user_id'];
                    $manager -> delete();
                    
                    // reduce access level of that user
                    $user = new UserModel($pdo);
                    $user -> id = $_POST['user_id'];
                    $user -> readOne();
                    
                    $user -> access_level = 1;
                    $user -> update();
                    // set login required for user 
                    $user -> setReloginRequired();
                } 
                
                if (isset($_POST['delete_user']) && $_POST['delete_user'] == 1){
                    // delete user
                    $user -> delete();
                }
                // redirect to manageProviders
                header("Location: /service_adept/manageManagers.php");
                
            } else if ($_POST['access_level'] == 4){
                if ($_SESSION['access_level'] == 4){
                    if ($_POST['user_id'] == $_SESSION['user_id']){
                        setUserCreationError("You cannot delete yourself! Do it from My Account page");
                        return;
                    }
                    // get organization id for current user
                    $admin = new OrganizationAdminModel($pdo);
                    $admin -> user_id = $_SESSION['user_id'];
                    $admin -> readOne();
                    $organization_id = $admin -> organization_id;
                    // create new Provider 
                    $manager = new OrganizationAdminModel($pdo);
                    $manager -> user_id = $_POST['user_id'];
                    $manager -> readOne();
                    // var_dump($manager);
                    $manager -> delete();
                    
                    // reduce access level of that user
                    $user = new UserModel($pdo);
                    $user -> id = $_POST['user_id'];
                    $user -> readOne();
                    
                    $user -> access_level = 1;
                    $user -> update();
                    // set login required for user 
                    $user -> setReloginRequired();
                } 
                
                if (isset($_POST['delete_user']) && $_POST['delete_user'] == 1){
                    // delete user
                    $user -> delete();
                }
                // redirect to manageProviders
                header("Location: /service_adept/manageAdmin.php");
                
            }
            
            
        }
    } else {
        setUserCreationError("You do not have permission to delete this user");
    }
    
    ?>
    </pre>