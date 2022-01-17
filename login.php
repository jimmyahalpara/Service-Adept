<?php
    // echo "<pre>";
    // define LOADER to true
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";

    // require database connection
    require_once __DIR__ . "/database/configuration.php";


    function setLoginError($message)
    {
        $_SESSION['loginError'] = $message;
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    // var_dump($_POST);
    if (isset($_POST['submit'])){
        if (isset($_POST['email']) && isset($_POST['password'])){
            // validate email
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                setLoginError("Invalid Email or Password");
                return;
            }
            // validate password
            $password = $_POST['password'];
            if (strlen($password) == 0){
                setLoginError("Password is required");
                return;
            }

            $user = new UserModel($pdo);
            $user -> email = $email;
            
            if ($user -> isEmailPresent()){
                $hashedPassword = UserModel::hashPassword($password);
                $user -> readOneUsingEmail();
                if ($user -> password === $hashedPassword){
                    $_SESSION['user_id'] = $user -> id;
                    $_SESSION['username'] = $user -> username;
                    $_SESSION['email'] = $user -> email;
                    $_SESSION['name'] = $user -> name;
                    $_SESSION['access_level'] = $user -> access_level;

                    
                    header("Location: " . dirname($_SERVER['PHP_SELF']). "/userDetail.php");
                    return;
                } else {
                    setLoginError("Invalid Email or Password");
                    return;
                }
            } else {
                setLoginError("Invalid Email or Password");
                return;
            }

        } else {
            setLoginError("All Fields are required");
            return;
        }
    }

    // echo "</pre>"


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</body>
    <?php
        require_once __DIR__ . '/Views/Login/login.php';
    ?>
</html>