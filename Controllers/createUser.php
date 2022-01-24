<?php 
    session_start();
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginAccessRequired(3);
    

    function setUserCreationError($message){
        $_SESSION['createUserError'] = $message;
        var_dump($_SESSION['createUserError']);
        header("Location: /service_adept/manageProviders.php");
    }
    if (isset($_POST['submit']) && isset($_SESSION['access_level']) && ($_SESSION['access_level'] == 3 || $_SESSION['access_level'] == 4)){
        if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['gender']) && isset($_POST['access_level'])){

            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password_1 = $_POST['password_1'];
            $password_2 = $_POST['password_2'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $gender = $_POST['gender'];

            // checking if email is valid
            if (strlen($name) == 0 || strlen($username) == 0 || strlen($email) == 0 || strlen($password_1) == 0 || strlen($phone) == 0 || strlen($address) == 0 || strlen($city) == 0 || strlen($gender) == 0){
                setUserCreationError("All Fields are required");
                return;
            }

            if ($password_1 != $password_2){
                setUserCreationError("Passwords Do not match!!");
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                setUserCreationError("Invalid Email");
                return;
            }

            $user = new UserModel($pdo);
            // check if username already exists
            $user -> username = $username;
            if ($user -> isUsernamePresent()){
                setUserCreationError("Username already exists");
                return;
            } 

            $user -> email = $email;
            if ($user -> isEmailPresent()){
                setUserCreationError("Email already exists");
                return;
            }
            $user -> username = $username;
            $user -> name = $name;
            $user -> email = $email;
            // hash the password
            $user -> password = UserModel::hashPassword($password_1);
            $user -> phone = $phone;
            $user -> address = $address;
            $user -> city_id = $city;
            $user -> access_level = $_POST['access_level'];
            $user -> create();
            // header("Location: ". dirname($_SERVER['PHP_SELF']). "/login.php");
            // return;

            if ($_POST['access_level'] == 2){
                if ($_SESSION['access_level'] == 4){
                    // get organization id for current user
                    $admin = new OrganizationAdminModel($pdo);
                    $admin -> user_id = $_SESSION['user_id'];
                    $admin -> readOne();
                    $organization_id = $admin -> organization_id;
                } else if ($_SESSION['access_level']) {
                    $manager = new OrganizationManagerModel($pdo);
                    $manager -> user_id = $_SESSION['user_id'];
                    $manager -> readOne();
                    $organization_id = $manager -> organization_id;
                }
                // create new Provider 
                $provider = new ProviderModel($pdo);
                $provider -> user_id = $user -> id;
                $provider -> organization_id = $organization_id;
                $provider -> create();
            } 


        }
    }
    




?>