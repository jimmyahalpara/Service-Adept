<?php
    // start session
    session_start();
    // define LOADER in true
    define("LOADER", true);
    // requre all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
    
    function setUserCreationError($message){
        // var_dump("TOOO");
        $_SESSION['createUserError'] = $message;
        header("Location: ".$_SERVER['PHP_SELF']);
    }
    // var_dump($_POST);
    if (isset($_POST['submit'])){
        if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['gender'])){

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
            var_dump($user -> isUsernamePresent());
            if ($user -> isUsernamePresent()){
                setUserCreationError("Username already exists");
                return;
            } 

            $user -> email = $email;
            if ($user -> isEmailPresent()){
                var_dump("Going here");
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
            $user -> access_level = 1;
            $user -> create();
            header("Location: ". dirname($_SERVER['PHP_SELF']). "/login.php");
            return;


        }
    }
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>    
    <?php
        // require_once __DIR__ . "/Views/CreateUserView/createUserView.php";
        require_once __DIR__ . "/Views/Signup/signup.php";
    ?>
</body>
</html>